<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::truncate();

        Role::create(['name' => 'Premium', 'uniq_name' => 'premium']);
        Role::create(['name' => 'Administrator', 'uniq_name' => 'admin']);
        Role::create(['name' => 'Moderator', 'uniq_name' => 'moder']);
    }
}
