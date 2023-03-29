<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura-{{ $data->id }}</title>
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
    <div class="title mb1">MARIA ANGELICA DIAZ</div>
    <div class="title fz9">NIT: 39.017.694-2</div>
    <div class="title fz9">CALLE 87 Nº 47 - 47</div>
    <div class="title fz9">PBX: 3177190</div>
    <div class="title fz9 mb1">RES. REGIMEN SIMPLIFICADO</div>
    <div class="labels">ORDEN DE PAGO Nº {{ $data->id }}</div>
    <div class="labels">FECHA {{ date("Y-m-d") }}</div>
    <div class="labels">LE ATENDIO: {{ ucwords(mb_strtolower($data->seller->name . " " . $data->seller->lastname)) }}</div>
    <div class="separate">***************************************************</div>
    <div class="labels">CLIENTE: {{ ucwords(mb_strtolower($data->patient->name . " " . $data->patient->lastname)) }}</div>
    <div class="labels">NIT/CC: {{ $data->patient->identy }}</div>
    <div class="labels">DIRECCION: {{ $data->patient->address }}</div>
    <div class="labels">TELEFONO: {{ $data->patient->cellphone }}</div>
    <div class="separate">***************************************************</div>
    <div class="labels tc mb05">DETALLES DE LA VENTA</div>
    <div class="labels qty tc">CANT</div>
    <div class="labels product tc">PRODUCTO</div>
    <div class="labels price tc">PRECIO</div>
    <div class="clear"></div>
    @foreach($data->products as $p)
        <div class="labels qty tc">{{ number_format($p->qty, 0) }}</div>
        <div class="labels product">{{ $p->product->name }}</div>
        @php
            if($p->discount == 0){
                $desc = $p->price * $p->qty;
                $desc = $desc - $p->discount_cop;
            }else{
                $desc = $p->price - ( ( $p->price * $p->discount) / 100);
                $desc = $desc * $p->qty;
            }
        @endphp
        <div class="labels price tr">${{ number_format(($desc), 0, ',', '.') }}</div>
        <div class="clear"></div>
    @endforeach
    <div class="clear"></div>
    <div class="mb05">&nbsp;</div>
    <div class="labels">DCTO: ${{ number_format((float)$data->discount_total, 0, ',', '.') }}</div>
    <div class="labels">SUBTOTAL: ${{ number_format($data->sub_amount, 0, ',', '.') }}</div>
    <div class="labels">IVA: ${{ number_format($data->tax, 0, ',', '.') }}</div>
    <div class="labels mb05">NETO: ${{ number_format($data->amount, 0, ',', '.') }}</div>
    <!--
    <div class="labels">RECIBIDO: ${{ number_format($data->receive, 0, ',', '.') }}</div>
    <div class="labels">CAMBIO: ${{ number_format($data->change, 0, ',', '.') }}</div>
    -->
    <div class="labels">F. DE PAGO: {{ ucfirst($data->method_payment) }}</div>
    @if($data->method_payment_2 <> '')
        <div class="labels">T. DE PAGO 1: ${{ number_format($data->total_1, 0, ',', '.') }}</div>
        <div class="labels">F. DE PAGO 2: {{ ucfirst($data->method_payment_2) }}</div>
        <div class="labels">T. DE PAGO 2: ${{ number_format($data->total_2, 0, ',', '.') }}</div>
    @endif
    <div class="separate">***************************************************</div>
    <div class="title fz9 mb05">GRACIAS POR PREFERIRNOS</div>
    <div class="title fz9 mb2">CONDICIONES DE GARANTIA: PARA EFECTOS DE GARANTIA DEBE PRESENTAR LA FACTURA</div>
    <div class="title fz9 mb2">___*** FIN FACTURA ***___</div>
    <div class="title fz9">
        Apreciable cliente, no realizará cambio de productos
        devolución de dinero por compra de los mismos, solo en los casos que haya lugar a hacer efectiva la garantía
    </div>
</div>
</body>
</html>
