<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')-{{ $data->id }}</title>
    <!-- Styles -->
    <style>
        .content-dash {
            width: 820px;
            margin: -3.8rem 0 0 -2.8rem;
            color: #606060;
            font-family : Arial, sans-serif;
        }
        .logo {
            background: rgba(255, 255, 255, 0.6) url("../../img/fondo-pdf-02.jpg") no-repeat top center;
            width: 100%;
            padding: 5.2rem 3.2rem;
        }
        .content{
            padding: 5.2rem 3.2rem;
            padding-top: 0%;
            margin-top: -8%;
        }
        .logo .img {
            background: url("../../img/logo-smadia-02.png") no-repeat;
            width: 250px;
            height: 40px;
            background-size: contain;
        }
        .fz13 {
            font-size: 13pt;
        }
        .fz11 {
            font-size: 11pt;
        }
        .fz10 {
            font-size: 10pt;
        }
        .fz9 {
            font-size: 9pt;
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
    </style>
</head>
<body>
<div class="content-dash">
    <div class="logo">
    </div>
    <div class="content">
        @yield('content')
    </div>
</div>
</body>
</html>
