<?php
namespace App\Livewire\Frontend;
use App\Models\Lead;
use App\Models\Project;
use App\Models\State;
use App\Models\City;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadSubmittedMail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('layouts.front')]
#[Title('Registration Form')]
class Booking extends Component
{
    public Project $project;
    public ?Lead $lead = null;
    public $states = [];
    public $cities = [];
    /*
    |--------------------------------------------------------------------------
    | Personal Information
    |--------------------------------------------------------------------------
    */
    public string $first_name = '';
    public string $last_name = '';
    public string $father_husband_name = '';
    public string $pan_number = '';
    public string $gender = '';
    public string $email = '';
    public string $phone = '';
    public ?string $date_of_birth = null;
    public string $occupation = '';
    /*
    |--------------------------------------------------------------------------
    | Address Information
    |--------------------------------------------------------------------------
    */
    public string $address = '';
    public ?string $state_id = null;
    public ?string $state_name = null;
    public ?string $city_id = null;
    public string $city = '';
    /*
    |--------------------------------------------------------------------------
    | Flat Information
    |--------------------------------------------------------------------------
    */
    public string $co_applicant_name = '';
    public string $flat_size = '';
    public string $waiver_code = '';
    /*
    |--------------------------------------------------------------------------
    | Terms
    |--------------------------------------------------------------------------
    */
    public bool $terms = false;
    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->states = State::query()
            ->where('country_id', 101)
            ->orderBy('name')
            ->get();
        $rajasthan = State::query()
            ->where('name', 'Rajasthan')
            ->first();
        if ($rajasthan) {
            $this->state_id = $rajasthan->id;
            $this->state_name = $rajasthan->name;
            $this->cities = City::query()
                ->where('state_id', $this->state_id)
                ->orderBy('name')
                ->get();
        }
    }
    public function updated($property): void
    {
        if (
            !in_array($property, [
                'first_name',
                'last_name',
                'father_husband_name',
                'pan_number',
                'gender',
                'email',
                'phone',
                'date_of_birth',
                'occupation',
                'address',
                'state_id',
                'city_id',
                'city',
                'co_applicant_name',
                'flat_size',
                'waiver_code',
            ])
        ) {
            return;
        }

        if (empty(trim($this->phone))) {
            if ($property === 'state_id') {
                $state = State::find($this->state_id);
                $this->state_name = $state ? $state->name : null;
                $this->cities = City::query()
                    ->where('state_id', $this->state_id)
                    ->orderBy('name')
                    ->get();
                $this->city_id = null;
                $this->city = '';
            }
            if ($property === 'city_id') {
                $cityModel = City::find($this->city_id);
                $this->city = $cityModel ? $cityModel->name : '';
            }
            return;
        }

        if ($property === 'state_id') {
            $state = State::find($this->state_id);
            $this->state_name = $state ? $state->name : null;
            $this->cities = City::query()
                ->where('state_id', $this->state_id)
                ->orderBy('name')
                ->get();
            $this->city_id = null;
            $this->city = '';

            if ($this->lead === null) {
                $this->lead = Lead::create([
                    'project_id' => $this->project->id,
                    'state_id' => $this->state_id,
                    'state_name' => $this->state_name,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } else {
                $this->lead->update([
                    'state_id' => $this->state_id,
                    'state_name' => $this->state_name,
                    'city_id' => null,
                    'city' => null,
                ]);
            }
            return;
        }

        if ($property === 'city_id') {
            $cityModel = City::find($this->city_id);
            $this->city = $cityModel ? $cityModel->name : '';

            if ($this->lead === null) {
                $this->lead = Lead::create([
                    'project_id' => $this->project->id,
                    'state_id' => $this->state_id,
                    'state_name' => $this->state_name,
                    'city_id' => $this->city_id,
                    'city' => $this->city,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } else {
                $this->lead->update([
                    'city_id' => $this->city_id,
                    'city' => $this->city,
                ]);
            }
            return;
        }

        if ($this->lead === null) {
            $this->lead = Lead::create([
                'project_id' => $this->project->id,
                'state_id' => $this->state_id,
                'state_name' => $this->state_name,
                'city_id' => $this->city_id,
                'city' => $this->city,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
        $value = $this->{$property};
        if ($value === '') {
            $value = null;
        }
        if (is_string($value)) {
            if (
                in_array($property, [
                    'first_name',
                    'last_name',
                    'father_husband_name',
                    'address',
                    'city',
                    'co_applicant_name',
                ])
            ) {
                $value = ucwords(strtolower(trim($value)));
                $this->{$property} = $value;
            }
            if ($property === 'pan_number') {
                $value = strtoupper(trim($value));
                $this->{$property} = $value;
            }
        }
        $this->lead->update([
            $property => $value,
        ]);
    }
    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'pan_number' => ['required', 'string', 'max:10'],
            'gender' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'occupation' => ['required'],
            'address' => ['required'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'flat_size' => ['required'],
            'terms' => ['accepted'],
        ];
    }
    public function messages(): array
    {
        return [
            'date_of_birth.before_or_equal' => 'Age must be 18 years or older.',
        ];
    }
    public function submit()
    {
        $validated = $this->validate();
        if ($this->lead === null) {
            $this->lead = Lead::create([
                'project_id' => $this->project->id,
                'state_id' => $this->state_id,
                'state_name' => $this->state_name,
                'city_id' => $this->city_id,
                'city' => $this->city,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
        $validated['first_name'] = ucwords(strtolower($validated['first_name']));
        $validated['last_name'] = ucwords(strtolower($validated['last_name']));
        $validated['address'] = ucwords(strtolower($validated['address']));
        $validated['pan_number'] = strtoupper($validated['pan_number']);
        if (!empty($validated['father_husband_name'])) {
            $validated['father_husband_name'] =
                ucwords(strtolower($validated['father_husband_name']));
        }
        if (!empty($validated['co_applicant_name'])) {
            $validated['co_applicant_name'] =
                ucwords(strtolower($validated['co_applicant_name']));
        }
        $this->lead->update([
            ...$validated,
            'state_name' => $this->state_name,
            'city' => $this->city,
            'project_id' => $this->project->id,
            'is_submitted' => true,
        ]);

        Mail::to($this->lead->email)->cc('suresh5313@gmail.com')->send(new LeadSubmittedMail($this->lead));

        session()->flash(
            'success',
            'Your registration form has been submitted successfully.'
        );


        $this->reset([
            'first_name',
            'last_name',
            'father_husband_name',
            'pan_number',
            'gender',
            'email',
            'phone',
            'date_of_birth',
            'occupation',
            'address',
            'city_id',
            'city',
            'co_applicant_name',
            'flat_size',
            'waiver_code',
            'terms',
        ]);

        $this->lead = null;

        $rajasthan = State::query()
            ->where('name', 'Rajasthan')
            ->first();
        if ($rajasthan) {
            $this->state_id = $rajasthan->id;
            $this->state_name = $rajasthan->name;
            $this->cities = City::query()
                ->where('state_id', $this->state_id)
                ->orderBy('name')
                ->get();
        }

        return redirect()->route(
            'booking',
            ['project' => $this->project->id]
        );
    }
    public function render()
    {
        return view('livewire.frontend.booking');
    }
}