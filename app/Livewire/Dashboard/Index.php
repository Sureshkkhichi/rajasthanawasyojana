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

    public int $activeProjects = 0;
    public int $upcomingProjects = 0;

    public float $totalAmount = 0;
    public float $totalRefund = 0;

    public float $totalCollection = 0;
    public float $pendingAmount = 0;
    public float $bookingAmount = 0;

    public int $draftLeads = 0;
    public int $submittedLeads = 0;
    public int $paidLeads = 0;
    public int $pendingLeads = 0;
    public int $inProcessLeads = 0;
    public int $unpaidLeads = 0;
    public float $conversionRate = 0;

    // Project Status Chart
    public array $projectStatusLabels = [];
    public array $projectStatusData = [];

    // Collection vs Refund Weekly Chart
    public array $weeklyCollection = [];
    public array $weeklyRefund = [];

    // Sales Trend (Overview)
    public array $salesTrendDays = [];
    public array $salesTrendCollection = [];
    public array $salesTrendPending = [];
    public array $salesTrendBooking = [];
    public array $salesTrendRefund = [];

    public string $fromDate = '';
    public string $toDate = '';

    public function mount(): void
    {
        $this->fromDate = now()->startOfMonth()->format('Y-m-d');
        $this->toDate = now()->endOfMonth()->format('Y-m-d');
        $this->loadDashboard();
    }
    protected function loadDashboard(): void
    {
        $startDate = $this->fromDate ? \Carbon\Carbon::parse($this->fromDate)->startOfDay() : now()->startOfMonth();
        $endDate = $this->toDate ? \Carbon\Carbon::parse($this->toDate)->endOfDay() : now()->endOfMonth();

        $this->totalLeads = Lead::whereBetween('created_at', [$startDate, $endDate])->count();
        $this->totalProjects = Project::count();

        $this->activeProjects = Project::where('status', 'active')->count();
        $this->upcomingProjects = Project::where('status', 'upcoming')->count();

        $this->draftLeads = Lead::draft()->whereBetween('created_at', [$startDate, $endDate])->count();
        $this->submittedLeads = Lead::submitted()->whereBetween('created_at', [$startDate, $endDate])->count();
        $this->paidLeads = Lead::paid()->whereBetween('created_at', [$startDate, $endDate])->count();
        $this->pendingLeads = Lead::pendingPayment()->whereBetween('created_at', [$startDate, $endDate])->count();
        $this->inProcessLeads = Lead::inProcess()->whereBetween('created_at', [$startDate, $endDate])->count();
        $this->unpaidLeads = Lead::pendingPayment()->whereBetween('created_at', [$startDate, $endDate])->count();

        $this->totalDeals = Deal::whereBetween('created_at', [$startDate, $endDate])->count();

        $bookingAmountVal = (float) \App\Models\FrontendSetting::getVal('booking_amount', 21100.00);

        $this->totalAmount = Lead::submitted()->whereBetween('created_at', [$startDate, $endDate])->count() * $bookingAmountVal;

        $this->totalRefund = Deal::where('status', 'Refund')->whereBetween('created_at', [$startDate, $endDate])->count() * $bookingAmountVal;

        $this->totalCollection = Deal::where('status', '!=', 'Refund')->whereBetween('created_at', [$startDate, $endDate])->count() * $bookingAmountVal;

        $this->pendingAmount = Lead::pendingPayment()->whereBetween('created_at', [$startDate, $endDate])->count() * $bookingAmountVal;

        $this->bookingAmount = Deal::whereBetween('created_at', [$startDate, $endDate])->count() * $bookingAmountVal;

        $this->conversionRate = $this->totalLeads > 0 
            ? round(($this->paidLeads / $this->totalLeads) * 100, 2) 
            : 0;

        // Project Status Donut Series
        $completedProjects = Project::where('status', 'completed')->count();
        $holdProjects = Project::where('status', 'hold')->count();
        $cancelledProjects = Project::where('status', 'cancelled')->count();
        $this->projectStatusLabels = ["Completed", "Active", "Upcoming", "On Hold", "Cancelled"];
        $this->projectStatusData = [
            $completedProjects,
            $this->activeProjects,
            $this->upcomingProjects,
            $holdProjects,
            $cancelledProjects
        ];

        // Sales Trend within the selected range
        $days = [];
        $trendCollection = [];
        $trendPending = [];
        $trendBooking = [];
        $trendRefund = [];

        $diffInDays = $startDate->diffInDays($endDate);
        if ($diffInDays > 60) {
            $diffInDays = 60;
        }
        if ($diffInDays < 1) {
            $diffInDays = 1;
        }

        for ($i = $diffInDays; $i >= 0; $i--) {
            $currentDate = (clone $endDate)->subDays($i);
            $dateStr = $currentDate->format('Y-m-d');
            $dateLabel = $currentDate->format('d M');
            $days[] = $dateLabel;

            // Collection (Paid Deals)
            $trendCollection[] = round(Deal::where('status', '!=', 'Refund')
                ->whereDate('created_at', $dateStr)
                ->count() * $bookingAmountVal / 100000, 2);

            // Pending
            $trendPending[] = round(Lead::pendingPayment()
                ->whereDate('created_at', $dateStr)
                ->count() * $bookingAmountVal / 100000, 2);

            // Booking (Submitted)
            $trendBooking[] = round(Lead::submitted()
                ->whereDate('created_at', $dateStr)
                ->count() * $bookingAmountVal / 100000, 2);

            // Refund (Refunded Deals)
            $trendRefund[] = round(Deal::where('status', 'Refund')
                ->whereDate('created_at', $dateStr)
                ->count() * $bookingAmountVal / 100000, 2);
        }

        $this->salesTrendDays = $days;
        $this->salesTrendCollection = $trendCollection;
        $this->salesTrendPending = $trendPending;
        $this->salesTrendBooking = $trendBooking;
        $this->salesTrendRefund = $trendRefund;

        // Group leads by registration hour
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $hourlyStats = Lead::query()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw("strftime('%H', created_at) as hour"), DB::raw('count(*) as count'))
                ->groupBy('hour')
                ->pluck('count', 'hour')
                ->toArray();
        } else {
            $hourlyStats = Lead::query()
                ->whereBetween('created_at', [$startDate, $endDate])
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
        $leads = Lead::select('date_of_birth')
            ->whereNotNull('date_of_birth')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
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
            ->whereBetween('created_at', [$startDate, $endDate])
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

        // Collection vs Refund (This Month - Weekly Breakdown)
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $week1Start = $startOfMonth->copy();
        $week1End = $startOfMonth->copy()->addDays(6)->endOfDay();

        $week2Start = $startOfMonth->copy()->addDays(7)->startOfDay();
        $week2End = $startOfMonth->copy()->addDays(13)->endOfDay();

        $week3Start = $startOfMonth->copy()->addDays(14)->startOfDay();
        $week3End = $startOfMonth->copy()->addDays(20)->endOfDay();

        $week4Start = $startOfMonth->copy()->addDays(21)->startOfDay();
        $week4End = $endOfMonth->copy()->endOfDay();

        $weeks = [
            ['start' => $week1Start, 'end' => $week1End],
            ['start' => $week2Start, 'end' => $week2End],
            ['start' => $week3Start, 'end' => $week3End],
            ['start' => $week4Start, 'end' => $week4End],
        ];

        $this->weeklyCollection = [];
        $this->weeklyRefund = [];

        foreach ($weeks as $week) {
            $colCount = Deal::where('status', '!=', 'Refund')
                ->whereBetween('created_at', [$week['start'], $week['end']])
                ->count();
            $this->weeklyCollection[] = ($colCount * $bookingAmountVal) / 100000;

            $refCount = Deal::where('status', 'Refund')
                ->whereBetween('created_at', [$week['start'], $week['end']])
                ->count();
            $this->weeklyRefund[] = ($refCount * $bookingAmountVal) / 100000;
        }

        $this->dispatch('dashboard-updated', [
            'paidLeads' => $this->paidLeads,
            'pendingLeads' => $this->pendingLeads,
            'draftLeads' => $this->draftLeads,
            'inProcessLeads' => $this->inProcessLeads,
            'unpaidLeads' => $this->unpaidLeads,
            'projectStatusData' => $this->projectStatusData,
            'totalCollection' => $this->totalCollection,
            'bookingAmount' => $this->bookingAmount,
            'totalRefund' => $this->totalRefund,
            'pendingAmount' => $this->pendingAmount,
            'weeklyCollection' => $this->weeklyCollection,
            'weeklyRefund' => $this->weeklyRefund,
            'salesTrendCollection' => $this->salesTrendCollection,
            'salesTrendPending' => $this->salesTrendPending,
            'salesTrendBooking' => $this->salesTrendBooking,
            'salesTrendRefund' => $this->salesTrendRefund,
            'salesTrendDays' => $this->salesTrendDays,
            'hourlyData' => $this->hourlyData,
            'ageData' => $this->ageData,
            'cityData' => $this->cityData,
            'cityLabels' => $this->cityLabels,
        ]);
    }

    public function render()
    {
        $this->loadDashboard();

        $startDate = $this->fromDate ? \Carbon\Carbon::parse($this->fromDate)->startOfDay() : now()->startOfMonth();
        $endDate = $this->toDate ? \Carbon\Carbon::parse($this->toDate)->endOfDay() : now()->endOfMonth();

        return view('livewire.dashboard.index', [
            'recentLeads' => Lead::whereBetween('created_at', [$startDate, $endDate])->latest()->limit(10)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
        ]);
    }
}