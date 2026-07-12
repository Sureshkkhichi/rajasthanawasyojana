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

    public array $ageLabels = [];
    public array $ageData = [];
    public array $cityLabels = [];
    public array $cityData = [];

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

        // 1. Age Wise Distribution
        $leads = Lead::select('date_of_birth')->whereNotNull('date_of_birth')->get();
        $ageGroups = [
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56-65' => 0,
            '66+' => 0,
        ];
        foreach ($leads as $lead) {
            $dob = $lead->date_of_birth;
            if ($dob) {
                $age = $dob->age;
                if ($age >= 18 && $age <= 25) {
                    $ageGroups['18-25']++;
                } elseif ($age >= 26 && $age <= 35) {
                    $ageGroups['26-35']++;
                } elseif ($age >= 36 && $age <= 45) {
                    $ageGroups['36-45']++;
                } elseif ($age >= 46 && $age <= 55) {
                    $ageGroups['46-55']++;
                } elseif ($age >= 56 && $age <= 65) {
                    $ageGroups['56-65']++;
                } elseif ($age >= 66) {
                    $ageGroups['66+']++;
                }
            }
        }
        $this->ageLabels = array_keys($ageGroups);
        $this->ageData = array_values($ageGroups);

        // 2. City Wise Distribution (Top 10)
        $cityStats = Lead::query()
            ->select('city', DB::raw('count(*) as count'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'city')
            ->toArray();

        $this->cityLabels = array_keys($cityStats);
        $this->cityData = array_values($cityStats);
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'recentLeads' => Lead::latest()->limit(10)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
        ]);
    }
}