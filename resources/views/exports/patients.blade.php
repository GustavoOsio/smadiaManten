<table border="1">
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>C.C</th>
        <th>Sexo</th>
        <th>Estado civil</th>
        <th>Nacimiento</th>
        <th>Edad</th>
        <th>Email</th>
        <th>Celular</th>
        <th>Direccion</th>
        <th>Ciudad</th>
        <th>Ocupación</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $patient)
        <tr>
            <td>{{ $patient->id }}</td>
            <td>{{ $patient->name }}</td>
            <td>{{ $patient->lastname }}</td>
            <td>{{ $patient->identy }}</td>
            <td>{{ ($patient->gender) ? $patient->gender->name : "" }} }}</td>
            <td>{{ ($patient->civil) ? $patient->civil->name : "" }}</td>
            <td>{{ $patient->birthday }}</td>
            
                 <td>    @php
                            $cumpleanos = new DateTime($patient->birthday);
                            $hoy = new DateTime();
                            $annos = $hoy->diff($cumpleanos);
                            print $annos->y;
                        @endphp</td>
                        
            <td>{{ $patient->email }}</td>
            <td>{{ $patient->cellphone }}</td>
            <td>{{ $patient->address }}</td>
            <td>{{  ($patient->city) ? $patient->city->name : ""  }}</td>
            <td>{{ $patient->ocupation }}</td>
            <td>
                {{ ucfirst($patient->status) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
