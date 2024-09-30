<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Active' => 'active',
            'Moderation' => 'moderation',
            'Archive' => 'archive',
            'Rejection' => 'rejection',
        ];

        foreach ($statuses as $name => $uniq_name) {
            Status::create([
                'name' => $name,
                'uniq_name' => $uniq_name,
            ]);
        }

        $this->command->info(count($statuses).' Statuses added');
    }
}
