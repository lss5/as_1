<?php

use App\Models\Coin;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coins = [
            ['name' => 'BTC', 'short_name' => 'BTC', 'sort' => '10'],
            ['name' => 'BSV', 'short_name' => 'BSV', 'sort' => '20'],
            ['name' => 'BCH', 'short_name' => 'BCH', 'sort' => '30'],
            ['name' => 'NMC', 'short_name' => 'NMC', 'sort' => '40'],
            ['name' => 'TRC', 'short_name' => 'TRC', 'sort' => '50'],
            ['name' => 'Ethereum Classic', 'short_name' => 'Ethereum Classic', 'sort' => '60'],
            ['name' => 'Pirl', 'short_name' => 'Pirl', 'sort' => '70'],
            ['name' => 'Ubiq', 'short_name' => 'Ubiq', 'sort' => '80'],
            ['name' => 'Callisto', 'short_name' => 'Callisto', 'sort' => '90'],
            ['name' => 'Metaverse', 'short_name' => 'Metaverse', 'sort' => '100'],
            ['name' => 'Expanse', 'short_name' => 'Expanse', 'sort' => '110'],
            ['name' => 'LTC', 'short_name' => 'LTC', 'sort' => '120'],
            ['name' => 'DOGE', 'short_name' => 'DOGE', 'sort' => '130'],
            ['name' => 'RDD', 'short_name' => 'RDD', 'sort' => '140'],
            ['name' => 'MONA', 'short_name' => 'MONA', 'sort' => '150'],
            ['name' => 'SYS', 'short_name' => 'SYS', 'sort' => '160'],
            ['name' => 'VTC', 'short_name' => 'VTC', 'sort' => '170'],
            ['name' => 'Dash', 'short_name' => 'Dash', 'sort' => '180'],
            ['name' => 'Enigma', 'short_name' => 'Enigma', 'sort' => '190'],
            ['name' => 'Synergy', 'short_name' => 'Synergy', 'sort' => '200'],
            ['name' => 'Tao', 'short_name' => 'Tao', 'sort' => '210'],
            ['name' => 'Verge', 'short_name' => 'Verge', 'sort' => '220'],
            ['name' => 'Zcash', 'short_name' => 'Zcash', 'sort' => '230'],
            ['name' => 'Bitcoin Gold', 'short_name' => 'Bitcoin Gold', 'sort' => '240'],
            ['name' => 'Comodo', 'short_name' => 'Comodo', 'sort' => '250'],
            ['name' => 'ZClassic', 'short_name' => 'ZClassic', 'sort' => '260'],
            ['name' => 'Zero', 'short_name' => 'Zero', 'sort' => '270'],
            ['name' => 'Bytecoin', 'short_name' => 'Bytecoin', 'sort' => '280'],
            ['name' => 'Citadel', 'short_name' => 'Citadel', 'sort' => '290'],
            ['name' => 'Swap', 'short_name' => 'Swap', 'sort' => '300'],
            ['name' => 'Dashcoin', 'short_name' => 'Dashcoin', 'sort' => '310'],
            ['name' => 'Karbo', 'short_name' => 'Karbo', 'sort' => '320'],
            ['name' => 'Monero', 'short_name' => 'Monero', 'sort' => '330'],
            ['name' => 'Zephyr', 'short_name' => 'Zephyr', 'sort' => '340'],
            ['name' => 'Quantum Resistance Ledger', 'short_name' => 'Quantum Resistance Ledger', 'sort' => '350'],
            ['name' => 'Feathercoin', 'short_name' => 'Feathercoin', 'sort' => '360'],
            ['name' => 'GoByte', 'short_name' => 'GoByte', 'sort' => '370'],
            ['name' => 'TrezarCoin', 'short_name' => 'TrezarCoin', 'sort' => '380'],
            ['name' => 'MonaCoin', 'short_name' => 'MonaCoin', 'sort' => '390'],
            ['name' => 'NEOX', 'short_name' => 'NEOX', 'sort' => '400'],
            ['name' => 'Frencoin', 'short_name' => 'Frencoin', 'sort' => '410'],
            ['name' => 'Neurai', 'short_name' => 'Neurai', 'sort' => '420'],
            ['name' => 'kaspa', 'short_name' => 'kaspa', 'sort' => '430'],
        ];

        foreach ($coins as $coin) {
            Coin::create([
                'name' => $coin['name'],
                'short_name' => $coin['short_name'],
                'sort' => $coin['sort'],
            ]);
        }

        $this->command->info(count($coins).' Coins added');
    }
}
