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
                'name' => 'SUNIL GAHLOT',
                'property' => 'Nav Nilay',
                'invoice_no' => '',
                'allotment_date' => '',
                'booking_date' => '2025-12-04 23:11:00',
                'booking_amount' => null,
                'area' => '',
                'total_amount' => null,
                'balance_due' => 0,
                'status' => 'Refund',
                'agent' => '',
                'remarks' => 'Flat: 1651000 Waver code->'
            ],
            [
                'id' => '2',
                'name' => 'SUNIL GAHLOT',
                'property' => 'Nav Nilay',
                'invoice_no' => '',
                'allotment_date' => '',
                'booking_date' => '2025-12-04 23:11:00',
                'booking_amount' => null,
                'area' => '',
                'total_amount' => null,
                'balance_due' => 0,
                'status' => 'Unpaid',
                'agent' => '',
                'remarks' => 'Flat: 1651000 Waver code->'
            ],
            [
                'id' => '3',
                'name' => 'SUNIL GAHLOT',
                'property' => 'Nav Nilay',
                'invoice_no' => '',
                'allotment_date' => '',
                'booking_date' => '2025-12-04 23:11:00',
                'booking_amount' => null,
                'area' => '',
                'total_amount' => null,
                'balance_due' => 0,
                'status' => 'Unpaid',
                'agent' => '',
                'remarks' => 'Flat: 1651000 Waver code->'
            ],
            [
                'id' => '4',
                'name' => 'BUDDHI PRAKASH',
                'property' => 'Nav Nilay',
                'invoice_no' => 'RAJAWS-2025-15236',
                'allotment_date' => '01-12-2025',
                'booking_date' => '2025-12-01 08:43:00',
                'booking_amount' => 21100.00,
                'area' => '635.00 Sq. Ft.',
                'total_amount' => 1651000.00,
                'balance_due' => 1651000.00,
                'status' => 'Partial',
                'agent' => '',
                'remarks' => 'Flat: 1651000 Waver code->'
            ],
            [
                'id' => '5',
                'name' => 'Satyanarayan Puri',
                'property' => 'Nav Nilay',
                'invoice_no' => '',
                'allotment_date' => '',
                'booking_date' => '2025-11-30 17:28:00',
                'booking_amount' => null,
                'area' => '',
                'total_amount' => null,
                'balance_due' => 0,
                'status' => 'Unpaid',
                'agent' => '',
                'remarks' => 'Flat: 1651000 Waver code->'
            ],
            [
                'id' => '6',
                'name' => 'Vijay Laxmi Gautam',
                'property' => 'Samriddhi',
                'invoice_no' => 'RAJAWS-2025-15234',
                'allotment_date' => '30-11-2025',
                'booking_date' => '2025-11-30 17:19:00',
                'booking_amount' => 21100.00,
                'area' => '563.81 Sq. Ft.',
                'total_amount' => 1550000.00,
                'balance_due' => 1550000.00,
                'status' => 'Partial',
                'agent' => '',
                'remarks' => 'Flat: 1550000 Waver code->'
            ],
            [
                'id' => '7',
                'name' => 'Gajendra Rawat',
                'property' => 'Nav Nilay',
                'invoice_no' => 'RAJAWS-2025-15233',
                'allotment_date' => '28-11-2025',
                'booking_date' => '2025-11-28 17:43:00',
                'booking_amount' => 21100.00,
                'area' => '651.00 Sq. Ft.',
                'total_amount' => 1651000.00,
                'balance_due' => 1651000.00,
                'status' => 'Partial',
                'agent' => '',
                'remarks' => 'Flat: 1651000 Waver code->4211'
            ],
            [
                'id' => '8',
                'name' => 'dharmendra sain',
                'property' => 'Samriddhi',
                'invoice_no' => 'RAJAWS-2025-15232',
                'allotment_date' => '28-11-2025',
                'booking_date' => '2025-11-28 15:04:00',
                'booking_amount' => 21000.00,
                'area' => '563.81 Sq. Ft.',
                'total_amount' => 1550000.00,
                'balance_due' => 1550000.00,
                'status' => 'Partial',
                'agent' => 'Deepti',
                'remarks' => 'Flat: 1550000 Waver code->4008'
            ],
            [
                'id' => '9',
                'name' => 'Opisar Meena',
                'property' => 'Rukmani Nagar',
                'invoice_no' => '',
                'allotment_date' => '',
                'booking_date' => '2025-11-27 12:33:00',
                'booking_amount' => null,
                'area' => '',
                'total_amount' => null,
                'balance_due' => 0,
                'status' => 'Unpaid',
                'agent' => '',
                'remarks' => 'Flat: 166.66 Waver code->'
            ],
        ];

        if ($this->keyword) {
            $mockDeals = array_filter($mockDeals, function($deal) {
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
