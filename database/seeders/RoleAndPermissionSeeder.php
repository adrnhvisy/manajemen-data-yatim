<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $roles = ['superadmin', 'kelurahan', 'kecamatan', 'kesra'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        // Example permissions (can be expanded)
        $permissions = [
            'view any anak',
            'create anak',
            'update anak',
            'delete anak',
            'approve kecamatan',
            'approve kesra',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
        // Assign all permissions to superadmin
        $super = Role::where('name', 'superadmin')->first();
        $super->syncPermissions(Permission::all());
    }
}
