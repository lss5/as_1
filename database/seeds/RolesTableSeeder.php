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
        Role::truncate();

        Role::create(['name' => 'Administrator', 'uniq_name' => 'admin']);
        Role::create(['name' => 'Owner', 'uniq_name' => 'owner']);
        Role::create(['name' => 'Moderator', 'uniq_name' => 'moder']);
    }
}
