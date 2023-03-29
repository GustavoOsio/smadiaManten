<?php

use App\Models\Filter;
use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Filter::create(['name' => 'Soltero', 'type' => 'estado']);
        Filter::create(['name' => 'Casado', 'type' => 'estado']);
        Filter::create(['name' => 'Divorciado', 'type' => 'estado']);
        Filter::create(['name' => 'Viudo', 'type' => 'estado']);
        Filter::create(['name' => 'Unión libre', 'type' => 'estado']);
        Filter::create(['name' => 'Separado', 'type' => 'estado']);
        Filter::create(['name' => 'Salud Total EPS', 'type' => 'eps']);
        Filter::create(['name' => 'Sura EPS', 'type' => 'eps']);
        Filter::create(['name' => 'Nueva EPS', 'type' => 'eps']);
        Filter::create(['name' => 'Caja copi', 'type' => 'eps']);
        Filter::create(['name' => 'Sura', 'type' => 'arl']);
        Filter::create(['name' => 'Colpatria', 'type' => 'arl']);
        Filter::create(['name' => 'Porvenir', 'type' => 'pension']);
        Filter::create(['name' => 'Colfondos', 'type' => 'pension']);
    }
}
