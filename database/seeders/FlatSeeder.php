<?php

namespace Database\Seeders;

use App\Models\Flat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FlatSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['1BHK', '2BHK', '3BHK'] as $name) {
            Flat::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'status' => 'active',
                ]
            );
        }
    }
}
