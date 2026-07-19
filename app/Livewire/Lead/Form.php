<?php
namespace App\Livewire\Lead;

use App\Models\Lead;
use App\Models\Project;
use App\Models\State;
use App\Models\City;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Lead Form')]
class Form extends Component
{
    public ?Lead $lead = null;
    public $states = [];
    public $cities = [];
    public $projects = [];
    public ?string $project_id = null;
    public array $sizes = [];
    public string $project_inventory_type = 'flat';
    public string $first_name = '';
    public string $last_name = '';
    public ?string $father_husband_name = null;
    public ?string $pan_number = null;
    public ?string $gender = null;
    public string $email = '';
    public string $phone = '';
    public ?string $date_of_birth = null;
    public ?string $occupation = null;
    public ?string $address = null;
    public ?int $state_id = null;
    public ?int $city_id = null;
    public ?string $city = null;
    public ?string $co_applicant_name = null;
    public ?string $flat_size = null;
    public ?string $waiver_code = null;
    public string $status = 'in_process';
    public string $payment_status = 'pending';

    public function mount(?Lead $lead = null): void
    {
        abort_unless(
            auth()->user()->can('leads.edit'),
            403
        );
        $this->lead = $lead ?? new Lead();
        if ($this->lead->exists && is_null($this->lead->created_by)) {
            abort(403, 'Website leads cannot be edited.');
        }
        $this->states = State::orderBy('name')->get();
        $this->projects = Project::orderBy('name')->get();

        if ($this->lead->exists) {
            $this->fill([
                'project_id' => $lead->project_id,
                'first_name' => $lead->first_name ?? '',
                'last_name' => $lead->last_name ?? '',
                'father_husband_name' => $lead->father_husband_name,
                'pan_number' => $lead->pan_number,
                'gender' => $lead->gender,
                'email' => $lead->email ?? '',
                'phone' => $lead->phone ?? '',
                'date_of_birth' => $lead->date_of_birth ? $lead->date_of_birth->format('Y-m-d') : null,
                'occupation' => $lead->occupation,
                'address' => $lead->address,
                'state_id' => $lead->state_id,
                'city' => $lead->city,
                'co_applicant_name' => $lead->co_applicant_name,
                'flat_size' => $lead->flat_size,
                'waiver_code' => $lead->waiver_code,
                'status' => $lead->status ?? 'in_process',
                'payment_status' => $lead->payment_status ?? 'pending',
            ]);

            if ($this->state_id) {
                $this->cities = City::where('state_id', $this->state_id)->orderBy('name')->get();
                if ($this->city) {
                    $cityModel = City::where('state_id', $this->state_id)->where('name', $this->city)->first();
                    if ($cityModel) {
                        $this->city_id = $cityModel->id;
                    }
                }
            }
        } else {
            $rajasthan = State::where('name', 'Rajasthan')->first();
            if ($rajasthan) {
                $this->state_id = $rajasthan->id;
                $this->cities = City::where('state_id', $this->state_id)->orderBy('name')->get();
            }
        }

        $this->loadSizes();
    }

    private function loadSizes(): void
    {
        $this->sizes = [];
        if (!$this->project_id) {
            return;
        }
        $project = Project::find($this->project_id);
        if (!$project) {
            return;
        }

        $this->project_inventory_type = $project->inventory_type;

        if ($project->inventory_type === 'flat') {
            $this->sizes = \App\Models\Inventory::query()
                ->where('project_id', $this->project_id)
                ->where('inventory_type', 'flat')
                ->whereNotNull('unit_type')
                ->where('unit_type', '!=', '')
                ->distinct()
                ->orderBy('unit_type')
                ->pluck('unit_type')
                ->toArray();
        } else {
            $this->sizes = \App\Models\Inventory::query()
                ->where('project_id', $this->project_id)
                ->where('inventory_type', 'plot')
                ->whereNotNull('area_sq_yards')
                ->distinct()
                ->orderBy('area_sq_yards')
                ->pluck('area_sq_yards')
                ->toArray();
        }
    }

    public function updatedStateId($value): void
    {
        if ($value) {
            $this->cities = City::where('state_id', $value)->orderBy('name')->get();
        } else {
            $this->cities = [];
        }
        $this->city_id = null;
        $this->city = null;
    }

    public function updatedCityId($value): void
    {
        if ($value) {
            $cityModel = City::find($value);
            $this->city = $cityModel ? $cityModel->name : null;
        } else {
            $this->city = null;
        }
    }

    public function updatedProjectId($value): void
    {
        $this->project_id = $value;
        $this->loadSizes();
        $this->flat_size = null;
    }

    protected function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'father_husband_name' => ['nullable', 'string', 'max:255'],
            'pan_number' => ['required', 'string', 'max:10'],
            'gender' => ['required'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[6-9][0-9]{9}$/'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'occupation' => ['required', 'in:' . implode(',', array_keys(config('constants.occupations')))],
            'address' => ['required', 'string'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'flat_size' => ['required', 'string'],
            'co_applicant_name' => ['nullable', 'string', 'max:255'],
            'waiver_code' => ['nullable', 'string', 'max:50'],
            'status' => ['required'],
            'payment_status' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_of_birth.before_or_equal' => 'Age must be 18 years or older.',
            'phone.regex' => 'Phone must be a valid 10-digit mobile number.',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $stateModel = State::find($this->state_id);
        $stateName = $stateModel ? $stateModel->name : null;

        $data = [
            'project_id' => $this->project_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_husband_name' => $this->father_husband_name,
            'pan_number' => $this->pan_number,
            'gender' => $this->gender,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth ?: null,
            'occupation' => $this->occupation,
            'address' => $this->address,
            'state_id' => $this->state_id,
            'state_name' => $stateName,
            'city' => $this->city,
            'co_applicant_name' => $this->co_applicant_name,
            'flat_size' => $this->flat_size,
            'waiver_code' => $this->waiver_code,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
        ];

        if ($this->lead->exists && is_null($this->lead->created_by)) {
            abort(403, 'Website leads cannot be edited.');
        }

        if ($this->lead->exists) {
            $this->lead->update($data);
            session()->flash('success', 'Lead updated successfully.');
        } else {
            $data['created_by'] = auth()->id();
            $data['is_submitted'] = true;
            $this->lead = Lead::create($data);
            session()->flash('success', 'Lead created successfully.');
            return redirect()->route('leads.index');
        }
    }

    public function render()
    {
        return view('livewire.lead.form');
    }
}