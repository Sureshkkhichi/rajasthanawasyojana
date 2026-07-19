<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Inventory;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Deal\Show as DealShow;

class DealAllotmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_allot_unit_and_cancel_allotment()
    {
        $user = User::create([
            'name' => 'Test Admin',
            'username' => 'testadmin',
            'email' => 'admin@example.com',
            'mobile' => '9876543210',
            'password' => bcrypt('password'),
            'user_type' => 'superadmin',
            'is_active' => 'yes',
        ]);
        $this->actingAs($user);

        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'leads.view', 'guard_name' => 'web']);
        $user->givePermissionTo('leads.view');

        $projectType = \App\Models\ProjectType::create([
            'name' => 'Residential',
            'slug' => 'residential',
            'status' => 'active',
        ]);

        $project = Project::create([
            'project_type_id' => $projectType->id,
            'name' => 'Nav Nilay',
            'slug' => 'nav-nilay',
            'inventory_type' => 'flat',
            'price' => 350000.00,
            'status' => 'active',
            'is_active' => 'active',
        ]);

        $inventory = Inventory::create([
            'project_id' => $project->id,
            'inventory_type' => 'flat',
            'flat_no' => '510',
            'unit_type' => 'EWS',
            'floor' => '5th Floor',
            'price' => 350000.00,
            'status' => 'Available',
            'area_sbup' => 635.00,
            'carpet_area' => 500.00,
        ]);

        $deal = Deal::create([
            'project_id' => $project->id,
            'first_name' => 'Pooja',
            'last_name' => 'Sharma',
            'pan_number' => 'ABCDE1234F',
            'gender' => 'female',
            'email' => 'pooja@example.com',
            'phone' => '8336908948',
            'date_of_birth' => '1995-08-04',
            'occupation' => 'Business',
            'address' => 'Jaipur, Rajasthan',
            'flat_size' => '2BHK',
            'booking_date' => now(),
            'booking_amount' => 21100.00,
            'total_amount' => 350000.00,
            'status' => 'Paid',
        ]);

        \Illuminate\Support\Facades\Mail::fake();

        Livewire::test(DealShow::class, ['deal' => $deal])
            ->call('allotInventory', $inventory->id)
            ->assertHasNoErrors();

        $inventory->refresh();
        $deal->refresh();

        $this->assertEquals('Alloted', $inventory->status);
        $this->assertEquals($inventory->id, $deal->allotted_inventory_id);

        Livewire::test(DealShow::class, ['deal' => $deal])
            ->call('cancelAllotment')
            ->assertHasNoErrors();

        $inventory->refresh();
        $deal->refresh();

        $this->assertEquals('Available', $inventory->status);
        $this->assertNull($deal->allotted_inventory_id);
    }
}
