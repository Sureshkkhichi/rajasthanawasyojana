<?php

namespace App\Livewire\Agent;

use App\Models\Agent;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Agent Form')]
class Form extends Component
{
    public ?Agent $agent = null;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $code = '';
    public string $commission_type = 'percentage';
    public float $commission_value = 0;
    public string $status = 'active';

    public function mount(?Agent $agent = null): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );

        if ($agent && $agent->exists) {
            $this->agent = $agent;
            $this->name = $agent->name;
            $this->email = $agent->email ?? '';
            $this->phone = $agent->phone ?? '';
            $this->code = $agent->code;
            $this->commission_type = $agent->commission_type;
            $this->commission_value = (float)$agent->commission_value;
            $this->status = $agent->status;
        } else {
            $this->generateCode();
        }
    }

    public function generateCode(): void
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $newCode = '';
            for ($i = 0; $i < 8; $i++) {
                $newCode .= $chars[rand(0, strlen($chars) - 1)];
            }
        } while (Agent::where('code', $newCode)->exists());

        $this->code = $newCode;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|regex:/^[6-9][0-9]{9}$/',
            'code' => 'required|string|size:8|alpha_num|unique:agents,code,' . ($this->agent->id ?? 'NULL'),
            'commission_type' => 'required|in:percentage,fixed',
            'commission_value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];

        $validated = $this->validate($rules, [
            'phone.regex' => 'The mobile number must be a valid 10-digit number.',
            'code.size' => 'The Waiver Code must be exactly 8 alphanumeric characters.',
            'code.alpha_num' => 'The Waiver Code must contain only alphanumeric characters.',
            'code.unique' => 'This Waiver Code has already been taken.',
        ]);

        if ($this->agent && $this->agent->exists) {
            $this->agent->update($validated);
            session()->flash('success', 'Agent updated successfully.');
        } else {
            Agent::create($validated);
            session()->flash('success', 'Agent created successfully.');
        }

        return redirect()->route('agents.index');
    }

    public function render()
    {
        return view('livewire.agent.form');
    }
}
