<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(StateTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(BloodTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(MenuRoleTableSeeder::class);
        $this->call(FilterTableSeeder::class);
        $this->call(TextTableSeeder::class);
        $this->call(TypeTableSeeder::class);
        $this->call(TypeMedicalHistoryTableSeeder::class);
        $this->call(RetentionTableSeeder::class);
        Model::reguard();
    }
}
