<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Notas de Enfermería</strong></div>

<div class="description fz10"style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>
</div>

<table>
    <td>
        <p class="fz10" style="font-size:10pt !important;"><strong>Fecha de Nota: </strong>
            {{ $idBefore->date }}
        </p>
    </td>
    <td>
        <p class="fz10" style="font-size:10pt !important;"><strong>Hora de Nota: </strong>
            {{ $idBefore->hour }}
        </p>
    </td>
</table>
<p class="fz10" style="font-size:10pt !important;"><strong>Nota: </strong>
    {{ $idBefore->note }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
    {{ $idBefore->observations }}
</p>