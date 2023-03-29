<!--
<div class="description fz10 mt1" style="text-align: center"><strong>Fotografias</strong></div>
@php
    $vector = json_decode($photos->array_photos)
@endphp
<table>
    @for($i=0;$i<count($vector);$i++)
        <td>
            <img class="d-block w-100" src="{{asset($vector[$i])}}" alt="">
            <p class="fz10"><strong>Comentarios: </strong>
              {{ ucwords(mb_strtolower($photos->comments, "UTF-8")) }}
            </p>
        </td>
    @endfor
</table>
-->