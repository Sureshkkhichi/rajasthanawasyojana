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
        'name',
        'slug',
        'city',
        'address',
        'status',
        'is_active',
        'show_on_homepage',
        'featured_image',
        'price',
        'registration_status',
    ];

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
}
