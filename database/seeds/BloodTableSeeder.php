<?php

use App\Models\Blood;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blood::create(['name' => 'O+']);
        Blood::create(['name' => 'O-']);
        Blood::create(['name' => 'A+']);
        Blood::create(['name' => 'A-']);
        Blood::create(['name' => 'B+']);
        Blood::create(['name' => 'B-']);
        Blood::create(['name' => 'AB+']);
        Blood::create(['name' => 'AB-']);
    }
}
