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