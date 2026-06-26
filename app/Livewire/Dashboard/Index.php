<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Lead;
use App\Models\Project;
use App\Models\Deal;
use App\Models\Invoice;
use App\Models\Refund;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Index extends Component
{
    public int $totalLeads = 0;
    public int $totalProjects = 0;
    public int $totalDeals = 0;

    public float $invoiceAmount = 0;
    public float $refundAmount = 0;

    public array $hourlyLabels = [];
    public array $hourlyData = [];

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

        // Group leads by registration hour
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $hourlyStats = Lead::query()
                ->select(DB::raw("strftime('%H', created_at) as hour"), DB::raw('count(*) as count'))
                ->groupBy('hour')
                ->pluck('count', 'hour')
                ->toArray();
        } else {
            $hourlyStats = Lead::query()
                ->select(DB::raw("DATE_FORMAT(created_at, '%H') as hour"), DB::raw('count(*) as count'))
                ->groupBy('hour')
                ->pluck('count', 'hour')
                ->toArray();
        }

        $labels = [];
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $hourKey = sprintf('%02d', $i);
            $hourNum = $i === 0 ? 12 : ($i > 12 ? $i - 12 : $i);
            $ampm = $i >= 12 ? 'PM' : 'AM';
            $labels[] = "$hourNum $ampm";
            $data[] = isset($hourlyStats[$hourKey]) ? (int)$hourlyStats[$hourKey] : 0;
        }

        $this->hourlyLabels = $labels;
        $this->hourlyData = $data;
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'recentLeads' => Lead::latest()->limit(10)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
        ]);
    }
}