<?php

use Illuminate\Database\Seeder;

class UsersTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('slug', '=', 'user')->first();
        $adminRole = config('roles.models.role')::where('slug', '=', 'admin')->first();

        $admin = \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);

        $admin->attachRole($adminRole);

        $user = \App\User::create([
            'name' => 'User',
            'email' => 'user@admin.com',
            'password' => bcrypt('user'),
        ]);
        $user->attachRole($userRole);
    }
}
