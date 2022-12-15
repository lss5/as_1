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
        Section::create(['name' => 'About', 'uniq_name' => 'about', 'sort' => '10']);
        Section::create(['name' => 'Information', 'uniq_name' => 'information', 'sort' => '20']);
        Section::create(['name' => 'Partners', 'uniq_name' => 'partners', 'sort' => '30']);
        Section::create(['name' => 'Registration', 'uniq_name' => 'registration', 'sort' => '40']);
    }
}
