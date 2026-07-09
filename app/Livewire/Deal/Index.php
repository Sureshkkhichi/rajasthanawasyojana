<?php

namespace App\Livewire\Deal;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Deals')]
class Index extends Component
{
    public string $keyword = '';
    public string $status = '';
    public int $perPage = 20;

    public array $selectedDeals = [];
    public bool $selectAll = false;

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedDeals = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        } else {
            $this->selectedDeals = [];
        }
    }

    public function deleteSelected(): void
    {
        $this->selectedDeals = [];
        $this->selectAll = false;
        session()->flash('success', 'Selected deals deleted successfully.');
    }

    public function render()
    {
        $mockDeals = [
            [
                'id' => '1',
                'name' => 'Mohit Verma',
                'property' => 'Avya',
                'invoice_no' => '',
                'allotment_date' => '',
                'booking_date' => '2026-07-04 23:11:00',
                'booking_amount' => 21000,
                'area' => '',
                'total_amount' => 350000,
                'balance_due' => 328900,
                'status' => 'Paid',
                'agent' => '',
                'remarks' => ''
            ]
        ];

        if ($this->keyword) {
            $mockDeals = array_filter($mockDeals, function ($deal) {
                return stripos($deal['name'], $this->keyword) !== false ||
                    stripos($deal['property'], $this->keyword) !== false ||
                    stripos($deal['invoice_no'], $this->keyword) !== false ||
                    stripos($deal['status'], $this->keyword) !== false;
            });
        }

        return view('livewire.deal.index', [
            'deals' => $mockDeals
        ]);
    }
}