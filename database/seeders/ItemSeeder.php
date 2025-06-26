<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Buku - Dikala Aku Sedang Sendiri',
                'qty' => '5'
            ],
            [
                'name' => 'Buku - This Earth of Mankind',
                'qty' => '4'
            ],
            [
                'name' => 'Buku - The Rainbow Troop',
                'qty' => '3'
            ],
            [
                'name' => 'Buku - MADILOG',
                'qty' => '7'
            ],
            [
                'name' => 'Buku - Wingit',
                'qty' => '9'
            ],
            [
                'name' => 'Buku - Tenggelamnya Kapal Van Der Wick',
                'qty' => '12'
            ],
            [
                'name' => 'Goodie Bag - Indonesia 79 Tahun Merdeka',
                'qty' => '20'
            ],
            [
                'name' => 'Goodie Bag - Green Peace',
                'qty' => '12'
            ],
            [
                'name' => 'Goodie Bag - Melangkah Lebih Tinggi',
                'qty' => '31'
            ],
            [
                'name' => 'Goodie Bag - Tan Malaka',
                'qty' => '23'
            ],
        ];

        foreach($items as $item){
            Item::create($item);
        }
    }
}
