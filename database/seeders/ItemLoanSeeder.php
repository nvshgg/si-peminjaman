<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemLoan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loans = [
                'item_id' => Item::first()->id,
                'user_id' => User::where('username', '!=', 'superradmin')->first()->id,
                'qty' => '1',
                'start_date' => date('2025-06-25'),
                'end_date' => date('2025-07-02')
        ];

        ItemLoan::create($loans);
        
    }
}
