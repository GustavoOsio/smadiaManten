<div class="description fz10 mt1" style="text-align: center; font-size:10pt !important;"><strong>Hoja de Gastos</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
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
<p class="fz10" style="font-size:10pt !important;"><strong>Observaciones: </strong>
    {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
</p>
