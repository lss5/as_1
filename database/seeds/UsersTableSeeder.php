<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Adminstrator',
            'first_name' => 'Johnson',
            'last_name' => 'Sardenga',
            'country_id' => 1,
            'email' => 'admin@admin.com',
            'password' => Hash::make('1234'),
            'email_verified_at' => Carbon::now(),
        ]);

        $adminRole = Role::where('uniq_name', 'admin')->first();
        $admin->roles()->attach($adminRole);

        User::create([
            'name' => 'user',
            'first_name' => 'Petr',
            'last_name' => 'Petrov',
            'country_id' => 1,
            'email' => 'user@user.com',
            'password' => Hash::make('1234'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
