<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Descripción Quirúrgica</strong></div>
<!--
<div class="description fz10">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>
-->
<p class="fz10" style="font-size:10pt !important;"><strong>Servicio: </strong>
    {{ ucwords(mb_strtolower($idBefore->diagnosis, "UTF-8")) }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Diagnostico Preoperatorio: </strong>
    {{ ucwords(mb_strtolower($idBefore->preoperative_diagnosis, "UTF-8")) }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Diagnostico Posoperatorio:</strong>
    {{ ucwords(mb_strtolower($idBefore->postoperative_diagnosis, "UTF-8")) }}
</p>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Cirujano: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->surgeon, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Anestesiologo: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->anesthesiologist, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Ayudante: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->assistant, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Instrumentador quirurjico: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->surgical_instrument, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Fecha: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->date, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Hora de inicio: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->start_time, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Hora de fin: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->end_time, "UTF-8")) }}
            </p>
        </td>
        <!--
        <td>
            <p class="fz10"><strong>Código Cups: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->code_cups, "UTF-8")) }}
            </p>
        </td>
        -->
    </tr>
</table>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Intervencion: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->intervention, "UTF-8")) }}
            </p>
        </td>
        <!--
        <td>
            <p class="fz10"><strong>Control Compresas: </strong>
                {{ ucwords(mb_strtolower($idBefore->control_compresas, "UTF-8")) }}
            </p>
        </td>
        -->
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Tipo Anestesia: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->type_anesthesia, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<p class="fz10" style="font-size:10pt !important;"><strong>Descripción del procedimiento: </strong> <br>
    {!! ucwords(mb_strtolower($idBefore->description_findings, "UTF-8"))  !!}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
    {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
</p>