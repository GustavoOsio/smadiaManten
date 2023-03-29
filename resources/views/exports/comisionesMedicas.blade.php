<table border="1">
    <thead>
    <tr>
        <th colspan="11">Ventas realizadas</th>
    </tr>
    <tr>
        <th>id</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Valor</th>
        <th>Descripción</th>
        <th>Centro de Costo</th>
        <th>Forma de Pago</th>
        <th>Contrato</th>
        <th>Vendedor</th>
        <th>5%</th>
        <th>VR TOTAL</th>
        <th>VR COMISÓN</th>
    </tr>
    </thead>
    <tbody>

    @php
    $totalValor=0;
    $totalComision=0;
    $totalVR=0;
    $totalTarjeta=0;
    $totalValorComision=0;
    $totalValorComision2=0;         
$totalComision=0;    
$totalValorComision1=0; 
    @endphp
    
    @foreach($data as $d)
    @php


    $totalValor+=$d->amount;
            $method_pay = ucfirst($d->method_of_pay);
            if($d->method_of_pay_2 != ''){
                $method_pay = $method_pay .'/'.ucfirst($d->method_of_pay_2);
            }



            if($method_pay=='Tarjeta' || $method_pay=='Online' || $method_pay=='Tarjeta/Tarjeta'){
                $descuento=($d->amount*5)/100;
            }elseif($method_pay=='Tarjeta/Efectivo'){
                $descuento=($d->amount_one*5)/100;
            } 
            else{
                $descuento=0;
            }

            $valorTotal=$d->amount-$descuento;

            if($d->porcentajeComision!=""){
                $comision=($valorTotal*$d->porcentajeComision)/100;
            } else{
                $comision=0;
            }

    $totalComision+=$comision;
    $totalVR+=$valorTotal;
    $totalTarjeta+=$descuento;
        @endphp

            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->patient->name . " " . $d->patient->lastname }}</td>
                <td>{{ $d->patient->identy }}</td>
                <td>${{ number_format($d->amount)  }}</td>
                <td>{{ $d->comment }}</td>
                @if($d->center_cost_id != '')
                    <td>{{ $d->center->name }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ ucfirst($method_pay) }}</td>
                              
                <td>{{ ($d->contract) ? "C-" . $d->contract->id : "" }}</td>
                <td>{{ $d->seller->name . " " . $d->seller->lastname }}</td>
                <td>${{number_format($descuento)}}</td>
                <td>${{number_format($valorTotal)}}</td>
                <td>${{number_format($comision)}}</td>
            </tr>
       
    @endforeach
    </tbody>
<tfoot>
    <tr>
        <td></td>
        <td>Total</td>
        <td>${{number_format($totalValor)}}</td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>         
        <td></td>       
        <td>Totales</td>        
        <td>${{number_format($totalTarjeta)}}</td>        
        <td>${{number_format($totalVR)}}</td>        
        <td>${{number_format($totalComision)}}</td>
    </tr>
</tfoot>

</table>


<br>
<br>

@if( sizeof($dataSuero) != 0)
<table border="1">
    <thead>
    <tr>
        <th colspan="11">Med Bio</th>
    </tr>
    <tr>
        <th>id</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Valor</th>
        <th>Descripción</th>
        <th>Centro de Costo</th>
        <th>Forma de Pago</th>
        <th>Contrato</th>
        <th>Vendedor</th>
        <th>5%</th>
        <th>VR TOTAL</th>
        <th>VR COMISÓN</th>
    </tr>
    </thead>
    <tbody>

    @php
    $totalValor=0;
    $totalComisionSuero=0;
    $totalVR=0;
    $totalTarjeta=0;

    @endphp
    
    @foreach($dataSuero as $d)
    @php


    $totalValor+=$d->amount;
            $method_pay = ucfirst($d->method_of_pay);
            if($d->method_of_pay_2 != ''){
                $method_pay = $method_pay .'/'.ucfirst($d->method_of_pay_2);
            }



            if($method_pay=='Tarjeta' || $method_pay=='Online' || $method_pay=='Tarjeta/Tarjeta'){
                $descuento=($d->amount*5)/100;
            }elseif($method_pay=='Tarjeta/Efectivo'){
                $descuento=($d->amount_one*5)/100;
            } 
            else{
                $descuento=0;
            }


            $valorTotal=$d->amount-$descuento;

            if($d->porcentajeComision!=""){
                $comision=($valorTotal*$d->porcentajeComision)/100;
            } else{
                $comision=0;
            }

    $totalComisionSuero+=$comision;
    $totalVR+=$valorTotal;
    $totalTarjeta+=$descuento;
        @endphp

            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->patient->name . " " . $d->patient->lastname }}</td>
                <td>{{ $d->patient->identy }}</td>
                <td>${{ number_format($d->amount)  }}</td>
                <td>{{ $d->comment }}</td>
                @if($d->center_cost_id != '')
                    <td>{{ $d->center->name }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ ucfirst($method_pay) }}</td>
                              
                <td>{{ ($d->contract) ? "C-" . $d->contract->id : "" }}</td>
                <td>{{ $d->seller->name . " " . $d->seller->lastname }}</td>
                <td>${{number_format($descuento)}}</td>
                <td>${{number_format($valorTotal)}}</td>
                <td>${{number_format($comision)}}</td>
            </tr>
       
    @endforeach
    </tbody>
<tfoot>
    <tr>
        <td></td>
        <td>Total</td>
        <td>${{number_format($totalValor)}}</td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>         
        <td></td>       
        <td>Totales</td>        
        <td>${{number_format($totalTarjeta)}}</td>        
        <td>${{number_format($totalVR)}}</td>        
        <td>${{number_format($totalComisionSuero)}}</td>
    </tr>
</tfoot>

</table>

@endif



<br>
<br>
<br>


 @if($asistenciales != "")
<table border="1">
    <thead>
    <tr>
        <th colspan="13">Tratamientos realizados</th>
    </tr>
    <tr>
        <th>Numero</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Asistencial</th>
        <th>Tratamiento realizado</th>
        <th>Sesion</th>
        <th>Fecha de acción</th>
        <th>Contrato</th>
        <th>Valor tratamiento</th>
        <th>Tratamiento con Descuento</th>
        <th>PAGO X TARJ</th>
        <th>DEDUCIBLE</th>
        <th>VR FINAL </th>
        <th>VR COMISIÓN </th>
    </tr>
    </thead>
    <tbody>
    @php
    $totalValorTratamiento=0;
    $totalValorDescuento=0;
    $totalValorFinal=0;
    $totalValorComision=0;
    $totalDeducible=0;
    $totalValorComision2=0;
    $a=0
    @endphp
    @foreach($asistenciales as $asis)
    @php
    $a++;
    $deducible=($asis->desc*40)/100;
    $tarjeta=0;


    $vrfinal=$asis->desc-$tarjeta-$deducible;
    $vrComision=($vrfinal*$asis->porcentajeComision)/100;


    $totalValorTratamiento+=$asis->price;
    $totalValorDescuento+=$asis->desc;
    $totalDeducible+=$deducible;
    $totalValorFinal+=$vrfinal;
    $totalValorComision2+=$vrComision;
        @endphp

            <tr>
            <td>{{ $a }}</td>
                <td>{{ $asis->patient }}</td>
                <td>{{ $asis->identi }}</td>
                <td>{{ $asis->asyst }}</td>
                <td>{{ $asis->serv }}</td>                
                <td>{{ $asis->sesion }}</td>
                <td>{{ $asis->date }}</td>
                <td>{{ $asis->contract }}</td>
                <td>{{ number_format($asis->price)  }}</td>
                <td>{{ number_format($asis->desc)  }}</td>
                <td>{{ number_format($tarjeta)  }}</td>
                <td>{{ number_format($deducible)  }}</td>
                <td>{{ number_format($vrfinal)  }}</td>
                <td>{{ number_format($vrComision)  }}</td>
                              
            </tr>

       
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>      
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td>Totales</td>        
        <td>${{number_format($totalValorTratamiento)}}</td>            
        <td>${{number_format($totalValorDescuento)}}</td>        
        <td>0</td>        
        <td>${{number_format($totalDeducible)}}</td>          
        <td>${{number_format($totalValorFinal)}}</td>        
        <td>${{number_format($totalValorComision2)}}</td>
    </tr>
</tfoot>
</table>

@endif

<br>
<br>
<br>
<br>
<br>







@if( sizeof($madLaser)>0)
<table border="1">
    <thead>
    <tr>
        <th colspan="13">Mad Laser</th>
    </tr>
    <tr>
        <th>Numero</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Asistencial</th>
        <th>Tratamiento realizado</th>
        <th>Sesion</th>
        <th>Fecha de acción</th>
        <th>Contrato</th>
        <th>Valor tratamiento</th>
        <th>Tratamiento con Descuento</th>
        <th>PAGO X TARJ</th>
        <th>DEDUCIBLE</th>
        <th>VR FINAL </th>
        <th>VR COMISIÓN </th>
    </tr>
    </thead>
    <tbody>
    @php
    $totalValorTratamiento=0;
    $totalValorDescuento=0;
    $totalValorFinal=0;
    $totalValorComision=0;
    $totalDeducible=0;
    $totalValorComision1=0;
    $a=0
    @endphp
    @foreach($madLaser as $asis)
    @php
    $a++;
    $tarjeta=0;


    $vrfinal=$asis->desc-$tarjeta;
    $vrComision=($vrfinal*$asis->porcentajeComision)/100;


    $totalValorTratamiento+=$asis->price;
    $totalValorDescuento+=$asis->desc;
    $totalValorFinal+=$vrfinal;
    $totalValorComision1+=$vrComision;

        @endphp

            <tr>
            <td>{{ $a }}</td>
                <td>{{ $asis->patient }}</td>
                <td>{{ $asis->identi }}</td>
                <td>{{ $asis->asyst }}</td>
                <td>{{ $asis->serv }}</td>                
                <td>{{ $asis->sesion }}</td>
                <td>{{ $asis->date }}</td>
                <td>{{ $asis->contract }}</td>
                <td>{{ number_format($asis->price)  }}</td>
                <td>{{ number_format($asis->desc)  }}</td>
                <td>{{ number_format($tarjeta)  }}</td>
                <td></td>
                <td>{{ number_format($vrfinal)  }}</td>
                <td>{{ number_format($vrComision)  }}</td>
                              
            </tr>

       
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>      
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td>Totales</td>        
        <td>${{number_format($totalValorTratamiento)}}</td>            
        <td>${{number_format($totalValorDescuento)}}</td>        
        <td>0</td>        
        <td></td>          
        <td>${{number_format($totalValorFinal)}}</td>        
        <td>${{number_format($totalValorComision1)}}</td>
    </tr>
</tfoot>
</table>

@endif




<br>
<br>
<br>
<br>
<br>


@if( sizeof($lipoVal)>0)
<table border="1">
    <thead>
    <tr>
        <th colspan="13">Lipoval</th>
    </tr>
    <tr>
        <th>Numero</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Asistencial</th>
        <th>Tratamiento realizado</th>
        <th>Sesion</th>
        <th>Fecha de acción</th>
        <th>Contrato</th>
        <th>Valor tratamiento</th>
        <th>Tratamiento con Descuento</th>
        <th>PAGO X TARJ</th>
        <th>DEDUCIBLE</th>
        <th>VR FINAL </th>
        <th>VR COMISIÓN </th>
    </tr>
    </thead>
    <tbody>
    @php
    $totalValorTratamiento=0;
    $totalValorDescuento=0;
    $totalValorFinal=0;
    $totalValorComision=0;
    $totalDeducible=0;
    $totalValorComision=0;
    $a=0
    @endphp
    @foreach($lipoVal as $asis)
    @php
    $a++;
    $tarjeta=0;
if($asis->desc>0){
    $deducible=700000;
} else{
    $deducible=0;
}


    $vrfinal=$asis->desc-$tarjeta-$deducible;
    $vrComision=($vrfinal*$asis->porcentajeComision)/100;


    $totalValorTratamiento+=$asis->price;
    $totalValorDescuento+=$asis->desc;
    $totalValorFinal+=$vrfinal;
    $totalValorComision+=$vrComision;
        @endphp

            <tr>
            <td>{{ $a }}</td>
                <td>{{ $asis->patient }}</td>
                <td>{{ $asis->identi }}</td>
                <td>{{ $asis->asyst }}</td>
                <td>{{ $asis->serv }}</td>                
                <td>{{ $asis->sesion }}</td>
                <td>{{ $asis->date }}</td>
                <td>{{ $asis->contract }}</td>
                <td>{{ number_format($asis->price)  }}</td>
                <td>{{ number_format($asis->desc)  }}</td>
                <td>{{ number_format($tarjeta)  }}</td>
                <td>{{number_format($deducible)}}</td>
                <td>{{ number_format($vrfinal)  }}</td>
                <td>{{ number_format($vrComision)  }}</td>
                              
            </tr>

       
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>      
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td></td>        
        <td>Totales</td>        
        <td>${{number_format($totalValorTratamiento)}}</td>            
        <td>${{number_format($totalValorDescuento)}}</td>        
        <td>0</td>        
        <td></td>          
        <td>${{number_format($totalValorFinal)}}</td>        
        <td>${{number_format($totalValorComision)}}</td>
    </tr>
</tfoot>
</table>

@endif




<br>
<br>
<br>
<br>
<br>

<table border="1">
    <thead>
    <tr>
        <th colspan="13">Productos</th>
    </tr>
    <tr>
        <th>Nombre Producto</th>
        <th>Cantidad</th>
        <th>Valor</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @php
    $total=0;
    $sumaTotal=0;
    $a=0

    @endphp
    @foreach($productos as $productos)
    @php
$total=$productos->sum_of_1*$productos->price_vent;
$sumaTotal+=$total;
@endphp
        <tr>
            <td>{{ $productos->name }}</td>
            <td>{{ number_format($productos->sum_of_1) }}</td>
            <td>${{ number_format($productos->price_vent) }}</td>
            <td>${{ number_format($total) }}</td>             
        </tr>

       
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>      
        <td>Total</td>        
        <td>${{number_format($sumaTotal)}}</td> 
    </tr>
</tfoot>
</table>


<br>
<br>
<br>
<br>
<br>
@php
if(isset($totalComisionSuero)){

    $valorGlobal=$sumaTotal+$totalValorComision+$totalValorComision2+$totalComision+$totalValorComision1+$totalComisionSuero;
}else{
    
    $valorGlobal=$sumaTotal+$totalValorComision+$totalValorComision2+$totalComision+$totalValorComision1;
}
@endphp
<h1>Valor total: {{number_format($valorGlobal)}}</h1>

