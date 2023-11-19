<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin      = Role::create(['name' => 'admin']);
        $user       = Role::create(['name' => 'user']);
        $student    = Role::create(['name' => 'student']);
        $parent     = Role::create(['name' => 'parent']);
        $teacher    = Role::create(['name' => 'teacher']);

        $create_grade_permission = Permission::create(['name' => 'create grade']);
        $create_subject_permission = Permission::create(['name' => 'create subject']);

        $update_profile_permission = Permission::create(['name' => 'update profile']);

        $admin_permissions = [$create_grade_permission, $create_subject_permission, $update_profile_permission];
        $user_permissions = [$update_profile_permission];

        $admin->syncPermissions($admin_permissions);
        $user->syncPermissions($user_permissions);
    }
}
