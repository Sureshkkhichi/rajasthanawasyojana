<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class HomeSlider extends Model
{
    use HasUuids;
    protected $fillable = [
        'title',
        'subtitle',
        'desktop_image',
        'mobile_image',
        'button_text',
        'button_link',
        'sort_order',
        'status',
    ];
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
    public function getSliderUrlAttribute(): string
    {
        if (empty($this->button_link)) {
            return '#';
        }
        if (str_starts_with($this->button_link, 'project:')) {
            $projectId = str_replace('project:', '', $this->button_link);
            $project = Project::find($projectId);
            return route('project.show', $project->slug);
        }
        return $this->button_link;
    }
    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */
    protected static function booted(): void
    {
        static::deleting(function (HomeSlider $slider) {
            // Delete Desktop Image
            if (
                !empty($slider->desktop_image) &&
                File::exists(public_path($slider->desktop_image))
            ) {
                File::delete(public_path($slider->desktop_image));
            }
            // Delete Mobile Image
            if (
                !empty($slider->mobile_image) &&
                File::exists(public_path($slider->mobile_image))
            ) {
                File::delete(public_path($slider->mobile_image));
            }
        });
    }
}