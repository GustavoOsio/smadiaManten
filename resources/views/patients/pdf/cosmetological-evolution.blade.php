<div class="description fz10 mt1" style="text-align: center; font-size:10pt !important;"><strong>Evolución Cosmetológica</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

<p class="fz10" style="font-size:10pt !important;"><strong>Evolución: </strong>
    {{ ucwords(mb_strtolower($idBefore->evolution, "UTF-8")) }}
</p>