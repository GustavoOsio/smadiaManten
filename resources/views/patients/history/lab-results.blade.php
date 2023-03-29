<table class="table table-striped table-soft">
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Responsable</th>
            <th>Descripcion</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($medicalHistory as $key => $mH)
                @if($mH->id_type == 18)
                    <tr idtype="{{$mH->id_type}}" idrelation="{{$mH->id_relation}}" patientid="{{$mH->patient_id}}">
                        <td>{{date("Y-m-d", strtotime($mH->date))}}</td>
                        <td>{{$mH->NameUser}} {{$mH->LastNameUser}}</td>
                        @php
                            $value = \App\Models\LabResults::where('id',$mH->id_relation)->first();
                        @endphp
                        <td>
                            {{$value->description}}
                        </td>
                        <td class="modalMedicalHistory" onclick="modalMediaclHistory({{$mH->id_type}},{{$mH->id_relation}},{{$mH->patient_id}})">
                            <a><span class="icon-eye mr-2"></span></a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
</table>