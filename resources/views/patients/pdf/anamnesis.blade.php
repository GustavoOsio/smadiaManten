<div class="description fz10 mt1" style="text-align: center; font-size:10pt !important;"><strong>Anamnesis</strong></div>

<div class="description fz10" style="font-size:10pt !important;">
    Elaborado por: {{$elaborateFor->name}} {{$elaborateFor->lastname}} <span style="visibility: hidden">espacio</span> Fecha: {{$date}}<span style="visibility: hidden">espacio</span>Hora: {{$hour}}
</div>

<p class="fz10"  style="font-size:10pt !important;"><strong>Motivo de la consulta: </strong>
    {{ ucwords(mb_strtolower($idBefore->reason_consultation, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Enfermedad actual: </strong>
    {{ ucwords(mb_strtolower($idBefore->current_illness, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Antecedentes patológicos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_patologico, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Antecedentes quirurgicos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_surgical, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Antecedentes alergicos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_allergic, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Antecedentes traumáticos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_traumatic, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Antecedentes medicamentos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_medicines, "UTF-8")) }}
</p>
<p class="fz10"  style="font-size:10pt !important;"><strong>Antecedentes ginecológicos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_gynecological, "UTF-8")) }}
</p>
<!--
<p class="fz10"><strong>Antecedentes F.U.M: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_fum, "UTF-8")) }}
</p>
-->
<p class="fz10" style="font-size:10pt !important;"><strong>Antecedentes hábitos: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_habits, "UTF-8")) }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong> Antecedentes nutricionales: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_nutritional, "UTF-8")) }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Antecedentes familiares: </strong>
    {{ ucwords(mb_strtolower($idBefore->ant_familiar, "UTF-8")) }}
</p>
<p class="fz10" style="font-size:10pt !important;"><strong>Observaciones pacientes: </strong>
    {{ ucwords(mb_strtolower($idBefore->observations, "UTF-8")) }}
</p>