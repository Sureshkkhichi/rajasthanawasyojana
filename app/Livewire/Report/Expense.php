<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Expense Report')]
class Expense extends Component
{
    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('reports.expense'),
            403
        );
    }

    public function render()
    {
        return view('livewire.report.expense');
    }
}