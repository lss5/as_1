<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $path = 'dumps/country.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Country table seeded!');

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(AlgorithmSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CoinSeeder::class);
        $this->call(ManufacturerSeeder::class);
    }
}
