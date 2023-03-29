<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Control de medicamento</strong></div>
<p class="fz10"><strong>Servicio: </strong>
    {{ ucwords(mb_strtolower($idBefore->service, "UTF-8")) }}
</p>
@foreach($relation as $rel)
    <table>
        <tr>
            <td>
                <p class="fz10"style="font-size:10pt !important;"><strong>Medicamento: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->medicine, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10"style="font-size:10pt !important;"><strong>Hora: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->hour, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10"style="font-size:10pt !important;"><strong>Fecha: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->date, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10"style="font-size:10pt !important;"><strong>Iniciales de enfermera: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->initial, "UTF-8")) }}
                </p>
            </td>
        </tr>
    </table>
@endforeach