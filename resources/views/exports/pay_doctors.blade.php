<table border="1">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Asistencial</th>
            <th>Trat. realizado</th>
            <th>Sesion</th>
            <th>Fecha</th>
            <th>Contrato</th>
            <th>Valor Trat.</th>
            <th>Trat. con Descuento</th>
            <th>Pago con Tarjeta</th>
            <th>Deducible</th>
            <th>Valor Final</th>
            <th>Valor Comision</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payment as $p)
        <tr>
            <td>{{$p->patient}}</td>
            <td>{{$p->identification}}</td>
            <td>{{$p->assistant}}</td>
            <td>{{$p->service}}</td>
            <td>{{$p->session}}</td>
            <td>{{$p->date}}</td>
            <td>{{$p->contract}}</td>
            <td>${{number_format($p->price,0,',','.')}}</td>
            <td>${{number_format($p->discount,0,',','.')}}</td>
            <td>${{number_format($p->card,0,',','.')}}</td>
            <td>${{number_format($p->deducible,0,',','.')}}</td>
            <td>${{number_format($p->totally,0,',','.')}}</td>
            <td>${{number_format($p->commission,0,',','.')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
