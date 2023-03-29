<table border="1">
    <thead>
    <tr style="background: grey, color:white, font-weight:bold ">
        <th>FECHA</th>
        <th>VENDEDOR</th>
        <th>CONTRATO</th>
        <th>PACIENTE</th>
        <th>COMENTARIO INGRESO</th>
        <th>VALOR CONTRATO</th>
        <th>INGRESO</th>
        <th>TIPO PAGO</th>
        <th>PORCENTAJE</th>
        <th>DESCONTABLE</th>
        <th>VALOR BASE COMISIONABLE</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)

            <tr>
                <td>{{ $d->fecha }}</td>
                <td>{{ $d->vendedor }}</td>
                <td>C-{{ $d->contrato }}</td>
                <td>{{ $d->paciente}}</td>
                <td>{{ $d->comentario_ingreso }}</td>
                <td>{{ $d->valor_contrato}}</td>
                <td>{{ $d->ingreso }}</td>
                <td>{{ $d->tipo_pago }}</td>
                <td>{{ $d->porcentaje }}</td>
                <td>{{ $d->descontable }}</td>
                <td>{{ $d->valor_base_comisionable }}</td>
            </tr>
    @endforeach
    </tbody>
</table>
