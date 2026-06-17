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
            // Project Types
            'project.type.view',
            'project.type.create',
            'project.type.edit',
            'project.type.delete',
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
            'reports.view',
            'reports.export',
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
            'projects.view',
            'leads.view',
            'leads.create',
            'leads.edit',
            'leads.assign',
            'leads.change_status',
            'deals.view',
            'deals.create',
            'deals.edit',
            'invoices.view',
            'refunds.view',
            'reports.view',
        ];
        // Agent Permissions
        $agentPermissions = [
            'dashboard.view',
            'projects.view',
            'leads.view',
            'leads.create',
            'leads.edit',
            'deals.view',
            'invoices.view',
            'reports.view',
        ];
        // User Permissions
        $userPermissions = [
            'dashboard.view',
            'projects.view',
            'leads.view',
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