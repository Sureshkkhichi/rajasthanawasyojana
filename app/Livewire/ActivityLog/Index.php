<?php

namespace App\Livewire\ActivityLog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $logType = '';
    public $event = '';
    public $userId = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLogType()
    {
        $this->resetPage();
    }

    public function updatingEvent()
    {
        $this->resetPage();
    }

    public function updatingUserId()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'logType', 'event', 'userId', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function render()
    {
        $query = ActivityLog::with(['user', 'lead', 'deal', 'inventory'])->recent();

        if ($this->search) {
            $s = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', $s)
                  ->orWhere('description', 'like', $s)
                  ->orWhereHas('user', function ($uq) use ($s) {
                      $uq->where('name', 'like', $s)->orWhere('email', 'like', $s);
                  });
            });
        }

        if ($this->logType) {
            $query->where('log_type', $this->logType);
        }

        if ($this->event) {
            $query->where('event', $this->event);
        }

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $logs = $query->paginate(15);
        $users = User::orderBy('name')->get();

        return view('livewire.activity-log.index', [
            'logs' => $logs,
            'users' => $users,
        ])->layout('layouts.app');
    }
}
