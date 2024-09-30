<?php

use App\Algorithm;
use Illuminate\Database\Seeder;

class AlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $algoritmhs = [
            'SHA256' => '10',
            'Ethash' => '20',
            'Scrypt' => '30',
            'X11' => '40',
            'Equihash' => '50',
            'Cryptonight' => '60',
            'RandomX' => '70',
            'NeoScrypt' => '80',
            'Lyra2REv' => '90',
            'KAWPOW' => '100',
            'kHeavyHash' => '110',
        ];

        foreach ($algoritmhs as $name => $sort) {
            Algorithm::create([
                'name' => $name,
                'sort' => $sort,
            ]);
        }

        $this->command->info(count($algoritmhs).' Algorithms added');
    }
}
