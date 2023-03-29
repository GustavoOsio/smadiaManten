<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Plan de Tratamiento</strong></div>
<!--
<div class="description fz10">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>
-->
<table>
    @foreach($relation as $rel)
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Tratamiento: </strong>
                    {{ ucwords(mb_strtolower($rel->service_line, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
                    {{ ucwords(mb_strtolower($rel->observations, "UTF-8")) }}
                </p>
            </td>
        </tr>
    @endforeach
</table>
<p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
    {{ ucwords(mb_strtolower($rel->observations, "UTF-8")) }}
</p>