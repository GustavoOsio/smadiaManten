<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Control de liquidos</strong></div>
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Parenteral 1: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->parental_1, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Parenteral 2: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->parental_2, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Parenteral 3: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->parental_3, "UTF-8")) }}
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Parenteral 4: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->parental_4, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Parenteral 5: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->parental_5, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>
<div class="line-form"></div>
@foreach($relation as $rel)
    <table>
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Hora: </strong><br>
                    {{ ucwords(mb_strtolower($rel->hour, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Tipo: </strong><br>
                    {{ ucwords(mb_strtolower($rel->type, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Elemento: </strong><br>
                    {{ ucwords(mb_strtolower($rel->type_element, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Cantidad CC: </strong><br>
                    {{ ucwords(mb_strtolower($rel->box, "UTF-8")) }}
                </p>
            </td>
        </tr>
    </table>
    <div class="line-form"></div>
@endforeach
<table>
    <tr>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Total Administrados: </strong><br>
                {{ ucwords(mb_strtolower($idBefore->total_adm, "UTF-8")) }}
            </p>
        </td>
        <td>
            <p class="fz10" style="font-size:10pt !important;"><strong>Total eliminados:</strong><br>
                {{ ucwords(mb_strtolower($idBefore->total_del, "UTF-8")) }}
            </p>
        </td>
    </tr>
</table>