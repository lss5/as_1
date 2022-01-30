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
        // User::truncate();
        // DB::table('role_user')->truncate();

        $premiumRole = Role::where('uniq_name', 'premium')->first();
        $adminRole = Role::where('uniq_name', 'admin')->first();
        $moderRole = Role::where('uniq_name', 'moder')->first();

        $admin = User::create([
            'name' => 'Adminstrator',
            'first_name' => 'Johnson',
            'last_name' => 'Sardenga',
            'country_id' => 1,
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $premium = User::create([
            'name' => 'Premium',
            'first_name' => 'Vladimir',
            'last_name' => 'Putin',
            'country_id' => 1,
            'email' => 'premium@premium.com',
            'password' => Hash::make('12345678'),
        ]);

        $moder = User::create([
            'name' => 'Moderator',
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov',
            'country_id' => 1,
            'email' => 'moder@moder.com',
            'password' => Hash::make('12345678'),
        ]);

        $premium->roles()->attach($premiumRole);
        $admin->roles()->attach($adminRole);
        $moder->roles()->attach($moderRole);

        User::create([
            'name' => 'user1',
            'first_name' => 'Petr',
            'last_name' => 'Petrov',
            'country_id' => 1,
            'email' => 'user1@user.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'user2',
            'first_name' => 'Sidor',
            'last_name' => 'Sidorov',
            'country_id' => 1,
            'email' => 'user2@user.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'user3',
            'first_name' => 'Dmitry',
            'last_name' => 'Dmitriev',
            'country_id' => 1,
            'email' => 'user3@user.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
