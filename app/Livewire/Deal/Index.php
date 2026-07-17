<?php

namespace App\Livewire\Deal;

use App\Models\Project;
use App\Models\Deal;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Deals')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

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
            $this->selectedDeals = Deal::pluck('id')->map(fn($id) => (string)$id)->toArray();
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

    public function generateInvoice(string $id): void
    {
        $this->dispatch('swal:alert', [
            'title' => 'Invoice Generated!',
            'text' => 'Invoice has been successfully generated for Deal ID ' . $id,
            'icon' => 'success'
        ]);
    }

    public function sendSMS(string $id): void
    {
        $this->dispatch('swal:alert', [
            'title' => 'SMS Sent!',
            'text' => 'SMS notification sent successfully for Deal ID ' . $id,
            'icon' => 'success'
        ]);
    }

    public function sendEmail(string $id): void
    {
        $this->dispatch('swal:alert', [
            'title' => 'Email Sent!',
            'text' => 'Email notification sent successfully for Deal ID ' . $id,
            'icon' => 'success'
        ]);
    }

    public function viewFullForm(string $id): void
    {
        $this->dispatch('swal:alert', [
            'title' => 'Form Viewed!',
            'text' => 'Opening full booking form details for Deal ID ' . $id,
            'icon' => 'info'
        ]);
    }

    public function deleteSelected(): void
    {
        Deal::whereIn('id', $this->selectedDeals)->delete();
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

        $cities = Deal::whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $flatSizes = Deal::whereNotNull('flat_size')
            ->where('flat_size', '!=', '')
            ->distinct()
            ->orderBy('flat_size')
            ->pluck('flat_size');

        $query = Deal::query()->with(['project', 'agent']);

        if ($this->search_name) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search_name . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search_name . '%');
            });
        }

        if ($this->search_mobile) {
            $query->where('phone', 'like', '%' . $this->search_mobile . '%');
        }

        if ($this->search_email) {
            $query->where('email', 'like', '%' . $this->search_email . '%');
        }

        if ($this->project_id) {
            $query->where('project_id', $this->project_id);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->search_city) {
            $query->where('city', $this->search_city);
        }

        if ($this->search_flat_size) {
            $query->where('flat_size', $this->search_flat_size);
        }

        if ($this->search_date) {
            $query->whereDate('booking_date', $this->search_date);
        }

        $deals = $query->orderBy('booking_date', 'desc')->paginate($this->perPage);

        return view('livewire.deal.index', [
            'deals' => $deals,
            'projects' => $projects,
            'cities' => $cities,
            'flatSizes' => $flatSizes,
        ]);
    }
}