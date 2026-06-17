<?php

namespace App\Livewire\ProjectType;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Project Type')]

class Form extends Component
{
    public function render()
    {
        return view('livewire.project-type.form');
    }
}
