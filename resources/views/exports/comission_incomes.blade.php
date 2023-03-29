<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Cédula</th>
        <th>Valor</th>
        <th>Descripción</th>
        <th>Centro de costo</th>
        <th>Forma de pago</th>
        <th>Contrato</th>
        <th>Fecha</th>
        <th>Vendedor</th>
        <th>Pago con tarjeta</th>
        <th>Total</th>
        <th>Comision</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $i)
        <tr>
            <td>I-{{ $i->income->id }}</td>
            <td>{{ $i->patient->name . " " . $i->patient->lastname }}</td>
            <td>{{ $i->patient->identy }}</td>
            <td>$ {{ number_format($i->amount, 0, ',', '.') }}</td>
            <td>{{ $i->description }}</td>
            <td>{{ $i->center->name }}</td>
            <td>{{$i->form_pay}}</td>
            <td>{{$i->contract}}</td>
            <td>{{$i->date}}</td>
            <td>{{ ucfirst(mb_strtolower($i->seller->name . " " . $i->seller->lastname)) }}</td>
            <td>{{$i->pay_card}}</td>
            <td>$ {{ number_format($i->totally, 0, ',', '.') }}</td>
            <td>$ {{ number_format($i->commission, 0, ',', '.') }}</td>
            <td> {{$i->income->status}} </td>
        </tr>
    @endforeach
    </tbody>
</table>
