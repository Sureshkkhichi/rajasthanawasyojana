<?php

namespace App\Livewire\Setting;

use App\Models\FrontendSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('System Settings')]
class Index extends Component
{
    public string $booking_amount = '21100';
    public string $waiver_discount_amount = '0';

    public function mount(): void
    {
        $this->booking_amount = FrontendSetting::getVal('booking_amount', '21100');
        $this->waiver_discount_amount = FrontendSetting::getVal('waiver_discount_amount', '0');
    }

    public function saveSettings(): void
    {
        $this->validate([
            'booking_amount' => ['required', 'numeric', 'min:0'],
            'waiver_discount_amount' => ['required', 'numeric', 'min:0'],
        ], [
            'booking_amount.required' => 'Booking Amount is required.',
            'booking_amount.numeric' => 'Booking Amount must be a valid number.',
            'booking_amount.min' => 'Booking Amount cannot be negative.',
            'waiver_discount_amount.required' => 'Waiver Code Discount Amount is required.',
            'waiver_discount_amount.numeric' => 'Waiver Code Discount Amount must be a valid number.',
            'waiver_discount_amount.min' => 'Waiver Code Discount Amount cannot be negative.',
        ]);

        FrontendSetting::setVal('booking_amount', $this->booking_amount);
        FrontendSetting::setVal('waiver_discount_amount', $this->waiver_discount_amount);

        $this->dispatch('swal:alert', [
            'title' => 'Settings Saved!',
            'text' => 'Booking Amount and Waiver Discount Settings updated successfully.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.setting.index');
    }
}
