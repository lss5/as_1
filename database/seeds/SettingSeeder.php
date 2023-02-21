<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::create(['name' => 'Title', 'uniq_name' => 'meta_title', 'value' => 'Meta title']);
        Setting::create(['name' => 'Description', 'uniq_name' => 'meta_description', 'sort' => 'Meta description']);
        Setting::create(['name' => 'Keywords', 'uniq_name' => 'meta_keywords', 'sort' => 'Meta keywords']);
    }
}
