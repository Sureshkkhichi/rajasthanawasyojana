<?php
namespace App\Livewire\Components;
use App\Models\Lead;
use App\Support\Sidebar;
use Livewire\Component;
use App\Livewire\Actions\Logout;


class Menu extends Component
{
    public function refreshSidebar(): void
    {
        //
    }
    public function badgeCounts(): array
    {
        return [
            'fresh' => 0,
        ];
    }
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
    public function render()
    {
        return view(
            'livewire.components.menu',
            [
                'sidebar' => Sidebar::menus(),
                'counts' => $this->badgeCounts(),
            ]
        );
    }
}
