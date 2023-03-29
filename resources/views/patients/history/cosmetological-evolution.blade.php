<table class="table table-striped table-soft">
    <thead>
        <tr>
            <th style="text-align: center;">Imprimir</th>
            <th style="text-align: center;">Fecha</th>
            <th style="text-align: center;">Responsable</th>
            <th style="text-align: center;">Evolución</th>
            <th style="text-align: center;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicalHistory as $key => $mH)
        @if($mH->id_type == 10)
        <tr idtype="{{$mH->id_type}}" idrelation="{{$mH->id_relation}}" patientid="{{$mH->patient_id}}">
            <td style="text-align: center;">
                <div class="form-check">
                    <input class="form-check-input printhc" data-tipo="cosmetological-evolution" data-id="{{$mH->id_relation}}" type="checkbox" value="{{$mH->id_relation}}">
                </div>
            </td>
            <td style="text-align: center;">{{str_replace('/','-',$mH->date)}}</td>
            <td style="text-align: center;">{{$mH->NameUser}} {{$mH->LastNameUser}}</td>
            @php
            $value = \App\Models\CosmetologicalEvolution::where('id',$mH->id_relation)->first();
            @endphp
            <td style="text-align: center;">
                {{$value->evolution}}
            </td>
            <td style="text-align: center;" class="modalMedicalHistory">
                <a onclick="modalMediaclHistory({{$mH->id_type}},{{$mH->id_relation}},{{$mH->patient_id}})"><span class="icon-eye mr-2"></span></a>
                <a href="{{url($mH->url.'/'.$mH->id_relation.'/edit')}}"><span class="icon-icon-11"></span></a>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>