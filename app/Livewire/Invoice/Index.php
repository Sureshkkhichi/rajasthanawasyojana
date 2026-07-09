<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Deals')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.invoice.index');
    }
}