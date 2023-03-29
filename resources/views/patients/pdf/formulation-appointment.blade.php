<div class="description fz10 mt1" style="text-align: center; font-size:10pt !important;"><strong>Formulación</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

@foreach($relation as $rel)
    <table>
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Nombre del producto: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->formula, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Otro: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->other, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Cantidad: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->another_formula, "UTF-8")) }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Indicaciones: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->indications, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->formulation, "UTF-8")) }}
                </p>
            </td>
        </tr>
    </table>
@endforeach
