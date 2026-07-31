<?php
namespace App\Livewire\Forms;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $login = '';
    #[Validate('required|string')]
    public string $password = '';
    #[Validate('boolean')]
    public bool $remember = false;

    public function authenticate(): void
    {
        $ip = request()->ip();
        $loginInput = $this->login;

        Log::channel('single')->info('LOGIN_ATTEMPT', [
            'ip'       => $ip,
            'login'    => $loginInput,
            'time'     => now()->toDateTimeString(),
        ]);

        // --- Check rate limit ---
        $this->ensureIsNotRateLimited();

        // --- Check DB connection ---
        try {
            DB::connection()->getPdo();
            Log::channel('single')->info('LOGIN_DB_OK', ['connection' => config('database.default')]);
        } catch (\Exception $e) {
            Log::channel('single')->error('LOGIN_DB_FAIL', ['error' => $e->getMessage()]);
            throw ValidationException::withMessages(['form.login' => 'Database connection failed. Please contact support.']);
        }

        // --- Find user ---
        $user = User::query()
            ->where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        if (!$user) {
            Log::channel('single')->warning('LOGIN_USER_NOT_FOUND', ['login' => $loginInput]);
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'form.login' => trans('auth.failed'),
            ]);
        }

        Log::channel('single')->info('LOGIN_USER_FOUND', [
            'id'        => $user->id,
            'email'     => $user->email,
            'username'  => $user->username,
            'is_active' => $user->is_active,
        ]);

        if (!$user->is_active) {
            Log::channel('single')->warning('LOGIN_USER_INACTIVE', ['user_id' => $user->id]);
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'form.login' => 'Your account is inactive. Please contact the administrator.',
            ]);
        }

        // --- Attempt auth ---
        $attempted = Auth::attempt([
            'email'     => $user->email,
            'password'  => $this->password,
            'is_active' => true,
        ], $this->remember);

        if (!$attempted) {
            Log::channel('single')->warning('LOGIN_WRONG_PASSWORD', [
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'form.login' => trans('auth.failed'),
            ]);
        }

        Log::channel('single')->info('LOGIN_SUCCESS', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'ip'      => $ip,
        ]);

        RateLimiter::clear($this->throttleKey());
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }
        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());
        Log::channel('single')->warning('LOGIN_RATE_LIMITED', [
            'login'   => $this->login,
            'seconds' => $seconds,
        ]);
        throw ValidationException::withMessages([
            'form.login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->login) . '|' . request()->ip()
        );
    }
}