<?php
// database/seeders/ShiftGroupSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShiftGroup;

class ShiftGroupSeeder extends Seeder
{
    public function run()
    {
        ShiftGroup::insert([
            ['name'=>'Group 1'],
            ['name'=>'Group 2'],
            ['name'=>'Group 3'],
        ]);
    }
}