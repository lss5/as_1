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
            'name' => 'Adminstrator name',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $premium = User::create([
            'name' => 'Premium',
            'email' => 'premium@premium.com',
            'password' => Hash::make('12345678'),
        ]);

        $moder = User::create([
            'name' => 'Moderator name',
            'email' => 'moder@moder.com',
            'password' => Hash::make('12345678'),
        ]);

        $premium->roles()->attach($premiumRole);
        $admin->roles()->attach($adminRole);
        $moder->roles()->attach($moderRole);

        User::create([
            'name' => 'user1',
            'email' => 'user1@user.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@user.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'user3',
            'email' => 'user3@user.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
