<?php

use App\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manufacturers = [
            [
                'name' => 'Bitmain',
                'description' => 'Antminer — the worlds leading ASIC mining brand, offers exceptional products for mining cryptocurrency. Antminer products embody the definitive technology pioneered for product superiority and performance. Equipped with state-of-the-art custom-built chips designed by Bitmain, Antminer products achieve industry-leading hash rates and power efficiency. Having shipped billions of ASICs accounting for the majority share of the global market, Antminer has become a household brand for miners that work in securing the cryptocurrency network, empowering the blockchain industry.',
                'url' => 'https://www.bitmain.com/',
            ],
            [
                'name' => 'Canaan Avalon',
                'description' => 'In 2013, Canaan, who invented the first ASIC mining machine, has been a lead in mining hardware by using advanced ASIC on miners. In 2016, Canaan has successfully launched the production of its first 16nm chip and has been awarded China National High-Tech Enterprise Certification. In 2018, Canaan achieved two major technological breakthroughs by mass producing first self-developed RISC-V edge AI chip and 7nm chip, which are now widely used in various scenarios. In 2019, as the second largest manufacturer of bitcoin mining machines in the world, Canaan was listed on the Nasdaq. Canaan has a range of advanced technologies, including AI chip research and development, AI algorithms, AI architectures, SoC integration, chip R&D integration.',
                'url' => 'https://www.canaan.io/',
            ],
            [
                'name' => 'Innosilicon',
                'description' => 'Innosilicon is a worldwide one-stop provider of high-speed mixed signal IPs and ASIC customization with leading market shares in Asian-Pacific market for 10 years. In 2018, Innosilicon was the first in the world to reach mass production of the performance-leading GDDR6 interface in their cryptographic GPU product. In 2019, Innosilicon announced the availability of the HDMI v2.1 IP supporting 4K/8K displays as well as their 32Gbps SerDes PHY. In 2020, Innosilicon launched the INNOLINK Chiplet which allows massive amounts of low-latency data to pass seamlessly between smaller chips as if they were all on the same bus.',
                'url' => 'https://innosilicon.shop/',
            ],
            [
                'name' => 'Whatsminer',
                'description' => 'Whatsminer is a ASIC based Plug & Play Bitcoin Mining hardware appliance. It allows you to start mining Bitcoin or Bitcoin Cash immediately and jump into the new digital gold rush!',
                'url' => 'https://www.whatsminer.com',
            ],
            [
                'name' => 'Cheetah',
                'description' => 'Cheetah-miner is specialized in researching, manufacturing and selling digital currency mining machines. Currently, four series of F1, F3 and F5, F7 cheetah mining machines have been launched, using ASICs and integrated systems with SHA-256 algorithm.',
                'url' => 'https://www.cheetah-miner.com/',
            ],
        ];

        foreach ($manufacturers as $manufacturer) {
            Manufacturer::create([
                'name' => $manufacturer['name'],
                'description' => $manufacturer['description'],
                'url' => $manufacturer['url'],
            ]);
        }

        $this->command->info(count($manufacturers).' Manufacturers added');
    }
}
