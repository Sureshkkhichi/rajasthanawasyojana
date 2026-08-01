<?php

namespace App\Livewire\Frontend;

use App\Models\Deal;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.front')]
class CheckAllotment extends Component
{
    public $mobile = '';
    public $searched = false;
    public $deals = [];

    protected $rules = [
        'mobile' => 'required|digits:10',
    ];

    protected $messages = [
        'mobile.required' => 'कृपया अपना 10 अंकों का मोबाइल नंबर दर्ज करें।',
        'mobile.digits' => 'मोबाइल नंबर 10 अंकों का होना चाहिए।',
    ];

    public function search()
    {
        $this->validate();

        $cleanMobile = trim($this->mobile);

        $this->deals = Deal::with(['project', 'allottedInventory'])
            ->where('phone', $cleanMobile)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.frontend.check-allotment');
    }
}
