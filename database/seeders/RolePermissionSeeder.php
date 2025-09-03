<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => [
            'view',
        ],

        'user' => [
            'view',
            'create',
            'edit',
            'delete'
        ],

         'resident' => [
            'view',
            'create',
            'edit',
            'delete'
         ],

        'service-category' => [
            'view',
            'create',
            'edit',
            'delete'
          ],

        'service' => [
            'view',
            'create',
            'edit',
            'delete'
           ],

        'service-status' => [
            'view',
            'create',
            'edit',
            'delete'
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::firstOrCreate([
                    'name' => $key . '-' . $permission,
                ]);
            }
        }

        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ])->givePermissionTo(Permission::all());

        Role::firstOrCreate([
            'name' => 'resident',
            'guard_name' => 'web'
        ])->givePermissionTo([
            'service-category-view',

            'service-view',
            'service-create',
            'service-edit',
            'service-delete',

            'service-status-view',
        ]);
    }
}
