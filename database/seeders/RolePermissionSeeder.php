<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Permissions
        $permissions = [
            // Dashboard
            'dashboard.view',
            // Home Slider
            'home.slider.view',
            'home.slider.create',
            'home.slider.edit',
            'home.slider.delete',
            // Static Pages
            'pages.view',
            'pages.edit',
            // Project Types
            'project.type.view',
            'project.type.create',
            'project.type.edit',
            'project.type.delete',
            // Flats
            'flats.view',
            'flats.create',
            'flats.edit',
            'flats.delete',
            // Projects
            'projects.view',
            'projects.create',
            'projects.edit',
            'projects.delete',
            // Leads
            'leads.view',
            'leads.create',
            'leads.edit',
            'leads.delete',
            'leads.assign',
            'leads.change_status',
            // Deals
            'deals.view',
            'deals.create',
            'deals.edit',
            'deals.delete',
            // Invoices
            'invoices.view',
            'invoices.create',
            'invoices.edit',
            'invoices.delete',
            // Refunds
            'refunds.view',
            'refunds.create',
            'refunds.edit',
            'refunds.delete',
            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.assign_role',
            // Reports
            'reports.purchase',
            'reports.sales',
            'reports.expense',
            'reports.profit',
        ];
        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
        // Create roles
        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);
        $staff = Role::firstOrCreate([
            'name' => 'Staff',
            'guard_name' => 'web',
        ]);
        $agent = Role::firstOrCreate([
            'name' => 'Agent',
            'guard_name' => 'web',
        ]);
        $user = Role::firstOrCreate([
            'name' => 'User',
            'guard_name' => 'web',
        ]);
        // Admin Permissions
        $adminPermissions = Permission::pluck('name')->toArray();
        // Staff Permissions
        $staffPermissions = [
            'dashboard.view',
        ];
        // Agent Permissions
        $agentPermissions = [
            'dashboard.view',
        ];
        // User Permissions
        $userPermissions = [
            'dashboard.view',
        ];
        // Sync permissions
        $admin->syncPermissions($adminPermissions);
        $staff->syncPermissions($staffPermissions);
        $agent->syncPermissions($agentPermissions);
        $user->syncPermissions($userPermissions);
        // Clear permission cache again
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
