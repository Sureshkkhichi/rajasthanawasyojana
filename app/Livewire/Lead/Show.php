<?php
namespace App\Livewire\Lead;
use App\Models\Lead;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Services\ActivityLogger;

#[Layout('layouts.app')]
#[Title('Lead Details')]
class Show extends Component
{
    public Lead $lead;
    public function mount(Lead $lead): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );
        $this->lead = $lead->load([
            'project',
            'state',
            'deal',
        ]);
    }
    public function sendMail(): void
    {
        ActivityLogger::logLead($this->lead, 'email_sent', 'Email Sent', "Sent email notification to {$this->lead->email}", ['recipient' => $this->lead->email]);
        $this->dispatch('activityLogged');

        $this->dispatch('swal:alert', [
            'title' => 'Mail Sent!',
            'text' => 'Mail successfully sent to ' . $this->lead->email,
            'icon' => 'success'
        ]);
    }

    public function sendSMS(): void
    {
        ActivityLogger::logLead($this->lead, 'sms_sent', 'SMS Sent', "Sent SMS notification to {$this->lead->phone}", ['phone' => $this->lead->phone]);
        $this->dispatch('activityLogged');

        $this->dispatch('swal:alert', [
            'title' => 'SMS Sent!',
            'text' => 'SMS successfully sent to ' . $this->lead->phone,
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.lead.show');
    }
}