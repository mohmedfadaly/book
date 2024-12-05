<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    public function run()
    {

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $adminPermissions = ['create books', 'edit books', 'delete books', 'borrow books', 'view books'];
        $userPermissions = ['view books', 'borrow books'];
        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo(Permission::whereIn('name', $userPermissions)->get());
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($adminRole);
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($userRole);

    }
}
