<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Tema</th>
        <th>Fecha</th>
        <th>Observaciones</th>
        <th>Estado</th>
        <th>Responsable</th>
        <th>Registrado por</th>
        <th>Fecha creación</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $m)
        <tr>
            <td>S-{{ $m->id }}</td>
            <td>{{ ucwords(mb_strtolower($m->patient->name . " " . $m->patient->lastname)) }}</td>
            <td>{{ $m->patient->identy }}</td>
            <td>{{ $m->issue->name }}</td>
            <td>{{ date("Y-m-d", strtotime($m->date)) }}</td>
            <td>{{ $m->comment }}</td>
            <td>{{ ucfirst($m->status) }}</td>
            <td>{{ ucwords(mb_strtolower($m->responsable->name . " " . $m->responsable->lastname)) }}</td>
            <td>{{ ucwords(mb_strtolower($m->user->name . " " . $m->user->lastname)) }}</td>
            <td>{{ date("Y-m-d", strtotime($m->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
