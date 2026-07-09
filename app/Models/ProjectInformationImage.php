<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectInformationImage extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id',
        'image_path',
        'sort_order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
