<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Lead;
use App\Models\Project;
use App\Models\Deal;
use App\Models\Invoice;
use App\Models\Refund;

#[Layout('layouts.app')]
class Index extends Component
{
    public int $totalLeads = 0;
    public int $totalProjects = 0;
    public int $totalDeals = 0;

    public float $invoiceAmount = 0;
    public float $refundAmount = 0;

    public function mount(): void
    {
        $this->loadDashboard();
    }

    protected function loadDashboard(): void
    {
        $this->totalLeads = Lead::count();

        $this->totalProjects = Project::count();

        $this->totalDeals = 0;

        $this->invoiceAmount = 0;

        $this->refundAmount = 0;
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'recentLeads' => Lead::latest()->limit(10)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
        ]);
    }
}