<div class="description fz10 mt1" style="text-align: center;font-size:10pt !important;"><strong>Tabla de medidas</strong></div>
<!--
<div class="description fz10">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>
-->
<table>
    <tr>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>IMC: </strong>
                {{ $idBefore->imc}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Peso: </strong>
                {{ $idBefore->weight}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Busto: </strong>
                {{ $idBefore->bust}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Contorno: </strong>
                {{ $idBefore->contour}}
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Cintura: </strong>
                {{ $idBefore->waistline}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Umbilical: </strong>
                {{ $idBefore->umbilical}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>ABD Inferior: </strong>
                {{ $idBefore->abd_lower}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>ABD Superior: </strong>
                {{ $idBefore->abd_higher}}
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Cadera: </strong>
                {{ $idBefore->hip}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Piernas: </strong>
                {{ $idBefore->legs}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Muslo derecho: </strong>
                {{ $idBefore->right_thigh}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Muslo izquierdo: </strong>
                {{ $idBefore->right_arm}}
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Brazo derecho: </strong>
                {{ $idBefore->right_arm}}
            </p>
        </td>
        <td>
            <p class="fz10"  style="font-size:10pt !important;"><strong>Brazo izquierdo: </strong>
                {{ $idBefore->left_arm}}
            </p>
        </td>
    </tr>
</table>
<p class="fz10"  style="font-size:10pt !important;"><strong>Observaciones: </strong>
    {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
</p>