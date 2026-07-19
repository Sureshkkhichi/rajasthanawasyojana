<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'project_type_id',
        'flat_id',
        'inventory_type',
        'name',
        'slug',
        'city',
        'address',
        'status',
        'is_active',
        'featured_image',
        'price',
        'registration_status',
    ];

    protected static function booted()
    {
        static::deleting(function ($project) {
            if ($project->isForceDeleting()) {
                // 1. Delete featured image from disk
                if ($project->featured_image && \Illuminate\Support\Facades\File::exists(public_path($project->featured_image))) {
                    \Illuminate\Support\Facades\File::delete(public_path($project->featured_image));
                }

                // 2. Delete all slider images from disk and force delete records
                $project->sliders()->get()->each(function ($slider) {
                    if ($slider->image && \Illuminate\Support\Facades\File::exists(public_path($slider->image))) {
                        \Illuminate\Support\Facades\File::delete(public_path($slider->image));
                    }
                    $slider->forceDelete();
                });

                // 3. Delete all information images from disk and delete records
                $project->informationImages()->get()->each(function ($infoImage) {
                    if ($infoImage->image_path && \Illuminate\Support\Facades\File::exists(public_path($infoImage->image_path))) {
                        \Illuminate\Support\Facades\File::delete(public_path($infoImage->image_path));
                    }
                    $infoImage->delete();
                });
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', 'active');
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function sliders()
    {
        return $this->hasMany(ProjectSlider::class)
            ->orderBy('sort_order');
    }

    public function informationImages()
    {
        return $this->hasMany(ProjectInformationImage::class)
            ->orderBy('sort_order');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
