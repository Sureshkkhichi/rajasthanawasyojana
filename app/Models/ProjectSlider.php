<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectSlider extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'image',
        'sort_order',
        'show_on_homepage',
        'is_active',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}