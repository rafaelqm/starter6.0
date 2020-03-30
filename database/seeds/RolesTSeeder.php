<?php

use Illuminate\Database\Seeder;

class RolesTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Administrador geral',
                'level'       => 5,
            ],
            [
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'Usuário comum',
                'level'       => 1,
            ],
            [
                'name'        => 'Unverified',
                'slug'        => 'unverified',
                'description' => 'Não validado',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
