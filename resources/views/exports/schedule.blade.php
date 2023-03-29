<table border="1">
        <thead>
            <tr>
                <th>Fecha de nacimiento</th>
                <th>Sexo</th>
                <th>Nombres</th>
                <th>Apellido</th>
                <!--
                <th>Tipo de identificacion</th>
                -->
                <th>Celular</th>
                <th>C.C</th>
                <th>EPS</th>
                <th>Fecha de solicitud de cita</th>
                <th>Profesional</th>
                <th>Servicio</th>
                <th>Fecha de cita</th>
                <th>Hora</th>
                <th>Hora Fin</th>
                <th>Estado</th>
                <th>Comentarios</th>
                <th>Agendada por</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $schedule)

            @php

            $AgendoCita = DB::select(
                "SELECT u.name as nombre , u.lastname as apellido
                FROM schedules s
                INNER JOIN users u ON u.id=s.user_id
                WHERE s.id= ? ",[$schedule->id]);

            @endphp

                <tr>
                    <td>{{ $schedule->patient->birthday }}</td>
                    <td>{{ $schedule->patient->gender_id != '' ? $schedule->patient->gender->name : '' }}</td>
                    <td>{{ ucwords(mb_strtolower($schedule->patient->name, "UTF-8")) }}</td>
                    <td>{{ ucwords(mb_strtolower($schedule->patient->lastname, "UTF-8")) }}</td>

                    <td>{{ $schedule->patient->cellphone }}</td>
                    <td>{{ $schedule->patient->identy }}</td>
                    <td>{{ $schedule->patient->eps_id != '' ? $schedule->patient->eps->name : '' }}</td>
                    <td>{{ date("Y-m-d", strtotime($schedule->created_at)) }}</td>

                    <td>{{ $schedule->profession->name . " " . $schedule->profession->lastname }}</td>
                    <td>{{ $schedule->service->name }}</td>
                    <td>{{ date("Y-m-d", strtotime($schedule->date)) }}</td>
                    <td>{{ date("h:i a", strtotime($schedule->start_time)) }}</td>
                    <td>{{ date("h:i a", strtotime($schedule->end_time)) }}</td>
                    <td>{{ ucfirst($schedule->status) }}</td>
                    <td>{{ $schedule->confirm_comment }}</td>
                    <td>{{ $AgendoCita[0]->nombre }} {{ $AgendoCita[0]->apellido }} </td>
                    <td>{{ $schedule->comment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
