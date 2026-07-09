<?php

namespace App\Livewire\Refund;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Deals')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.refund.index');
    }
}