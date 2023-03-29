<?php

use Illuminate\Database\Seeder;
use App\Models\TypeMedicalHistory;

class TypeMedicalHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeMedicalHistory::create(['name' => 'Anamnesis','href'=>'anamnesis']);
        TypeMedicalHistory::create(['name' => 'Revisión por Sistema','href'=>'system-review']);
        TypeMedicalHistory::create(['name' => 'Exámen físico','href'=>'physical-exams']);
        TypeMedicalHistory::create(['name' => 'Tabla de medidas','href'=>'measurements']);
        TypeMedicalHistory::create(['name' => 'Diagnostico clínico','href'=>'clinical-diagnostics']);
        TypeMedicalHistory::create(['name' => 'Plan de Tratamiento','href'=>'treatment-plan']);
        TypeMedicalHistory::create(['name' => 'Plan de Medicina Biologica','href'=>'biological-medicine-plan']);
        TypeMedicalHistory::create(['name' => 'Ayudas Diagnosticas','href'=>'laboratory-exams']);
        TypeMedicalHistory::create(['name' => 'Evolución médica','href'=>'medical-evolutions']);
        TypeMedicalHistory::create(['name' => 'Evolución Cosmetológica','href'=>'cosmetological-evolution']);
        TypeMedicalHistory::create(['name' => 'Evolución de Enfermería','href'=>'infirmary-evolution']);
        TypeMedicalHistory::create(['name' => 'Formulación','href'=>'formulation-appointment']);
        TypeMedicalHistory::create(['name' => 'Hoja de Gastos','href'=>'expenses-sheet']);
        TypeMedicalHistory::create(['name' => 'Hoja de Gastos de Cirugía','href'=>'surgery-expenses-sheet']);
        TypeMedicalHistory::create(['name' => 'Notas de Enfermería','href'=>'infirmary-notes']);
        TypeMedicalHistory::create(['name' => 'Descripción Quirúrgica','href'=>'surgical-description']);
        TypeMedicalHistory::create(['name' => 'Fotografias','href'=>'patient-photographs']);
        TypeMedicalHistory::create(['name' => 'Resultados de Laboratorio','href'=>'lab-results']);
        TypeMedicalHistory::create(['name' => 'Control de medicamentos','href'=>'medication-control']);
        TypeMedicalHistory::create(['name' => 'Control de liquidos','href'=>'liquid-control']);
    }
}
