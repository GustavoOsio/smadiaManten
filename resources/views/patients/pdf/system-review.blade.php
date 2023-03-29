<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Revisión por Sistema</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

@foreach($systems as $sy)
    <p class="fz10" style="text-align: center;font-size:10pt !important;"><strong>{{$sy->name}}</strong>
    </p>
    @foreach($relation as $r)
        @if($r->systems_id == $sy->id)
            <p class="fz10" style="font-size:10pt !important;"><strong>{{$r->pathology}}:</strong>
                {{$r->select}}
            </p>
        @endif
    @endforeach
    @php
        switch ($sy->id) {
            case 1:
                $observation = $idBefore->system_head_face_neck;
                break;
            case 2:
                $observation = $idBefore->system_respiratory_cardio;
                break;
            case 3:
                $observation = $idBefore->system_digestive;
                break;
            case 4:
                $observation = $idBefore->system_genito_urinary;
                break;
            case 5:
                $observation = $idBefore->system_locomotor;
                break;
            case 6:
                $observation = $idBefore->system_nervous;
                break;
            case 7:
                $observation = $idBefore->system_integumentary;
                break;
        }
    @endphp
    <p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
        {{ ucwords(mb_strtolower($observation, "UTF-8")) }}
    </p>
    <div class="line-form"></div>
    <br>
@endforeach