<?php
namespace App\Support;
class Sidebar
{
    public static function menus(): array
    {
        return [
            // DASHBOARD
            'dashboard' => [
                [
                    'title' => 'Dashboard',
                    'route' => 'dashboard',
                    'is_route' => true,
                    'icon' => 'ri-dashboard-line',
                    'permission' => 'dashboard.view',
                ],
            ],
            // PROJECTS
            'project_types' => [
                [
                    'title' => 'Project Type',
                    'route' => 'project-types.index',
                    'is_route' => true,
                    'icon' => 'ri-folder-2-line',
                    'permission' => 'project.type.view',
                ],
            ],
            // PROJECTS
            'projects' => [
                [
                    'title' => 'Projects',
                    'route' => 'projects.index',
                    'is_route' => true,
                    'icon' => 'ri-folder-2-line',
                    'permission' => 'projects.view',
                ],
            ],
            // LEADS
            'leads' => [
                [
                    'title' => 'Leads',
                    'route' => 'leads.index',
                    'is_route' => true,
                    'icon' => 'ri-sparkling-line',
                    'permission' => 'leads.view',
                    'badge' => [
                        'class' => 'bg-primary-subtle text-primary',
                        'key' => 'fresh',
                    ],
                ],
            ],
            // FINANCE
            'finance' => [
                [
                    'title' => 'Deals',
                    'route' => 'deals.index',
                    'is_route' => true,
                    'icon' => 'ri-hand-coin-line',
                    'permission' => 'deals.view',
                ],
                [
                    'title' => 'Invoices',
                    'route' => 'invoices.index',
                    'is_route' => true,
                    'icon' => 'ri-file-text-line',
                    'permission' => 'invoices.view',
                ],
                [
                    'title' => 'Refunds',
                    'route' => 'refunds.index',
                    'is_route' => true,
                    'icon' => 'ri-file-text-line',
                    'permission' => 'refunds.view',
                ],
            ],
        ];
    }
}