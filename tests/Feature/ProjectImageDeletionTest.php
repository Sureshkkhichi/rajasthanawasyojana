<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectSlider;
use App\Models\ProjectInformationImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;
use App\Livewire\Project\Form as ProjectForm;

class ProjectImageDeletionTest extends TestCase
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
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'projects.delete', 'guard_name' => 'web']);
        $this->user->givePermissionTo('projects.view');
        $this->user->givePermissionTo('projects.edit');
        $this->user->givePermissionTo('projects.delete');

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

        // Create base directory for uploads in public if they do not exist
        if (!File::exists(public_path('uploads/projects/sliders'))) {
            File::makeDirectory(public_path('uploads/projects/sliders'), 0755, true);
        }
        if (!File::exists(public_path('uploads/projects/information'))) {
            File::makeDirectory(public_path('uploads/projects/information'), 0755, true);
        }
    }

    protected function tearDown(): void
    {
        // Clean up any remaining test uploads
        if (File::exists(public_path('uploads/projects'))) {
            File::deleteDirectory(public_path('uploads/projects'));
        }
        parent::tearDown();
    }

    public function test_deleting_project_deletes_all_its_images_from_disk()
    {
        $this->actingAs($this->user);

        // 1. Setup mock images
        $featImgName = 'feat_' . time() . '.jpg';
        $featPath = public_path('uploads/projects/' . $featImgName);
        File::put($featPath, 'dummy data');
        $this->project->update(['featured_image' => 'uploads/projects/' . $featImgName]);

        $sliderImgName = 'slider_' . time() . '.jpg';
        $sliderPath = public_path('uploads/projects/sliders/' . $sliderImgName);
        File::put($sliderPath, 'dummy data');
        $slider = ProjectSlider::create([
            'project_id' => $this->project->id,
            'title' => 'Slider 1',
            'image' => 'uploads/projects/sliders/' . $sliderImgName,
            'sort_order' => 1,
            'is_active' => 'active',
        ]);

        $infoImgName = 'info_' . time() . '.jpg';
        $infoPath = public_path('uploads/projects/information/' . $infoImgName);
        File::put($infoPath, 'dummy data');
        $infoImg = ProjectInformationImage::create([
            'project_id' => $this->project->id,
            'image_path' => 'uploads/projects/information/' . $infoImgName,
            'sort_order' => 1,
        ]);

        // Verify files exist on disk
        $this->assertTrue(File::exists($featPath));
        $this->assertTrue(File::exists($sliderPath));
        $this->assertTrue(File::exists($infoPath));

        // 2. Perform project deletion
        $this->project->forceDelete();

        // Verify files and DB records are gone
        $this->assertFalse(File::exists($featPath));
        $this->assertFalse(File::exists($sliderPath));
        $this->assertFalse(File::exists($infoPath));

        $this->assertDatabaseMissing('projects', ['id' => $this->project->id]);
        $this->assertDatabaseMissing('project_sliders', ['id' => $slider->id]);
        $this->assertDatabaseMissing('project_information_images', ['id' => $infoImg->id]);
    }

    public function test_deleting_single_slider_deletes_it_from_db_and_disk()
    {
        $this->actingAs($this->user);

        $sliderImgName = 'slider_' . time() . '.jpg';
        $sliderPath = public_path('uploads/projects/sliders/' . $sliderImgName);
        File::put($sliderPath, 'dummy data');
        $slider = ProjectSlider::create([
            'project_id' => $this->project->id,
            'title' => 'Slider 1',
            'image' => 'uploads/projects/sliders/' . $sliderImgName,
            'sort_order' => 1,
            'is_active' => 'active',
        ]);

        $this->assertTrue(File::exists($sliderPath));

        Livewire::test(ProjectForm::class, ['project' => $this->project])
            ->call('deleteSlider', $slider->id)
            ->assertHasNoErrors();

        $this->assertFalse(File::exists($sliderPath));
        $this->assertDatabaseMissing('project_sliders', ['id' => $slider->id]);
    }

    public function test_deleting_single_info_image_deletes_it_from_db_and_disk()
    {
        $this->actingAs($this->user);

        $infoImgName = 'info_' . time() . '.jpg';
        $infoPath = public_path('uploads/projects/information/' . $infoImgName);
        File::put($infoPath, 'dummy data');
        $infoImg = ProjectInformationImage::create([
            'project_id' => $this->project->id,
            'image_path' => 'uploads/projects/information/' . $infoImgName,
            'sort_order' => 1,
        ]);

        $this->assertTrue(File::exists($infoPath));

        Livewire::test(ProjectForm::class, ['project' => $this->project])
            ->call('deleteInfoImage', $infoImg->id)
            ->assertHasNoErrors();

        $this->assertFalse(File::exists($infoPath));
        $this->assertDatabaseMissing('project_information_images', ['id' => $infoImg->id]);
    }

    public function test_replacing_featured_image_deletes_old_image_from_disk()
    {
        $this->actingAs($this->user);

        // Setup old featured image
        $oldImgName = 'old_feat.jpg';
        $oldPath = public_path('uploads/projects/' . $oldImgName);
        File::put($oldPath, 'dummy data');
        $this->project->update(['featured_image' => 'uploads/projects/' . $oldImgName]);

        $this->assertTrue(File::exists($oldPath));

        // Upload new featured image via Livewire Form
        Storage::fake('public');
        $newFile = UploadedFile::fake()->image('new_feat.jpg');

        Livewire::test(ProjectForm::class, ['project' => $this->project])
            ->set('featured_image_file', $newFile)
            ->call('save')
            ->assertHasNoErrors();

        // Old image should be deleted from disk
        $this->assertFalse(File::exists($oldPath));
    }
}
