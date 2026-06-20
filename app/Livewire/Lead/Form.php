<?php
namespace App\Livewire\Lead;
use App\Models\Lead;
use App\Models\Project;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('layouts.app')]
#[Title('Lead Form')]
class Form extends Component
{
    public ?Lead $lead = null;
    public $states = [];
    public $projects = [];
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
    public ?string $city = null;
    public ?string $co_applicant_name = null;
    public ?string $flat_size = null;
    public ?string $waiver_code = null;
    public string $status = 'in_process';
    public function mount(?Lead $lead = null): void
    {
        abort_unless(
            auth()->user()->can('leads.edit'),
            403
        );
        $this->lead = $lead;
        $this->states = State::orderBy('name')->get();
        $this->projects = Project::orderBy('name')->get();
        if ($this->lead) {
            $this->fill([
                'first_name' => $lead->first_name ?? '',
                'last_name' => $lead->last_name ?? '',
                'father_husband_name' => $lead->father_husband_name,
                'pan_number' => $lead->pan_number,
                'gender' => $lead->gender,
                'email' => $lead->email ?? '',
                'phone' => $lead->phone ?? '',
                'date_of_birth' => $lead->date_of_birth,
                'occupation' => $lead->occupation,
                'address' => $lead->address,
                'state_id' => $lead->state_id,
                'city' => $lead->city,
                'co_applicant_name' => $lead->co_applicant_name,
                'flat_size' => $lead->flat_size,
                'waiver_code' => $lead->waiver_code,
                'status' => $lead->status ?? 'in_process',
            ]);
        }
    }
    protected function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'status' => ['required'],
        ];
    }
    public function save(): void
    {
        $validated = $this->validate();
        $this->lead->update([
            ...$validated,
            'father_husband_name' => $this->father_husband_name,
            'pan_number' => $this->pan_number,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'occupation' => $this->occupation,
            'address' => $this->address,
            'state_id' => $this->state_id,
            'city' => $this->city,
            'co_applicant_name' => $this->co_applicant_name,
            'flat_size' => $this->flat_size,
            'waiver_code' => $this->waiver_code,
        ]);
        session()->flash(
            'success',
            'Lead updated successfully.'
        );
    }
    public function render()
    {
        return view('livewire.lead.form');
    }
}