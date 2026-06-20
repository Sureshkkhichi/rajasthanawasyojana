<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Sales Report')]
class Sales extends Component
{
    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('reports.sales'),
            403
        );
    }

    public function render()
    {
        return view('livewire.report.sales');
    }
}