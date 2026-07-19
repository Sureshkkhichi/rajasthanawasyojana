<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Frontend\Booking as FrontendBooking;

class BookingRegistrationStatusTest extends TestCase
{
    use RefreshDatabase;

    private $project;

    protected function setUp(): void
    {
        parent::setUp();

        $projectType = \App\Models\ProjectType::create([
            'name' => 'Residential',
            'slug' => 'residential',
            'status' => 'active',
        ]);

        $this->project = Project::create([
            'project_type_id' => $projectType->id,
            'name' => 'Test Project',
            'slug' => 'test-project',
            'inventory_type' => 'flat',
            'price' => 350000.00,
            'status' => 'active',
            'is_active' => 'active',
            'registration_status' => 'open',
        ]);
    }

    public function test_booking_page_renders_form_when_registration_is_open()
    {
        $response = $this->get(route('booking', $this->project->id));
        $response->assertStatus(200);
        $response->assertSee('First Name');
        $response->assertSee('Proceed for Payment');
    }

    public function test_booking_page_renders_closed_message_when_registration_is_closed()
    {
        $this->project->update(['registration_status' => 'closed']);

        $response = $this->get(route('booking', $this->project->id));
        $response->assertStatus(200);
        $response->assertDontSee('First Name');
        $response->assertDontSee('Proceed for Payment');
        $response->assertSee('रजिस्ट्रेशन बंद हो गए हैं');
    }
}
