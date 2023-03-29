<table class="table table-striped table-soft">
    <thead>
    <tr>
        <th>Paciente</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Profesional</th>
        <th>Contrato</th>
        <th>Servicio</th>
        <th>Comentario</th>
        <th>Hora inicio</th>
        <th>Hora fin</th>
        <th>Comentario de actualización</th>
        <th>Fecha de actualización</th>
        <th>Realizado por</th>
    </tr>
    </thead>
    <tbody>
    @foreach($historial_schedule as $s)
        <tr>
            @php
                $patient = \App\Models\Patient::find($s->patient_id);
            @endphp
            <td>{{ $patient->name .' '.$patient->lastname }}</td>
            <td>{{ $s->date }}</td>
            <td>{{ ucfirst($s->status) }}</td>
            <td>{{ $s->professional }}</td>
            @if($s->contract_id != '')
                <td>C-{{ $s->contract_id }}</td>
            @else
                <td></td>
            @endif
            <td>{{ $s->service }}</td>
            <td>{{ $s->comment }}</td>
            <td>{{ date("h:i a", strtotime($s->start)) }}</td>
            <td>{{ date("h:i a", strtotime($s->end)) }}</td>
            <td>{{ $s->comment_update }}</td>
            <td>{{ $s->date_update }}</td>
            <td>{{ $s->user }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
