<?php
// database/seeders/ShiftSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        Shift::insert([
            ['name'=>'Pagi',  'start_time'=>'07:00','end_time'=>'15:00'],
            ['name'=>'Sore',  'start_time'=>'15:00','end_time'=>'23:00'],
            ['name'=>'Malam','start_time'=>'23:00','end_time'=>'07:00'],
        ]);
    }
}