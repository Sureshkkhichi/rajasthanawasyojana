<?php
namespace App\Livewire\Lead;
use App\Models\Lead;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('layouts.app')]
#[Title('Leads')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public string $search_name = '';
    public string $search_mobile = '';
    public string $search_email = '';
    public string $project_id = '';
    public string $status = '';

    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );
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

    public function export()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=leads_' . now()->format('Y-m-d_H-i-s') . '.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper excel formatting of special chars
            fputs($file, "\xEF\xBB\xBF");

            // Headers
            fputcsv($file, [
                'First Name',
                'Last Name',
                'Mobile',
                'Email',
                'Father/Husband Name',
                'PAN Number',
                'Gender',
                'DOB',
                'Occupation',
                'Address',
                'State',
                'City',
                'Co Applicant',
                'Flat Size',
                'Waiver Code',
                'Project',
                'Lead Status',
                'Enquiry Date',
                'Enquiry Time'
            ]);

            // Query with same filters as listing
            $leadsQuery = Lead::query()
                ->with([
                    'project:id,name',
                    'state:id,name',
                ])
                ->when(
                    $this->search_name,
                    fn($query) => $query->where(function ($q) {
                        $q->where('first_name', 'like', "%{$this->search_name}%")
                          ->orWhere('last_name', 'like', "%{$this->search_name}%");
                    })
                )
                ->when(
                    $this->search_mobile,
                    fn($query) => $query->where('phone', 'like', "%{$this->search_mobile}%")
                )
                ->when(
                    $this->search_email,
                    fn($query) => $query->where('email', 'like', "%{$this->search_email}%")
                )
                ->when(
                    $this->project_id,
                    fn($query) => $query->where('project_id', $this->project_id)
                )
                ->when(
                    $this->status !== '',
                    fn($query) => $query->where('status', $this->status)
                )
                ->latest();

            foreach ($leadsQuery->get() as $lead) {
                fputcsv($file, [
                    $lead->first_name,
                    $lead->last_name,
                    $lead->phone,
                    $lead->email,
                    $lead->father_husband_name,
                    $lead->pan_number,
                    ucfirst($lead->gender ?? ''),
                    $lead->date_of_birth ? $lead->date_of_birth->format('Y-m-d') : '',
                    $lead->occupation,
                    $lead->address,
                    $lead->state?->name ?? '',
                    $lead->city,
                    $lead->co_applicant_name,
                    $lead->flat_size,
                    $lead->waiver_code,
                    $lead->project?->name ?? '',
                    config('constants.lead_statuses.' . $lead->status, $lead->status),
                    $lead->created_at?->format('d M Y') ?? '',
                    $lead->created_at?->format('h:i A') ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'leads_' . now()->format('Y-m-d_H-i') . '.csv', $headers);
    }

    public function delete(string $id): void
    {
        abort_unless(
            auth()->user()->can('leads.delete'),
            403
        );
        $lead = Lead::findOrFail($id);
        $lead->delete();
        session()->flash(
            'success',
            'Lead deleted successfully.'
        );
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::query()
            ->where('status', 'active')
            ->where('is_active', 'active')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        $leads = Lead::query()
            ->with([
                'project:id,name',
                'state:id,name',
            ])
            ->when(
                $this->search_name,
                fn($query) => $query->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->search_name}%")
                      ->orWhere('last_name', 'like', "%{$this->search_name}%");
                })
            )
            ->when(
                $this->search_mobile,
                fn($query) => $query->where('phone', 'like', "%{$this->search_mobile}%")
            )
            ->when(
                $this->search_email,
                fn($query) => $query->where('email', 'like', "%{$this->search_email}%")
            )
            ->when(
                $this->project_id,
                fn($query) =>
                $query->where('project_id', $this->project_id)
            )
            ->when(
                $this->status !== '',
                fn($query) =>
                $query->where(
                    'status',
                    $this->status
                )
            )
            ->latest()
            ->paginate(20);

        return view('livewire.lead.index', [
            'leads' => $leads,
            'projects' => $projects,
        ]);
    }
}