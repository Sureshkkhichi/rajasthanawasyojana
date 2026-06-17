<?php

namespace App\Livewire\Project;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Project')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.project.index');
    }
}
