<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Evolución de Enfermería</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

<p class="fz10"><strong>Evolución: </strong>
    {{ ucwords(mb_strtolower($idBefore->evolution, "UTF-8")) }}
</p>
@if($idBefore->array_evolutions != '')
    @php
        $relation = json_decode($idBefore->array_evolutions);
    @endphp
    @foreach($relation as $key => $rel)
        <p class="fz10"><strong>Evolución {{$key+1}}: </strong>
            {{ ucwords(mb_strtolower($rel, "UTF-8")) }}
        </p>
    @endforeach
@endif