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

    // Allotment Modal & Status tracking properties
    public bool $allotModalOpen = false;
    public ?string $allotDealId = null;
    public ?string $selectedUnitId = null;
    public array $selectedUnitDetails = [];
    public $availableUnits = [];

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

    public function changeDealStatus(string $dealId, string $newStatus): void
    {
        $deal = Deal::find($dealId);
        if ($deal) {
            if ($newStatus === 'Not Alloted' && $deal->allotted_inventory_id) {
                $unit = \App\Models\Inventory::find($deal->allotted_inventory_id);
                if ($unit) {
                    $oldStatus = $unit->status;
                    $unit->update(['status' => 'Available']);

                    \App\Models\InventoryHistory::create([
                        'inventory_id' => $unit->id,
                        'from_status' => $oldStatus,
                        'to_status' => 'Available',
                        'changed_by' => auth()->user()->name,
                        'notes' => 'Unit vacated because Deal was marked Not Alloted.',
                    ]);
                }
                $deal->update([
                    'deal_status' => $newStatus,
                    'status'      => $newStatus,
                    'allotted_inventory_id' => null,
                    'allotted_at' => null
                ]);
            } else {
                $deal->update([
                    'deal_status' => $newStatus,
                    'status'      => $newStatus,
                ]);
            }

            $this->dispatch('swal:alert', [
                'title' => 'Status Updated!',
                'text' => 'Deal status updated to ' . $newStatus . ' successfully.',
                'icon' => 'success'
            ]);
        }
    }

    public function openAllotModal(string $dealId): void
    {
        $deal = Deal::find($dealId);
        if ($deal) {
            $this->allotDealId = $dealId;
            $this->selectedUnitId = null;
            $this->selectedUnitDetails = [];
            
            $this->availableUnits = \App\Models\Inventory::where('project_id', $deal->project_id)
                ->where('status', 'Available')
                ->get();

            $this->allotModalOpen = true;
        }
    }

    public function updatedSelectedUnitId($value): void
    {
        if ($value) {
            $unit = \App\Models\Inventory::find($value);
            if ($unit) {
                if ($unit->inventory_type === 'flat') {
                    $this->selectedUnitDetails = [
                        'type' => 'Flat',
                        'label' => 'Flat No: ' . $unit->flat_no . ' (' . $unit->floor . ' Floor)',
                        'info1' => $unit->unit_type,
                        'info2' => '-',
                        'price' => $unit->price,
                    ];
                } else {
                    $this->selectedUnitDetails = [
                        'type' => 'Plot',
                        'label' => 'Plot No: ' . $unit->plot_no,
                        'info1' => 'Area: ' . $unit->area_sq_yards . ' Sq. Yards',
                        'info2' => 'Road Size: ' . $unit->road_size,
                        'price' => $unit->price,
                    ];
                }
            }
        } else {
            $this->selectedUnitDetails = [];
        }
    }

    public function submitAllotment(): void
    {
        $this->validate([
            'selectedUnitId' => 'required|exists:inventories,id',
        ]);

        $deal = Deal::find($this->allotDealId);
        $unit = \App\Models\Inventory::find($this->selectedUnitId);

        if ($deal && $unit) {
            $deal->update([
                'allotted_inventory_id' => $unit->id,
                'allotted_at' => now(),
            ]);

            $oldStatus = $unit->status;
            $unit->update(['status' => 'Sold']);

            \App\Models\InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $oldStatus,
                'to_status' => 'Sold',
                'changed_by' => auth()->user()->name,
                'notes' => 'Unit allotted via Deal Action Allotment: ' . $deal->first_name . ' ' . $deal->last_name,
            ]);

            $this->allotModalOpen = false;

            $this->dispatch('swal:alert', [
                'title' => 'Allotment Successful!',
                'text' => 'Unit ' . ($unit->inventory_type === 'flat' ? $unit->flat_no : $unit->plot_no) . ' has been allotted to the deal.',
                'icon' => 'success'
            ]);
        }
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
        self::expireOldAllotments();

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

        $query = Deal::query()->with(['project', 'agent', 'allottedInventory']);

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

    public static function expireOldAllotments(): void
    {
        $expiredDeals = Deal::query()
            ->whereNotNull('allotted_inventory_id')
            ->where('status', '!=', 'Sold')
            ->where(function($q) {
                $q->where('allotted_at', '<=', now()->subDays(7))
                  ->orWhere(function($sub) {
                      $sub->whereNull('allotted_at')
                          ->where('updated_at', '<=', now()->subDays(7));
                  });
            })
            ->get();

        foreach ($expiredDeals as $deal) {
            $unit = \App\Models\Inventory::find($deal->allotted_inventory_id);
            if ($unit) {
                $oldStatus = $unit->status;
                $unit->update(['status' => 'Available']);

                \App\Models\InventoryHistory::create([
                    'inventory_id' => $unit->id,
                    'from_status' => $oldStatus,
                    'to_status' => 'Available',
                    'changed_by' => 'System (Auto-expiry)',
                    'notes' => 'Unit allotment automatically cancelled after 7 days without being marked Sold.',
                ]);
            }

            $deal->update([
                'allotted_inventory_id' => null,
                'allotted_at' => null,
                'status' => 'Not Alloted',
            ]);
        }
    }
}