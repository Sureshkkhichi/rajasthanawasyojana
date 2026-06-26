<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InformationImage extends Model
{
    use HasUuids;

    protected $fillable = ['image_path', 'sort_order'];
}
