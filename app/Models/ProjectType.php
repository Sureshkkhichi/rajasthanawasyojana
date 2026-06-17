<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectType extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'project_type',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];
}