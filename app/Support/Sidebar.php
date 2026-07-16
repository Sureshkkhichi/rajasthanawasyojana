<?php
namespace App\Support;
class Sidebar
{
    public static function menus(): array
    {
        return [
            // DASHBOARD
            'dashboard' => [
                'dashboard' => [
                    [
                        'title' => 'Dashboard',
                        'route' => 'dashboard',
                        'is_route' => true,
                        'icon' => 'ri-dashboard-line',
                        'permission' => 'dashboard.view',
                    ],
                ],
            ],
            // Frontend Configuration
            'frontend_configuration' => [
                'frontend' => [
                    [
                        'title' => 'Home Page',
                        'route' => 'frontend.index',
                        'is_route' => true,
                        'icon' => 'ri-layout-line',
                    ],
                    [
                        'title' => 'Pages',
                        'route' => 'pages.index',
                        'is_route' => true,
                        'icon' => 'ri-file-edit-line',
                        'permission' => 'pages.view',
                    ],
                    [
                        'title' => 'Projects',
                        'route' => 'projects.index',
                        'is_route' => true,
                        'icon' => 'ri-folder-2-line',
                        'permission' => 'projects.view',
                    ],
                ],
            ],
            'project_management' => [
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
                'flats' => [
                    [
                        'title' => 'Flats',
                        'route' => 'flats.index',
                        'is_route' => true,
                        'icon' => 'ri-building-2-line',
                        'permission' => 'flats.view',
                    ],
                ],
            ],
            // LEADS
            'leads_management' => [
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
                    [
                        'title' => 'Deals',
                        'route' => 'deals.index',
                        'is_route' => true,
                        'icon' => 'ri-hand-coin-line',
                        'permission' => 'deals.view',
                    ],
                ],
            ],
            // FINANCE
            'finance_managerment' => [
                'finance' => [

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
            ],
            // Reports
            'reports_managerment' => [
                'reports' => [
                    [
                        'title' => 'Purchase Report',
                        'route' => 'reports.purchase',
                        'is_route' => true,
                        'icon' => 'ri-file-chart-line',
                        'permission' => 'reports.purchase',
                    ],
                    [
                        'title' => 'Sales Report',
                        'route' => 'reports.sales',
                        'is_route' => true,
                        'icon' => 'ri-line-chart-line',
                        'permission' => 'reports.sales',
                    ],
                    [
                        'title' => 'Expense Report',
                        'route' => 'reports.expense',
                        'is_route' => true,
                        'icon' => 'ri-money-dollar-circle-line',
                        'permission' => 'reports.expense',
                    ],
                    [
                        'title' => 'Profit Report',
                        'route' => 'reports.profit',
                        'is_route' => true,
                        'icon' => 'ri-funds-line',
                        'permission' => 'reports.profit',
                    ],
                ],
            ],
        ];
    }
}