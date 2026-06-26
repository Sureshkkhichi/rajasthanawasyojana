<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Term and Condition',
                'slug' => 'terms-and-conditions',
            ],
            [
                'title' => 'Privacy policy',
                'slug' => 'privacy-policy',
            ],
            [
                'title' => 'Cancellation Refund policy',
                'slug' => 'cancellation-refund-policy',
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'content' => '<p>Content will be updated soon.</p>',
                    'status' => 'active',
                ]
            );
        }
    }
}
