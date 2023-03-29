<div class="description fz10 mt1" style="text-align: center; font-size:10pt !important;"><strong>Ayudas Diagnosticas</strong> <span style="visibility: hidden">espacio</span> Fecha: {{$date}}</div>
<!--
<div class="description fz10">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>
-->
@foreach($relation as $rel)
    <table>
        <tr>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong> Ayuda Diagnostica: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->diagnosis, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Examen: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->exam, "UTF-8")) }}
                </p>
            </td>
            <td>
                <p class="fz10" style="font-size:10pt !important;"><strong>Otro Examen: </strong> <br>
                    {{ ucwords(mb_strtolower($rel->other_exam, "UTF-8")) }}
                </p>
            </td>
        </tr>
    </table>
@endforeach
<p class="fz10" style="font-size:10pt !important;"><strong>Comentarios: </strong> {{ ucwords(mb_strtolower($idBefore->comments, "UTF-8")) }}
</p>
