<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Retention;

class RetentionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Retention::create(['name' => 'Compras - 2.5', 'value' => '2.50']);
        Retention::create(['name' => 'Servicios - 2.0', 'value' => '2.00']);
        Retention::create(['name' => 'Servicios - 1.0', 'value' => '1.00']);
        Retention::create(['name' => 'Servicios - 4.0', 'value' => '4.00']);
        Retention::create(['name' => 'Servicios - 6.0', 'value' => '6.00']);
        Retention::create(['name' => 'Honorarios - 11.0', 'value' => '11.00']);
        Retention::create(['name' => 'Honorarios - 10.0', 'value' => '10.00']);
    }
}
