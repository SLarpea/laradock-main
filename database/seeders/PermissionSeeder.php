<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                "name" => "view dashboard",
                "module" => "Dashboard",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "view users",
                "module" => "User",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "add users",
                "module" => "User",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "edit users",
                "module" => "User",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "edit self",
                "module" => "User",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "delete users",
                "module" => "User",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "delete self",
                "module" => "User",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "view roles",
                "module" => "Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "add roles",
                "module" => "Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "edit roles",
                "module" => "Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "delete roles",
                "module" => "Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "view permissions",
                "module" => "Permission",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "view user roles",
                "module" => "User Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "edit user roles",
                "module" => "User Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "view user permissions",
                "module" => "User Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "edit user permissions",
                "module" => "User Role",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "view shops",
                "module" => "Shop",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "add shops",
                "module" => "Shop",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "edit shops",
                "module" => "Shop",
                "guard_name" => "sanctum",
                "status" => 1
            ],
            [
                "name" => "delete shops",
                "module" => "Shop",
                "guard_name" => "sanctum",
                "status" => 1
            ],
        ];

        $role1 = Role::create(['name' => 'Superadmin', 'guard_name' => 'sanctum', 'status' => 1]);
        $user1 = User::findOrFail(1);
        $user1->assignRole($role1);

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Permission::insert($permissions);
    }
}
