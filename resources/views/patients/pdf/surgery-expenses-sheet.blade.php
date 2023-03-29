<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Hoja de Gastos de Cirugía</strong></div>
<!--
<div class="description fz10">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>
-->
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Fecha: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->date_of_surgery, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Sala: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->room, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Peso: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->weight, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Tipo de Paciente: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->type_patient, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Tipo de Anestesia: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->type_anesthesia, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Tipo de Cirugia : </strong><br>
                {{ ucwords(mb_strtolower($idBefore->type_surgery, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Cirugia: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->surgery, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Código de Cirugia: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->surgery_code, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Hora de Ingreso: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->time_entry, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Hora de Inicio de Cirugia: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->start_time_surgery, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Hora de Final de Cirugia: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->end_time_surgery, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Cirujano: </strong> <br>
                {{ ucwords(mb_strtolower($idBefore->surgeon, "UTF-8")) }}
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
            <p class="fz10" style="font-size:10pt !important;"><strong>Anestesiologo: </strong>  <br>
                {{ ucwords(mb_strtolower($idBefore->anesthesiologist, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Rotadora: </strong>  <br>
                {{ ucwords(mb_strtolower($idBefore->rotary, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Instrumentadora: </strong>  <br>
                {{ ucwords(mb_strtolower($idBefore->instrument, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<div class="line-form">
</div>
@foreach($relation as $rel)
    <table>
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Codigo: </strong>
                    {{ ucwords(mb_strtolower($rel->code, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Producto: </strong>
                    {{ ucwords(mb_strtolower($rel->product, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Cant: </strong>
                    {{ ucwords(mb_strtolower($rel->cant, "UTF-8")) }}
                </p>
            </td>
        </tr>
    </table>
@endforeach
