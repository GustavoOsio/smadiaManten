<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Exámen físico</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

<table>
    <td>
        <p class="fz10" style="font-size:10pt !important;"><strong>Peso: </strong>
            {{ $idBefore->weight }}
        </p>
    </td>
    <td>
        <p class="fz10" style="font-size:10pt !important;"><strong>Altura: </strong>
            {{ $idBefore->height }}
        </p>
    </td>
    <td>
        <p class="fz10" style="font-size:10pt !important;"><strong>IMC: </strong>
            {{ $idBefore->imc }}
        </p>
    </td>
</table>
<p class="fz10" style="font-size:10pt !important;"><strong>Cabeza y cuello: </strong>
    {{ $idBefore->head_neck }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Cardiopulmonar: </strong>
    {{ $idBefore->cardiopulmonary }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Abdomen: </strong>
    {{ $idBefore->abdomen }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Extremidades: </strong>
    {{ $idBefore->extremities }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Sistema nervioso: </strong>
    {{ $idBefore->nervous_system }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Piel y fanera: </strong>
    {{ $idBefore->skin_fanera }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Otros: </strong>
    {{ $idBefore->others }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
    {{ $idBefore->observations }}
</p>