<table class="table table-striped table-soft">
    <thead>
        <tr>
            <th style="text-align: center;">Imprimir</th>
            <th style="text-align: center;">Fecha</th>
            <th style="text-align: center;">Responsable</th>
            <th style="text-align: center;">IMC</th>
            <th style="text-align: center;">Peso</th>
            <th style="text-align: center;">Busto</th>
            <th style="text-align: center;">Contorno</th>
            <th style="text-align: center;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicalHistory as $key => $mH)
        @if($mH->id_type == 4)
        <tr idtype="{{$mH->id_type}}" idrelation="{{$mH->id_relation}}" patientid="{{$mH->patient_id}}">
            <td style="text-align: center;">
                <div class="form-check">
                    <input class="form-check-input printhc" data-tipo="tmedidas" data-id="{{$mH->id_relation}}" type="checkbox" value="{{$mH->id_relation}}">
                </div>
            </td>
            <td>{{date("Y-m-d", strtotime($mH->date))}}</td>
            <td>{{$mH->NameUser}} {{$mH->LastNameUser}}</td>
            @php
            $value = \App\Models\Measurements::where('id',$mH->id_relation)->first();
            @endphp
            <td>
                {{$value->imc}}
            </td>
            <td>
                {{$value->weight}}
            </td>
            <td>
                {{$value->bust}}
            </td>
            <td>
                {{$value->contour}}
            </td>
            <td class="modalMedicalHistory">
                <a onclick="modalMediaclHistory({{$mH->id_type}},{{$mH->id_relation}},{{$mH->patient_id}})"><span class="icon-eye mr-2"></span></a>
                <a href="{{url($mH->url.'/'.$mH->id_relation.'/edit')}}"><span class="icon-icon-11"></span></a>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>