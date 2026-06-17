<?php
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
new #[Layout('layouts.guest')] #[Title('Login')] class extends Component {
    public LoginForm $form;
    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>
<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form wire:submit="login">
        <div class="mb-3">
            <x-input-label for="login" :value="__('Username / Email')" />
            <x-text-input wire:model="form.login" id="login" type="text" name="login"
                placeholder="Username or Email" required autofocus />
            <x-input-error :messages="$errors->get('form.login')" class="mt-2" />
        </div>
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <div class="position-relative auth-pass-inputgroup mb-3">
                <x-text-input wire:model="form.password" class="pe-5 password-input" id="password-input" type="password"
                    name="password" placeholder="Password" required autocomplete="current-password" />
                <button
                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>
        <div class="form-check">
            <label for="remember" class="form-check-label">
                <input wire:model="form.remember" id="remember" type="checkbox" class="form-check-input"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="mt-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
