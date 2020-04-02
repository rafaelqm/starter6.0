<?php

use Illuminate\Database\Seeder;

class RolePermissionsTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        config('roles.models.permission')::where('slug', 'LIKE','roles.%')->forceDelete();

        $Permissionitems = [
            [
                'name'        => 'Can View Roles',
                'slug'        => 'roles.view',
                'description' => 'Pode visualizar papéis',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Roles',
                'slug'        => 'roles.create',
                'description' => 'Pode criar novo papéis',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Roles',
                'slug'        => 'roles.edit',
                'description' => 'Pode editar papéis',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Roles',
                'slug'        => 'roles.delete',
                'description' => 'Pode remover papéis',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
        $permissions = config('roles.models.permission')::where('slug', 'LIKE','roles.%')->get();
        $roleAdmin = config('roles.models.role')::where('slug', '=', 'admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }
    }
}
