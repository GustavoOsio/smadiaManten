<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Diagnostico clínico</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

 @foreach($relation as $rel)
     <table>
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Diagnostico: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->diagnosis, "UTF-8")) }}
                </p>
            </td>
            <!--
            <td>
                <p class="fz10"><strong>Tipo: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->type, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10"><strong>Causa Externa: </strong><br>
                    {{ ucwords(mb_strtolower($rel->external_cause, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10"><strong>Plan de Tratamiento: </strong><br>
                    {{ ucwords(mb_strtolower($rel->diagnosis, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10"><strong>otro: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->other, "UTF-8")) }}
                </p>
            </td>
            -->
        </tr>

    </table>
    <p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
        {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
    </p>
     <div class="line-form"></div>
@endforeach
<div class="line-form">
</div>
<p class="fz10" style="font-size:10pt !important;"><strong>Observacion General: </strong>
 {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
</p>