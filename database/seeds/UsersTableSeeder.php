<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('uniq_name', 'admin')->first();
        $ownerRole = Role::where('uniq_name', 'owner')->first();
        $moderRole = Role::where('uniq_name', 'moder')->first();

        $admin = User::create([
            'name' => 'Adminstrator name',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $owner = User::create([
            'name' => 'Owner name',
            'email' => 'owner@owner.com',
            'password' => Hash::make('password'),
        ]);

        $moder = User::create([
            'name' => 'Moderator name',
            'email' => 'moder@moder.com',
            'password' => Hash::make('password'),
        ]);

        $admin->roles()->attach($adminRole);
        $owner->roles()->attach($ownerRole);
        $moder->roles()->attach($moderRole);
    }
}
