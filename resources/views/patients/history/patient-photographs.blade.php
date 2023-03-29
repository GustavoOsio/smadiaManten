<table class="table table-striped table-soft">
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Responsable</th>
            <th>Comentarios</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($medicalHistory as $key => $mH)
                @if($mH->id_type == 17)
                    <tr idtype="{{$mH->id_type}}" idrelation="{{$mH->id_relation}}" patientid="{{$mH->patient_id}}">
                        <td>{{date("Y-m-d", strtotime($mH->date))}}</td>
                        <td>{{$mH->NameUser}} {{$mH->LastNameUser}}</td>
                        @php
                            $value = \App\Models\PatientPhotographs::where('id',$mH->id_relation)->first();
                        @endphp
                        <td>
                            {{$value->comments}}
                        </td>
                        <td class="modalMedicalHistory" onclick="modalMediaclHistory({{$mH->id_type}},{{$mH->id_relation}},{{$mH->patient_id}})">
                            <a><span class="icon-eye mr-2"></span></a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
</table>