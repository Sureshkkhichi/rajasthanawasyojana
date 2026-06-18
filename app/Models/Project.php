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
        'name',
        'slug',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'status',
        'is_active',
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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function sliders()
    {
        return $this->hasMany(ProjectSlider::class)
            ->orderBy('sort_order');
    }
}