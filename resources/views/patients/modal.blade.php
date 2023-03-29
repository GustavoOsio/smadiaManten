<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" style="text-align: center;width: 100%;" id="exampleModalCenterTitle">
            {{$type_medical_history->name}}
        </h5>
        @if($type_medical_history->id != 14 and $type_medical_history->id != 13 and $type_medical_history->id != 17 and $type_medical_history->id != 18)
            <a href="{{url($type_medical_history->href.'/'.$idRelation.'/edit')}}"><span class="icon-icon-11"></span></a>
        @endif
    </div>
    <div class="modal-body">
        @switch($type_medical_history->id)
            @case(1)
                @php
                    $idBefore = \App\Models\Anamnesis::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.anamnesis',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(2)
                @php
                    $idBefore = \App\Models\SystemReview::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\SystemsReviewRelation::where('system_review_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                    $systems = \App\Models\Systems::all();
                @endphp
                @component('patients.modal.system-review',['idBefore'=>$idBefore,'relation'=>$relation,'systems'=>$systems])
                @endcomponent
            @break
            @case(3)
                @php
                    $idBefore = \App\Models\PhysicalExam::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.physical-exams',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(4)
                @php
                    $idBefore = \App\Models\Measurements::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.measurements',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(5)
                @php
                    $idBefore = \App\Models\ClinicalDiagnostics::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationClinicalDiagnostics::where('clinical_diagnostics_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.modal.clinical-diagnostics',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(6)
                @php
                    $idBefore = \App\Models\TreatmentPlan::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationTreatmentPlan::where('tratment_plan_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.modal.treatment-plan',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(7)
                @php
                    $idBefore = \App\Models\BiologicalMedicinePlan::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.biological-medicine-plan',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(8)
                @php
                    $idBefore = \App\Models\LaboratoryExams::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationLaboratoryExams::where('laboratory_exams_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.modal.laboratory-exams',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(9)
                @php
                    $idBefore = \App\Models\MedicalEvolutions::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.medical-evolutions',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(10)
                @php
                    $idBefore = \App\Models\CosmetologicalEvolution::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.cosmetological-evolution',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(11)
                @php
                    $idBefore = \App\Models\InfirmaryEvolution::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.infirmary-evolution',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(12)
                @php
                    $idBefore = \App\Models\FormulationAppointment::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationFormulationAppointment::where('formulation_appointment_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.modal.formulation-appointment',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(13)
                @php
                    $idBefore = \App\Models\ExpensesSheet::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                if(!empty($idBefore)){
                    $relation = \App\Models\RelationExpensesSheet::where('expenses_sheet_id',$idBefore->id)
                        ->get();
                }else{
                    $relation = '';
                }
                @endphp
                @component('patients.modal.expenses-sheet',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(14)
                @php
                    $idBefore = \App\Models\SurgeryExpensesSheet::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                if(!empty($idBefore)){
                    $relation = \App\Models\RelationSurgeryExpensesSheet::where('surgery_expenses_sheet_id',$idBefore->id)
                        ->get();
                }else{
                    $relation = '';
                }
                @endphp
                @component('patients.modal.surgery-expenses-sheet',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(15)
                @php
                    $idBefore = \App\Models\InfirmaryNotes::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.infirmary-notes',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(16)
                @php
                    $idBefore = \App\Models\SurgicalDescription::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.surgical-description',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(17)
                @php
                    $fotografias = \App\Models\PatientPhotographs::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.patient-photographs',['photos'=>$fotografias])
                @endcomponent
            @break
            @case(18)
                @php
                    $idBefore = \App\Models\LabResults::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                @endphp
                @component('patients.modal.lab-results',['idBefore'=>$idBefore])
                @endcomponent
            @break
            @case(19)
                @php
                    $idBefore = \App\Models\MedicationControl::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationMedicationControl::where('medication_control_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.modal.medication-control',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(20)
                @php
                    $idBefore = \App\Models\LiquidControl::where('patient_id',$patientId)
                        ->where('id',$idRelation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationLiquidControl::where('liquid_control_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.modal.liquid-control',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @default
        @endswitch
    </div>
</div>
