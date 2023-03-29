<div class="description fz10 mt1" style="text-align: center; font-size:10pt !important;"><strong>Plan de Medicina Biologica</strong></div>

<div class="description fz10"  style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

@php
    $relation = json_decode($idBefore->array_biological_medicine);
    $observations = json_decode($idBefore->array_observations);
@endphp
@foreach($relation as $key => $rel)
    <p class="fz10" style="font-size:10pt !important;"><strong>Medicina Biologíca: </strong>
        {{ ucwords(mb_strtolower($rel, "UTF-8")) }}
    </p>
    <p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong> <br>
        {{ ucwords(mb_strtolower($observations[$key], "UTF-8")) }}
    </p>
@endforeach
