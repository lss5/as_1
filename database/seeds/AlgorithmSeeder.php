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
            ['name' => 'Blake3', 'uniq_name' => 'b3', 'hashrate_name' => 'Gh/s', 'sort' => '10'],
            ['name' => 'Scrypt', 'uniq_name' => 'scryptf', 'hashrate_name' => 'Gh/s', 'sort' => '20'],
            ['name' => 'kHeavyHash', 'uniq_name' => 'hh', 'hashrate_name' => 'Th/s', 'sort' => '30'],
            ['name' => 'Cuckatoo31', 'uniq_name' => 'ct31', 'hashrate_name' => 'h/s', 'sort' => '40'],
            ['name' => 'Eaglesong', 'uniq_name' => 'esg', 'hashrate_name' => 'Gh/s', 'sort' => '50'],
            ['name' => 'SHA-256', 'uniq_name' => 'sha256f', 'hashrate_name' => 'Th/s', 'sort' => '60'],
            ['name' => 'SHA512256d', 'uniq_name' => 's5r', 'hashrate_name' => 'Th/s', 'sort' => '70'],
            ['name' => 'Cuckatoo32', 'uniq_name' => 'ct32', 'hashrate_name' => 'h/s', 'sort' => '80'],
            ['name' => 'Equihash', 'uniq_name' => 'eq', 'hashrate_name' => 'kh/s', 'sort' => '90'],
            ['name' => 'Sia', 'uniq_name' => 'sia', 'hashrate_name' => 'Th/s', 'sort' => '100'],
            ['name' => 'RandomX', 'uniq_name' => 'rmx', 'hashrate_name' => 'kh/s', 'sort' => '110'],
            ['name' => 'Groestl', 'uniq_name' => 'gro', 'hashrate_name' => 'Gh/s', 'sort' => '120'],
            ['name' => 'LBRY', 'uniq_name' => 'lbry', 'hashrate_name' => 'Gh/s', 'sort' => '130'],
            ['name' => 'Skein', 'uniq_name' => 'sk', 'hashrate_name' => 'Gh/s', 'sort' => '140'],
            ['name' => 'Kadena', 'uniq_name' => 'kd', 'hashrate_name' => 'Th/s', 'sort' => '150'],
            ['name' => 'Keccak', 'uniq_name' => 'kec', 'hashrate_name' => 'Gh/s', 'sort' => '160'],
            ['name' => 'CryptoNight', 'uniq_name' => 'cn', 'hashrate_name' => 'kh/s', 'sort' => '170'],
            ['name' => 'Qubit', 'uniq_name' => 'qbf', 'hashrate_name' => 'Gh/s', 'sort' => '180'],
            ['name' => 'Quark', 'uniq_name' => 'qkf', 'hashrate_name' => 'Gh/s', 'sort' => '190'],
            ['name' => 'Lyra2REv2', 'uniq_name' => 'lre', 'hashrate_name' => 'Gh/s', 'sort' => '200'],
            ['name' => 'Handshake', 'uniq_name' => 'hk', 'hashrate_name' => 'Th/s', 'sort' => '210'],
            ['name' => 'X11', 'uniq_name' => 'x11f', 'hashrate_name' => 'Gh/s', 'sort' => '220'],
            ['name' => 'Lyra2Z', 'uniq_name' => 'l2z', 'hashrate_name' => 'Mh/s', 'sort' => '230'],
            ['name' => 'CryptoNightSTC', 'uniq_name' => 'cst', 'hashrate_name' => 'kh/s', 'sort' => '240'],
            ['name' => 'Ethash', 'uniq_name' => 'eth_hr', 'hashrate_name' => 'Mh/s', 'sort' => '300'],
            ['name' => 'Ethash4G', 'uniq_name' => 'e4g_hr', 'hashrate_name' => 'Mh/s', 'sort' => '310'],
            ['name' => 'Zhash', 'uniq_name' => 'zh_hr', 'hashrate_name' => 'h/s', 'sort' => '320'],
            ['name' => 'CNHeavy', 'uniq_name' => 'cnh_hr', 'hashrate_name' => 'h/s', 'sort' => '330'],
            ['name' => 'CNGPU', 'uniq_name' => 'cng_hr', 'hashrate_name' => 'h/s', 'sort' => '340'],
            ['name' => 'Radiant', 'uniq_name' => 's5r_hr', 'hashrate_name' => 'Gh/s', 'sort' => '350'],
            ['name' => 'Cortex', 'uniq_name' => 'cx_hr', 'hashrate_name' => 'h/s', 'sort' => '360'],
            ['name' => 'Dynex', 'uniq_name' => 'ds_hr', 'hashrate_name' => 'kh/s', 'sort' => '370'],
            ['name' => 'CuckooCycle', 'uniq_name' => 'cc_hr', 'hashrate_name' => 'h/s', 'sort' => '380'],
            ['name' => 'Pyrin', 'uniq_name' => 'pn_hr', 'hashrate_name' => 'Gh/s', 'sort' => '390'],
            ['name' => 'Skydoge', 'uniq_name' => 'sd_hr', 'hashrate_name' => 'Mh/s', 'sort' => '400'],
            ['name' => 'Cuckatoo32', 'uniq_name' => 'ct32_hr', 'hashrate_name' => 'h/s', 'sort' => '410'],
            ['name' => 'Beam', 'uniq_name' => 'eqb_hr', 'hashrate_name' => 'h/s', 'sort' => '420'],
            ['name' => 'Xelishashv2', 'uniq_name' => 'xlh_hr', 'hashrate_name' => 'kh/s', 'sort' => '430'],
            ['name' => 'Karlsenhash', 'uniq_name' => 'ks_hr', 'hashrate_name' => 'Gh/s', 'sort' => '440'],
            ['name' => 'Autolykos', 'uniq_name' => 'al_hr', 'hashrate_name' => 'Mh/s', 'sort' => '450'],
            ['name' => 'Octopus', 'uniq_name' => 'ops_hr', 'hashrate_name' => 'Mh/s', 'sort' => '460'],
            ['name' => 'FishHash', 'uniq_name' => 'fh_hr', 'hashrate_name' => 'Mh/s', 'sort' => '470'],
            ['name' => 'PoUW', 'uniq_name' => 'zlh_hr', 'hashrate_name' => 'h/s', 'sort' => '480'],
            ['name' => 'KawPow', 'uniq_name' => 'kpw_hr', 'hashrate_name' => 'Mh/s', 'sort' => '490'],
            ['name' => 'ProgPow', 'uniq_name' => 'ppw_hr', 'hashrate_name' => 'Mh/s', 'sort' => '500'],
            ['name' => 'NexaPow', 'uniq_name' => 'nx_hr', 'hashrate_name' => 'Mh/s', 'sort' => '510'],
            ['name' => 'FiroPow', 'uniq_name' => 'fpw_hr', 'hashrate_name' => 'Mh/s', 'sort' => '520'],
            ['name' => 'Verthash', 'uniq_name' => 'vh_hr', 'hashrate_name' => 'Mh/s', 'sort' => '530'],
        ];

        foreach ($algoritmhs as $algoritmh) {
            Algorithm::create([
                'name' => $algoritmh['name'],
                'uniq_name' => $algoritmh['uniq_name'],
                'hashrate_name' => $algoritmh['hashrate_name'],
                'sort' => $algoritmh['sort'],
            ]);
        }

        $this->command->info(count($algoritmhs).' Algorithms added');
    }
}
