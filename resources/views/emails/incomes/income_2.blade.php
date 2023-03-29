<?php
$http = url('/');
//$income = \App\Models\Income::find(9);
?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="stylesheet" href="">
    <title>Se ha generado un ingreso</title>
</head>
<body>
<table cellpadding="0" cellspacing="0" align="center" border="0" width="100%" >
    <tr>
        <td width="600" border="0"  align="center">
            <table cellpadding="0" cellspacing="0" border="0" width="600" style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif">
                <tr>
                    <td align="center" valign="middle" bgcolor="#F2F2F2" width="100%" style="width:100%; text-align: center; border:0; padding: 0; background-color: #F2F2F2;">
                        <table cellpadding="0" align="center" cellspacing="0" border="0" width="400">
                            <tr>
                                <td align="center" border="0" style="padding-top: 20px; padding-bottom: 20px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 13pt; color: #DAA520; line-height: 1.5em;">
                                    <div style='background: #DAA520; color: #F0F0F0;width: 98%; padding: 5px 10px;'>INGRESO</div>
                                    <br>
                                    <div style='padding-left: 10px; text-align: left; color: #696969; font-size: 15px'>
                                        <strong>Doc. Beneficio:</strong> I-{{ $income->id }} <br>
                                        <strong>Nombre del paciente:</strong> {{ ucwords(mb_strtolower($income->patient->name)) }} {{ ucwords(mb_strtolower($income->patient->lastname)) }}<br>
                                        <strong>Forma de pago:</strong>  {{ ucfirst($income->method_of_pay) }}<br>
                                        @if($income->method_of_pay_2 != '')
                                            <strong>Total 1:</strong> $ {{number_format($income->amount_one, 0, ',', '.')}}<br>
                                            <strong>Forma de pago 2:</strong> {{ ucfirst($income->method_of_pay_2) }}<br>
                                            <strong>Total 2:</strong> $ {{number_format($income->amount_two, 0, ',', '.')}}<br>
                                        @else
                                            <strong>Total:</strong> $ {{number_format($income->amount, 0, ',', '.')}}<br>
                                        @endif
                                        <strong>Fecha:</strong> {{ date("d/m/Y", strtotime($income->created_at)) }}<br>
                                        @if($income->method_of_pay_2 != '')
                                            <strong>Valor Total:</strong> $ {{ number_format($income->amount, 0,',', '.') }} <br>
                                        @endif
                                        <strong>Centro de Costos:</strong> {{ $income->center->name }}<br>
                                        <strong>Vendedor:</strong> {{ $income->seller->name . " " . $income->seller->lastname }}<br><br>
                                        <strong>Comentarios:</strong> <br>
                                        {{ $income->comment }} <br>
                                        <strong>Usuario que lo creó:</strong> <br>
                                        {{ ucwords(mb_strtolower($income->user->name)) }} {{ ucwords(mb_strtolower($income->user->lastname)) }} <br><br>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Se ha generado un ingreso</title>
</head>
<body style="background-color: white ">
<!--Copia desde aquí-->
<table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">

    <tr>
        <td style="background-color: #ecf0f1">
            <div style="color: #34495e; margin: 4% 10% 2%; font-family: sans-serif;text-align: center">
                <h2 style="background: #DAA520; color: #ffffff; margin: 0 0 7px;padding: 2% 0%;text-align: center">INGRESO</h2> <br>
                <p style="margin: 2px; font-size: 15px;text-align: left;color: #696969;">
                    <strong>Doc. Beneficio:</strong> I-{{ $income->id }} <br>
                    <strong>Nombre del paciente:</strong> {{ ucwords(mb_strtolower($income->patient->name)) }} {{ ucwords(mb_strtolower($income->patient->lastname)) }}<br>
                    <strong>Forma de pago:</strong>  {{ ucfirst($income->method_of_pay) }}<br>
                    @if($income->method_of_pay_2 != '')
                        <strong>Total 1:</strong> $ {{number_format($income->amount_one, 0, ',', '.')}}<br>
                        <strong>Forma de pago 2:</strong> {{ ucfirst($income->method_of_pay_2) }}<br>
                        <strong>Total 2:</strong> $ {{number_format($income->amount_two, 0, ',', '.')}}<br>
                    @else
                        <strong>Total:</strong> $ {{number_format($income->amount, 0, ',', '.')}}<br>
                    @endif
                    <strong>Fecha:</strong> {{ date("d/m/Y", strtotime($income->created_at)) }}<br>
                    @if($income->method_of_pay_2 != '')
                        <strong>Valor Total:</strong> $ {{ number_format($income->amount, 0,',', '.') }} <br>
                    @endif
                    <strong>Centro de Costos:</strong> {{ $income->center->name }}<br>
                    <strong>Vendedor:</strong> {{ $income->seller->name . " " . $income->seller->lastname }}<br><br>
                    <strong>Comentarios:</strong> <br>
                    {{ $income->comment }} <br>
                    <strong>Usuario que lo creó:</strong> <br>
                    {{ ucwords(mb_strtolower($income->user->name)) }} {{ ucwords(mb_strtolower($income->user->lastname)) }} <br><br>
                </p>
            </div>
        </td>
    </tr>
</table>
<!--hasta aquí-->
