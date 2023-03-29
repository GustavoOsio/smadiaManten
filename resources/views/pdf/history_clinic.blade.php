@extends('pdf.layout')
@section('title', 'Historia Clinica')
@section('content')
    <style>
        table td,table tr,table th,table{
            padding: 0% !important;
            margin: 0% !important;
        }
        p{
           margin: 0.1% 0% !important;
        }
        .line-form{
            margin: 1% 0%;
            padding: 1% 0%;
            margin-bottom: 10px;
            background: 1px solid #c1c1c2;
        }
        .logo .img {
           
            width: 250px;
            height: 40px;
            background-size: contain;
            
            margin-top: 25px;
        }
        .fz13 {
            font-size: 13pt;
        }
        .fz11 {
            font-size: 13pt;
        }
        .fz10 {
            font-size: 13pt;
        }
        .fz9 {
            font-size: 13pt;
        }
        .page-break {
    page-break-after: always;
     }

    </style>
    <header>
<img src="https://smadiasoft.com/img/logo-smadia-02.png" style="margin-top: 25px !important;" />
    <h3 class="fz13">Historia Clinica</h3>
    <p class="fz9">Generado el: {{ date("d-m-Y") }}</p>
    </header>
  
    <table>
        <td>
            <p class="fz11"><strong>Nombre: </strong>{{ ucwords(mb_strtolower($data->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->lastname, "UTF-8")) }}</p>
            <p class="fz11"><strong>N° de Identificación: </strong>{{ $data->identy }}</p>
            <p class="fz11"><strong>Fecha de nacimiento: </strong>{{ $data->birthday }}</p>
            @php
                $stateName = '';
                $cityName = '';
                if(!empty($data->state->name))
                {
                  $stateName = $data->state->name;
                }
                if(!empty($data->city->name))
                {
                    $cityName = $data->city->name;
                }
            @endphp
            <p class="fz11"><strong>Departamento: </strong>{{ $stateName }}</p>
            <p class="fz11"><strong>Ciudad: </strong>{{ $cityName }}</p>
            <p class="fz11"><strong>Telefono: </strong>{{ $data->phone }}</p>
        </td>
        <td>
            <p class="fz11"><strong>Genero: </strong>{{ $data->gender->name }}</p>
            <p class="fz11"><strong>Servicio: </strong>
                @if(!empty($data->service->name))
                    {{ $data->service->name }}
                @endif
            </p>
            <p class="fz11"><strong>EPS: </strong>
                @if(!empty($data->eps->name))
                    {{ $data->eps->name }}
                @endif
            </p>
            <p class="fz11"><strong>Estado Civil: </strong>
                @if(!empty($data->civil->name))
                    {{ $data->civil->name }}
                @endif
            </p>
            <p class="fz11"><strong>Email: </strong>{{ $data->email }}</p>
            <p class="fz11"><strong>Celular: </strong>{{ $data->cellphone }}</p>
        </td>
    </table>
    @foreach($medicalHistory as $mh)
        @php
            $elaborateFor = \App\User::find($mh->user_id);
            $explode = explode(" ", $mh->created_at);
            $date =  $explode[0];
            $hour =  $explode[1];
        @endphp
        @switch($mh->id_type)
            @case(1)
                @php
                    $idBefore = \App\Models\Anamnesis::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.anamnesis',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(2)
                @php
                    $idBefore = \App\Models\SystemReview::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\SystemsReviewRelation::where('system_review_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                    $systems = \App\Models\Systems::all();
                @endphp
                @component('patients.pdf.system-review',['idBefore'=>$idBefore,'relation'=>$relation,'systems'=>$systems,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(3)
                @php
                    $idBefore = \App\Models\PhysicalExam::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.physical-exams',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent


            @break
            @case(4)
                @php
                    $idBefore = \App\Models\Measurements::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.measurements',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(5)
                @php
                    $idBefore = \App\Models\ClinicalDiagnostics::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationClinicalDiagnostics::where('clinical_diagnostics_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.pdf.clinical-diagnostics',['idBefore'=>$idBefore,'relation'=>$relation,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(6)
                @php
                    $idBefore = \App\Models\TreatmentPlan::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationTreatmentPlan::where('tratment_plan_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.pdf.treatment-plan',['idBefore'=>$idBefore,'relation'=>$relation,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(7)
                @php
                    $idBefore = \App\Models\BiologicalMedicinePlan::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.biological-medicine-plan',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(8)
                @php
                    $idBefore = \App\Models\LaboratoryExams::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationLaboratoryExams::where('laboratory_exams_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.pdf.laboratory-exams',['idBefore'=>$idBefore,'relation'=>$relation,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(9)
                @php
                    $idBefore = \App\Models\MedicalEvolutions::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.medical-evolutions',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(10)
                @php
                    $idBefore = \App\Models\CosmetologicalEvolution::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.cosmetological-evolution',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(11)
                @php
                    $idBefore = \App\Models\InfirmaryEvolution::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.infirmary-evolution',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(12)
                @php
                    $idBefore = \App\Models\FormulationAppointment::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationFormulationAppointment::where('formulation_appointment_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.pdf.formulation-appointment',['idBefore'=>$idBefore,'relation'=>$relation,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(13)
                @php
                    $idBefore = \App\Models\ExpensesSheet::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                if(!empty($idBefore)){
                    $relation = \App\Models\RelationExpensesSheet::where('expenses_sheet_id',$idBefore->id)
                        ->get();
                }else{
                    $relation = '';
                }
                @endphp
                @component('patients.pdf.expenses-sheet',['idBefore'=>$idBefore,'relation'=>$relation,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(14)
                @php
                    $idBefore = \App\Models\SurgeryExpensesSheet::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                if(!empty($idBefore)){
                    $relation = \App\Models\RelationSurgeryExpensesSheet::where('surgery_expenses_sheet_id',$idBefore->id)
                        ->get();
                }else{
                    $relation = '';
                }
                @endphp
                @component('patients.pdf.surgery-expenses-sheet',['idBefore'=>$idBefore,'relation'=>$relation,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(15)
                @php
                    $idBefore = \App\Models\InfirmaryNotes::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.infirmary-notes',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(16)
                @php
                    $idBefore = \App\Models\SurgicalDescription::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.surgical-description',['idBefore'=>$idBefore,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(17)
                @php
                    $fotografias = \App\Models\PatientPhotographs::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                @endphp
                @component('patients.pdf.patient-photographs',['photos'=>$fotografias,'elaborateFor'=>$elaborateFor,'date'=>$date,'hour'=>$hour])
                @endcomponent
            @break
            @case(18)
            @break
            @case(19)
                @php
                    $idBefore = \App\Models\MedicationControl::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationMedicationControl::where('medication_control_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.pdf.medication-control',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @case(20)
                @php
                    $idBefore = \App\Models\LiquidControl::where('patient_id',$data->id)
                        ->where('id',$mh->id_relation)
                        ->first();
                    if(!empty($idBefore)){
                        $relation = \App\Models\RelationLiquidControl::where('liquid_control_id',$idBefore->id)
                            ->get();
                    }else{
                        $relation = '';
                    }
                @endphp
                @component('patients.pdf.liquid-control',['idBefore'=>$idBefore,'relation'=>$relation])
                @endcomponent
            @break
            @default
        @endswitch
    @endforeach
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 780, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
	</script>
@endsection
