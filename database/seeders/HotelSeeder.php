<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\BuzzvelHotel;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuzzvelHotel::searchHotelList();
    }
}
