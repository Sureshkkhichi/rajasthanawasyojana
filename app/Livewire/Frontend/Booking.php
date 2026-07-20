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
    public array $sizes = [];
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

        $this->loadSizes();
    }

    private function loadSizes(): void
    {
        if ($this->project->inventory_type === 'flat') {
            $this->sizes = \App\Models\Inventory::query()
                ->where('project_id', $this->project->id)
                ->where('inventory_type', 'flat')
                ->whereNotNull('unit_type')
                ->where('unit_type', '!=', '')
                ->distinct()
                ->orderBy('unit_type')
                ->pluck('unit_type')
                ->toArray();
        } else {
            $this->sizes = \App\Models\Inventory::query()
                ->where('project_id', $this->project->id)
                ->where('inventory_type', 'plot')
                ->whereNotNull('area_sq_yards')
                ->distinct()
                ->orderBy('area_sq_yards')
                ->pluck('area_sq_yards')
                ->toArray();
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
            'phone' => ['required', 'string', 'regex:/^[6-9][0-9]{9}$/'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'occupation' => ['required'],
            'address' => ['required'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'flat_size' => ['required'],
            'terms' => ['accepted'],
            'waiver_code' => ['nullable', 'numeric', 'digits:8'],
        ];
    }
    public function messages(): array
    {
        return [
            'date_of_birth.before_or_equal' => 'Age must be 18 years or older.',
            'phone.regex' => 'Phone must be a valid 10-digit mobile number.',
            'waiver_code.numeric' => 'Waiver Code must contain only numbers.',
            'waiver_code.digits' => 'Waiver Code must be exactly 8 digits.',
        ];
    }
    public function submit()
    {
        $this->project->refresh();
        if ($this->project->registration_status === 'closed') {
            $this->dispatch('registrationClosed');
            return;
        }

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
            'payment_status' => 'paid',
        ]);

        // Find unit price or project price fallback for Deal total_amount
        $unitPrice = null;
        if ($this->project->inventory_type === 'flat') {
            $matchingUnit = \App\Models\Inventory::query()
                ->where('project_id', $this->project->id)
                ->where('inventory_type', 'flat')
                ->where('unit_type', $this->flat_size)
                ->first();
            if ($matchingUnit) {
                $unitPrice = $matchingUnit->price;
            }
        } else {
            $matchingUnit = \App\Models\Inventory::query()
                ->where('project_id', $this->project->id)
                ->where('inventory_type', 'plot')
                ->where('area_sq_yards', $this->flat_size)
                ->first();
            if ($matchingUnit) {
                $unitPrice = $matchingUnit->price;
            }
        }

        if (!$unitPrice) {
            $unitPrice = $this->project->price;
        }

        \App\Models\Deal::create([
            'project_id' => $this->project->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'father_husband_name' => $validated['father_husband_name'] ?? null,
            'pan_number' => $validated['pan_number'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'occupation' => $validated['occupation'],
            'address' => $validated['address'],
            'state_id' => $this->state_id,
            'state_name' => $this->state_name,
            'city_id' => $this->city_id,
            'city' => $this->city,
            'co_applicant_name' => $validated['co_applicant_name'] ?? null,
            'flat_size' => $this->flat_size,
            'waiver_code' => $this->waiver_code ?: null,
            'booking_date' => now(),
            'booking_amount' => 21100.00,
            'total_amount' => $unitPrice,
            'status' => 'Paid',
            'remarks' => null,
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