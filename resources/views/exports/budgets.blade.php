<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre Completo</th>
        <th>Identificación</th>
        <th>Celular</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Elaborado Por</th>
        <th>Vendedor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>C-{{ $d->id }}</td>
            <td>{{ ucwords(mb_strtolower($d->patient->name . " " . $d->patient->lastname, "UTF-8")) }}</td>
            <td>{{ $d->patient->identy }}</td>
            <td>{{ $d->patient->cellphone }}</td>
            <td>{{ ucfirst($d->status) }}</td>
            <td>{{ date("Y-m-d", strtotime($d->created_at)) }}</td>
            <td>$ {{ number_format($d->amount, 2) }}</td>
            <td>{{ ucwords(mb_strtolower($d->user->name . " " . $d->user->lastname, "UTF-8")) }}</td>
            <td>{{ ucwords(mb_strtolower($d->seller->name . " " . $d->seller->lastname, "UTF-8")) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
