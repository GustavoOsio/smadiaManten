<?php

use App\Models\Text;
use Illuminate\Database\Seeder;

class TextTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Text::create(["text" => "[titulo] [nombreProfesional] [apellidoProfesional] - agendado con el paciente 
        [nombrePaciente] [apellidoPaciente] - servicio: [servicio] - Observaciones: [observaciones]"]);
        Text::create(["text" => "Su cita con el profesional [nombreProfesional] [apellidoProfesional] para el servicio 
        [servicio] ha sido agendada para el día [fecha] a las [hora]. Smadia clinic"]);
    }
}
