<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Evolución médica</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

<p class="fz10" style="font-size:10pt !important;"><strong>Evolución Medica: </strong>
    {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
</p>