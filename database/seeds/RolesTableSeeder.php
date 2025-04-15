<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create(['name' => 'Administrator', 'uniq_name' => Role::ROLE_ADMIN]);
        Role::query()->create(['name' => 'Moderator', 'uniq_name' => Role::ROLE_MODERATOR]);
    }
}
