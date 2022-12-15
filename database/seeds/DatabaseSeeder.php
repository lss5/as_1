<?php

use Illuminate\Database\Seeder;

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
        $this->call(ProductSeeder::class);
        $this->call(SectionSeeder::class);
    }
}
