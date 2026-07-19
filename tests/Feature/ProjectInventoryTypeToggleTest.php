<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Lead;
use App\Models\Deal;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Project\Index as ProjectIndex;

class ProjectInventoryTypeToggleTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test Admin',
            'username' => 'testadmin',
            'email' => 'admin@example.com',
            'mobile' => '9876543210',
            'password' => bcrypt('password'),
            'user_type' => 'superadmin',
            'is_active' => 'yes',
        ]);

        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'projects.view', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'projects.edit', 'guard_name' => 'web']);
        $this->user->givePermissionTo('projects.view');
        $this->user->givePermissionTo('projects.edit');

        $projectType = \App\Models\ProjectType::create([
            'name' => 'Residential',
            'slug' => 'residential',
            'status' => 'active',
        ]);

        $this->project = Project::create([
            'project_type_id' => $projectType->id,
            'name' => 'Nav Nilay',
            'slug' => 'nav-nilay',
            'inventory_type' => 'plot',
            'price' => 350000.00,
            'status' => 'active',
            'is_active' => 'active',
        ]);
    }

    public function test_can_toggle_inventory_type_when_no_records_exist()
    {
        $this->actingAs($this->user);

        Livewire::test(ProjectIndex::class)
            ->call('toggleInventoryType', $this->project->id)
            ->assertDispatched('swal:alert');

        $this->project->refresh();
        $this->assertEquals('flat', $this->project->inventory_type);
    }

    public function test_cannot_toggle_inventory_type_when_leads_exist()
    {
        $this->actingAs($this->user);

        Lead::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'project_id' => $this->project->id,
            'status' => 'in_process',
            'payment_status' => 'pending',
            'first_name' => 'John',
            'phone' => '9999999999',
        ]);

        Livewire::test(ProjectIndex::class)
            ->call('toggleInventoryType', $this->project->id)
            ->assertDispatched('swal:alert');

        $this->project->refresh();
        $this->assertEquals('plot', $this->project->inventory_type);
    }

    public function test_cannot_toggle_inventory_type_when_deals_exist()
    {
        $this->actingAs($this->user);

        Deal::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'project_id' => $this->project->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'pan_number' => 'ABCDE1234F',
            'gender' => 'female',
            'email' => 'jane@example.com',
            'phone' => '8888888888',
            'date_of_birth' => '1990-01-01',
            'occupation' => 'Job',
            'address' => 'Jaipur, Rajasthan',
            'flat_size' => '2BHK',
            'booking_date' => now(),
            'booking_amount' => 21100.00,
            'total_amount' => 350000.00,
            'status' => 'Paid',
        ]);

        Livewire::test(ProjectIndex::class)
            ->call('toggleInventoryType', $this->project->id)
            ->assertDispatched('swal:alert');

        $this->project->refresh();
        $this->assertEquals('plot', $this->project->inventory_type);
    }

    public function test_cannot_toggle_inventory_type_when_inventories_exist()
    {
        $this->actingAs($this->user);

        Inventory::create([
            'project_id' => $this->project->id,
            'inventory_type' => 'plot',
            'plot_no' => 'P-101',
            'price' => 500000,
            'status' => 'Available',
        ]);

        Livewire::test(ProjectIndex::class)
            ->call('toggleInventoryType', $this->project->id)
            ->assertDispatched('swal:alert');

        $this->project->refresh();
        $this->assertEquals('plot', $this->project->inventory_type);
    }
}
