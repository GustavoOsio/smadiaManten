<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso-{{ $data->id }}</title>
    <!-- Styles -->
    <style>
        .content-dash {
            width: 237px;
            margin: -1rem 0 0 -2rem;
            color: #000000;
        }
        .fz13 {
            font-size: 13pt;
        }
        .fz11 {
            font-size: 11pt !important;
        }
        .fz10 {
            font-size: 10pt !important;
        }
        .fz9 {
            font-size: 9pt !important;
        }
        p {
            text-align: justify;
        }
        h3 {
            margin-top: 2rem;
        }
        .description {
            background: #E7E7E8;
            padding: .4rem .5rem
        }
        .mt2 {
            margin-top: 2rem;
        }
        .mt1 {
            margin-top: 1rem;
        }
        .left {
            float: left;
        }
        .right {
            float: right;
        }
        .mr2 {
            margin-right: 2rem;
        }
        .lh22 {
            line-height: 22px;
        }
        .btg {
            border-top: 1px solid #606060;
        }
        .w250 {
            width: 250px;
        }
        .m0 {
            margin: 0;
        }
        table {
            width: 100%;
            margin: .5rem 0 1rem;
        }
        table th {
            padding: .1rem .7rem;
            text-align: left;
            font-size: 10pt;
        }
        table td {
            font-size: 10pt;
            padding: .2rem .7rem;
        }
        .title {
            text-align: center;
            font-size: 10pt;
        }
        .mb1 {
            margin-bottom: 1rem !important;
        }
        .labels {
            font-size: 9pt;
        }
        .separate {
            margin: .5rem 0 .4rem;
            font-size: 7pt;
        }
        .tc {
            text-align: center;
        }
        .clear {
            clear: both;
        }
        .qty {
            float: left;
            width: 35px;
        }
        .mb05 {
            margin-bottom: .5rem;
        }
        .product {
            float: left;
            width: 120px;
        }
        .price {
            float: right;
            width: 82px;
        }
        .tr {
            text-align: right;
        }
        .mb2 {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
<div class="content-dash">
    <div class="title mb1">SMADIA MEDICAL GROUP S.A.S.</div>
    <div class="title fz9">NIT:  900385003-9</div>
    <div class="title fz9">CALLE 87 Nº 47 - 47</div>
    <div class="title fz9">PBX: 3177190</div>
    <div class="title fz9 mb1">RES. RÉGIMEN COMÚN</div>
    <div class="labels">Recibo de caja Nº {{ $data->id }}</div>
    <div class="labels">FECHA {{ date('Y-m-d',strtotime($data->created_at)) }}</div>
    <div class="labels">LE ATENDIO: {{ ucwords(mb_strtolower($data->user->name . " " . $data->user->lastname)) }}</div>
    <div class="labels">VENDIDO POR: {{ ucwords(mb_strtolower($data->seller->name . " " . $data->seller->lastname)) }}</div>
    <div class="separate">***************************************************</div>
    <div class="labels">CLIENTE: {{ ucwords(mb_strtolower($data->patient->name . " " . $data->patient->lastname)) }}</div>
    <div class="labels">NIT/CC: {{ $data->patient->identy }}</div>
    <div class="labels">DIRECCION: {{ $data->patient->address }}</div>
    <div class="labels">TELEFONO: {{ $data->patient->cellphone }}</div>
    <div class="separate">***************************************************</div>
    <div class="labels tc mb05">DATOS DE LA VENTA</div>
    <div class="labels">F. DE PAGO: {{ ucfirst($data->method_of_pay) }}</div>
    @if($data->method_of_pay_2 != '')
        <div class="labels">VALOR: ${{ number_format($data->amount_one, 2, ',', '.') }}</div>
        <div class="labels">F. DE PAGO DOS: {{ ucfirst($data->method_of_pay_2) }}</div>
        <div class="labels">VALOR: ${{ number_format($data->amount_two, 2, ',', '.') }}</div>
    @endif
    <div class="labels">TOTAL: ${{ number_format($data->amount, 2, ',', '.') }}</div>
    <div class="separate">***************************************************</div>
    <div class="labels tc mb05">DESCRIPCION</div>
    <div class="labels">{{ ucfirst($data->comment) }}</div>
    <div class="separate">***************************************************</div>
    <div class="title fz9 mb05">GRACIAS POR PREFERIRNOS</div>
    <div class="title fz9 mb2">___*** FIN FACTURA ***___</div>
    <div class="title fz9">
        Apreciable cliente SMADIA MEDICAL GROUP S.A.S.
        no realizara devolución del dinero recibido
        por prestación de servicios o tratamientos
        adquiridos, en caso de ser solicitado el
        reenbolso se le entregara un bono equivalente
        al valor correspondiente que podrá utilizar
        en cualquiera de nuestros tratamientos.
    </div>
</div>
</body>
</html>
