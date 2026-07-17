<?php

namespace App\Livewire\Deal;

use App\Models\Project;
use App\Models\Lead;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Deals')]
class Index extends Component
{
    public string $search_name = '';
    public string $search_mobile = '';
    public string $search_email = '';
    public string $project_id = '';
    public string $status = '';
    public string $search_city = '';
    public string $search_flat_size = '';
    public string $search_date = '';

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

    public function updatingSearchName(): void
    {
        $this->resetPage();
    }

    public function updatingSearchMobile(): void
    {
        $this->resetPage();
    }

    public function updatingSearchEmail(): void
    {
        $this->resetPage();
    }

    public function updatingProjectId(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSearchCity(): void
    {
        $this->resetPage();
    }

    public function updatingSearchFlatSize(): void
    {
        $this->resetPage();
    }

    public function updatingSearchDate(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search_name',
            'search_mobile',
            'search_email',
            'project_id',
            'status',
            'search_city',
            'search_flat_size',
            'search_date',
        ]);
        $this->resetPage();
    }

    private function resetPage(): void
    {
        // Placeholder to match WithPagination traits if added later
    }

    public function deleteSelected(): void
    {
        $this->selectedDeals = [];
        $this->selectAll = false;
        session()->flash('success', 'Selected deals deleted successfully.');
    }

    public function render()
    {
        $projects = Project::query()
            ->where('status', 'active')
            ->where('is_active', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        $cities = Lead::whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $mockDeals = [
            [
                'id' => '1',
                'name' => 'Mohit Verma',
                'property' => 'Aavya Home',
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

        // Apply filters to mock data to mimic real filtering
        if ($this->search_name) {
            $mockDeals = array_filter($mockDeals, function ($deal) {
                return stripos($deal['name'], $this->search_name) !== false;
            });
        }

        if ($this->status) {
            $mockDeals = array_filter($mockDeals, function ($deal) {
                return strcasecmp($deal['status'], $this->status) === 0;
            });
        }

        if ($this->project_id) {
            $project = Project::find($this->project_id);
            if ($project) {
                $mockDeals = array_filter($mockDeals, function ($deal) use ($project) {
                    return stripos($deal['property'], $project->name) !== false;
                });
            } else {
                $mockDeals = [];
            }
        }

        return view('livewire.deal.index', [
            'deals' => $mockDeals,
            'projects' => $projects,
            'cities' => $cities,
        ]);
    }
}