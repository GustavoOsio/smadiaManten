<table class="table table-striped table-soft">
    <thead>
        <tr>
            <th style="text-align: center;">Imprimir</th>
            <th style="text-align: center;">Fecha</th>
            <th style="text-align: center;">Responsable</th>
            <th style="text-align: center;">Servicio</th>
            <th style="text-align: center;">Descripcion</th>
            <th style="text-align: center;">Observaciones</th>
            <th style="text-align: center;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicalHistory as $key => $mH)
        @if($mH->id_type == 16)
        <tr idtype="{{$mH->id_type}}" idrelation="{{$mH->id_relation}}" patientid="{{$mH->patient_id}}">
            <td style="text-align: center;">
                <div class="form-check">
                    <input class="form-check-input printhc" data-tipo="surgical-description" data-id="{{$mH->id_relation}}" type="checkbox" value="{{$mH->id_relation}}">
                </div>
            </td>
            <td style="text-align: center;">{{date("Y-m-d", strtotime($mH->date))}}</td>
            <td style="text-align: center;">{{$mH->NameUser}} {{$mH->LastNameUser}}</td>
            @php
            $value = \App\Models\SurgicalDescription::where('id',$mH->id_relation)->first();
            @endphp
            <td style="text-align: center;">
                {{$value->diagnosis}}
            </td>
            <td style="text-align: center;">
                {{$value->description_findings}}
            </td>
            <td style="text-align: center;">
                {{$value->observations}}
            </td>
            <td style="text-align: center;" class="modalMedicalHistory">
                <a onclick="modalMediaclHistory({{$mH->id_type}},{{$mH->id_relation}},{{$mH->patient_id}})"><span class="icon-eye mr-2"></span></a>
                <a href="{{url($mH->url.'/'.$mH->id_relation.'/edit')}}"><span class="icon-icon-11"></span></a>
                <a target="_blank" href="{{ url("patients/DescripQuiru/pdf/".$value->id) }}"><span class="icon-print-02"></span></a>

            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>