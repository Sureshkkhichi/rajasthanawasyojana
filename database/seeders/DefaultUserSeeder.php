<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'superadmin',
                'email' => 'admin@mail.com',
                'mobile' => '9999999991',
                'password' => Hash::make('password'),
                'user_type' => 'admin',
                'role' => 'Admin',
            ],
            [
                'name' => 'Staff User',
                'username' => 'staff',
                'email' => 'staff@mail.com',
                'mobile' => '9999999992',
                'password' => Hash::make('password'),
                'user_type' => 'staff',
                'role' => 'Staff',
            ],
            [
                'name' => 'Agent User',
                'username' => 'agent',
                'email' => 'agent@mail.com',
                'mobile' => '9999999993',
                'password' => Hash::make('password'),
                'user_type' => 'agent',
                'role' => 'Agent',
            ],
            [
                'name' => 'Client User',
                'username' => 'client',
                'email' => 'client@mail.com',
                'mobile' => '9999999994',
                'password' => Hash::make('password'),
                'user_type' => 'client',
                'role' => 'User',
            ],
        ];
        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            $user->syncRoles([$role]);
        }
    }
}