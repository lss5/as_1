<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create(['name' => 'About', 'sort' => '10']);
        Section::create(['name' => 'Information', 'sort' => '20']);
        Section::create(['name' => 'Partners', 'sort' => '30']);
        Section::create(['name' => 'Registration', 'sort' => '40']);
    }
}
