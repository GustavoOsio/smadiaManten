
@if($departamento==18)

    
    @foreach($data as $d)

    @php


if($cantidadCitas>=65 && $d->id == 14){
    $comision=$cantidadCitas*10000;
} elseif($cantidadCitas>=65 && $d->id == 42){
    $comision=$cantidadCitas*5000;
} else{
    $comision=300000;
}
    
    @endphp
                <div>{{ $d->name . " " . $d->lastname }}: {{ number_format($comision) }} </div>
                <div>Cantidad de Procedimientos: {{ number_format($cantidadCitas) }} </div>


                <table border="1">
    <thead>
    <tr>
        <th>Productos</th>
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
    @foreach($d->productos as $productos)
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
</table>
<br>



<br>
<br>
<br>
    @endforeach

    <table border="1">
    <thead>
    <tr>
        <th >Procedimiento Global</th>
    </tr>
    <tr>
        <th>Nombre </th>
        <th>Cantidad</th>
    </tr>
    </thead>
    <tbody>
    @php
    $total=0;
    $sumaTotal=0;
    $a=0;
$totalProdGlobal=sizeof($schedulesMad)+sizeof($schedulesMad3Zonas)+sizeof($schedulesOtrosMad)+sizeof($schedulesLipoVal)+sizeof($schedulesLipovalOtros)+sizeof($schedulesLipoVal4zonas)+sizeof($schedulesMamoPlas)+sizeof($schedulesResecc)+sizeof($schedulesBlefa)+sizeof($schedulesAbdomi);
    @endphp
        <tr>
            <td>Mad laser</td>
            <td>{{ sizeof($schedulesMad) }}</td>   
        </tr>
        <tr>
            <td>Mad Laser 3 Zonas</td>
            <td>{{ sizeof($schedulesMad3Zonas) }}</td>   
        </tr>
        <tr>
            <td>Otros Mad</td>
            <td>{{ sizeof($schedulesOtrosMad) }}</td>   
        </tr>
        <tr>
            <td>Lipoval Vaser</td>
            <td>{{ sizeof($schedulesLipoVal) }}</td>   
        </tr>
        <tr>
            <td>Lipoval Otros</td>
            <td>{{ sizeof($schedulesLipovalOtros) }}</td>   
        </tr>
        <tr>
            <td>Lipoval 4 Zonas</td>
            <td>{{ sizeof($schedulesLipoVal4zonas) }}</td>   
        </tr>
        <tr>
            <td>Mamoplastia</td>
            <td>{{ sizeof($schedulesMamoPlas) }}</td>   
        </tr>
        <tr>
            <td>Resección de Queloide</td>
            <td>{{ sizeof($schedulesResecc) }}</td>   
        </tr>
        <tr>
            <td>Blefaroplastia total ambos ojos</td>
            <td>{{ sizeof($schedulesBlefa) }}</td>   
        </tr>
        <tr>
            <td>Abdominoplastia</td>
            <td>{{ sizeof($schedulesAbdomi) }}</td>   
        </tr>
        


    </tbody>

    <tfoot>
    <tr>    
        <td>Total</td>        
        <td>${{number_format($totalProdGlobal)}}</td> 
    </tr>
</tfoot>


</table>
<br>
<br>
<br>
<br>
<br>


@elseif($departamento==24)

@foreach($data as $d)
 @php


 $porcentaje=($d->Ventas/$d->metaMensual)*100;

 if($porcentaje>=95 && $porcentaje < 100){
     $costo=1000;
 } elseif($porcentaje>=100 && $porcentaje < 110){
    $costo=1400;
 } elseif($porcentaje>=110 ){
    $costo=1800;
 } else{
    $costo=0;
 }

 $cantidadTotal=0;

 $pagoTotal=sizeof($d->Citas)*$costo;
 @endphp


 <div>{{ $d->name . " " . $d->lastname }} </div>
 <table border="1">
    <thead>
    <tr>
        <th >Procedimientos</th>
    </tr>
    <tr>
        <th>citas</th>
        <th>costo</th>
        <th>pagar</th>
    </tr>
    </thead>
    <tbody>
    @php
    $total=0;
    $sumaTotal=0;
    $a=0

    @endphp

    <tr>
        <td>{{ sizeof($d->Citas) }}</td>   
        <td>{{ number_format($costo)}}</td>
        <td>{{ number_format($pagoTotal)}}</td>
    </tr>

    </tbody>
</table>
<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    @foreach($d->productos as $productos)
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

        <br>

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
<table border="1">
    <thead>
    <tr>
        <th >Venta de paquete</th>
    </tr>

    </thead>
    <tbody>
    @php
    $ventas=$d->Ventas;
    
    $meta=16700000;

if($ventas>=$valorMetaGlobal){
    $bono1=($ventas*3)/100;
} else{
    $bono1=0;
}
    @endphp

    <tr>
        <th>{{number_format($bono1)}}</th> 
    </tr>

    </tbody>
</table>

@endforeach

@elseif($departamento==19)

@foreach($data as $d)
 @php


$cantidadTotal=$d->schedulesMad+$d->schedulesMad3Zonas+$d->schedulesOtrosMad+$d->schedulesLipoVal+$d->schedulesLipovalOtros+$d->schedulesLipoVal4zonas;



   $valorPago = $cantidadTotal*$d->porcentajeComision;


 @endphp


 <div>{{ $d->name . " " . $d->lastname }}: {{$cantidadTotal}} </div>
 <table border="1">
    <thead>
    <tr>
        <th >Procedimientos</th>
    </tr>
    <tr>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th></th>
        <th></th>
        <th>TOTAL A PAGAR </th>
        <th>{{number_format($valorPago)}}</th>
    </tr>
    </thead>
    <tbody>
    @php
    $total=0;
    $sumaTotal=0;
    $a=0

    @endphp

    <tr>
            <td>Mad laser</td>
            <td>{{ $d->schedulesMad }}</td>   
        </tr>
        <tr>
            <td>Mad Laser 3 Zonas</td>
            <td>{{ $d->schedulesMad3Zonas }}</td>   
        </tr>
        <tr>
            <td>Otros Mad</td>
            <td>{{ $d->schedulesOtrosMad }}</td>   
        </tr>
        <tr>
            <td>Lipoval Vaser</td>
            <td>{{ $d->schedulesLipoVal }}</td>   
        </tr>
        <tr>
            <td>Lipoval Otros</td>
            <td>{{ $d->schedulesLipovalOtros }}</td>   
        </tr>
        <tr>
            <td>Lipoval 4 Zonas</td>
            <td>{{ $d->schedulesLipoVal4zonas }}</td>   
        </tr>
        


    </tbody>

    </tbody>
</table>
<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    @foreach($d->productos as $productos)
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

        <br>

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
<table border="1">
    <thead>
    <tr>
        <th >DEPILCARE</th>
    </tr>

    </thead>
    <tbody>
    @php
    $total=($d->ingresosDepilcare*5)/100;


    @endphp

    <tr>
        <th>{{number_format($total)}}</th>
    </tr>

    </tbody>
</table>
<br>

<table border="1">
    <thead>
    <tr>
        <th>Meta MedBio</th>
        <th >Real</th>
        <th >Bono</th>
    </tr>
    </thead>
    <tbody>
    @php
    $total=$d->IncomeSuero;

$meta=13500000;
if($meta<=$total){
    $bono=300000;
} else{
    $bono=0;
}
    @endphp

    <tr>
        <th>{{number_format($meta)}}</th>
        <th>{{number_format($total)}}</th>
        <th>{{number_format($bono)}}</th>
    </tr>

    </tbody>
</table>
<br>
<table border="1">
    <thead>
    <tr>
        <th >Meta Otros</th>
        <th >Real</th>
        <th >Bono</th>
    </tr>

    </thead>
    <tbody>
    @php
    $total1=$d->ingresosOtros;
    $meta=16700000;

if($meta<=$total1){
    $bono1=300000;
} else{
    $bono1=0;
}
    @endphp

    <tr>
    <th>{{number_format($meta)}}</th>
        <th>{{number_format($total1)}}</th>
        <th>{{number_format($bono1)}}</th>
    </tr>

    </tbody>
</table>

@php

$totalComision=$bono1+$bono+$sumaTotal+$valorPago;

@endphp

<h1>Total comision: {{$totalComision}}</h1>
<br>
@endforeach




@elseif($departamento==17)

@foreach($data as $d)

@php

$porcentajeCumplido=($d->ventasTotal/$d->metaMensual)*100;
@endphp


<br>
<table border="1">
    <thead>
    <tr>
        <th colspan="10">{{ $d->name . " " . $d->lastname }}</th>
    </tr>
    <tr>
        <th >Ventas</th>
    </tr>
    <tr>
        <th>id</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Valor</th>
        <th>Comisión</th>
        <th>Descripción</th>
        <th>Centro de Costo</th>
    </tr>
    </thead>
    <tbody>
    @php

$sumaTotal=0;
$sumaComision=0;
$sumaTotal1=0;
$a=0;
@endphp
    @foreach($d->ventas as $ventas)
    @php
$comision=($ventas->amount*3)/100;
$sumaComision+=$comision;
$sumaTotal1+=$ventas->amount;
@endphp
        <tr>
            <td>I-{{ $ventas->id }}</td>  
            <td>{{ $ventas->patient->name . " " . $ventas->patient->lastname }}</td>  
            <td>{{ $ventas->patient->identy}}</td>     
            <td>{{ $ventas->amount}}</td>         
            <td>{{ $comision}}</td>     
            <td>{{ $ventas->comment}}</td>  
           @if($d->center_cost_id != '')
                    <td>{{ $ventas->center->name }}</td>
                @else
                    <td></td>
                @endif  
        </tr>


    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>      
        <td>Total</td>        
        <td>${{number_format($sumaTotal1)}}</td> 
        <td>${{number_format($sumaComision)}}</td> 
    </tr>
</tfoot>
</table>

<br>
@php

if($d->TotalCabinas>=$d->metaCabinas){
 $bono = 200000;
} else{
    $bono = 0;
}

@endphp
<table border="1">

        <tr>
            <td>Bono:</td>
            <td>{{ number_format($bono) }}</td>     
        </tr>




</table>

<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    @foreach($d->productos as $productos)
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
@php
$valorGlobal=$sumaTotal+$bono+$sumaComision;
@endphp
<h1>Valor total: {{number_format($valorGlobal)}}</h1>

@endforeach






@elseif($departamento==16)

@foreach($data as $d)

@php
    $cantidad=0;
    $valor=0;
    $totalApagar=0;
    @endphp

 <div>{{ $d->name . " " . $d->lastname }}: </div>
 <table border="1">
    <thead>
    <tr>
        <th>Cantidad Citas</th>
        <th >valor</th>
        <th >Total a pagar</th>
    </tr>
    </thead>
    <tbody>
    @php
    $cantidad=0;
 

    foreach($d->Citas as $citas){

        if($citas->date >= $fechaInico && $citas->date<= $fechafin ){
            $cantidad++;
        }

    }


    $valor=2000;


    if($cantidad>=56 && $cantidad < 58){
        $valor=4000;
    } elseif($cantidad>=58 && $cantidad < 67){
        $valor=5000;
    } elseif($cantidad>=67){
        $valor=7000;
    } 
    $totalApagar=$cantidad*$valor;
    @endphp

    <tr>
        <th>{{number_format($cantidad)}}</th>
        <th>{{number_format($valor)}}</th>
        <th>{{number_format($totalApagar)}}</th>
    </tr>

    </tbody>
</table>


<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    @foreach($d->productos as $productos)
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
<table border="1">
    <thead>
    <tr>
        <th >Ventas</th>
    </tr>
    <tr>
        <th>id</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Valor</th>
        <th>Descripción</th>        
        <th>Porcentaje</th>
        <th>Comision</th>
    </tr>
    </thead>
    <tbody>
    @foreach($d->Ventas as $ventas)
    @php
    
    $porcentaje = ($cantidad/$d->metaMensual)*100;

    
$sumaTotal+=$ventas->amount;

if($porcentaje>=90){
    $comision=($ventas->amount*5)/100;
} else{
    $comision=0;
}
@endphp
        <tr>
            <td>I-{{ $ventas->id }}</td>  
            <td>{{ $ventas->patient->name . " " . $ventas->patient->lastname }}</td>  
            <td>{{ $ventas->patient->identy}}</td>     
            <td>{{ $ventas->amount}}</td>       
            <td>{{ $ventas->comment}}</td>                   
            <td>{{ $porcentaje}}</td>       
            <td>{{ $comision}}</td> 
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
@endforeach








@elseif($departamento==25)

@foreach($data as $d)

@php
    $cantidad=0;
    $valor=0;
    $cumplimiento=0;
    @endphp

 <div>: </div>
 <table border="1">
    <thead>
    <tr>
        <th>{{ $d->name . " " . $d->lastname }}</th>
        <th >Total Ventas</th>
        <th >Total a pagar</th>
    </tr>
    </thead>
    <tbody>
    @php
    $cantidad=0;
 
$cumplimiento = ($d->ventasGlobal/$d->metaMensual)*100;

    $valor=2000;
    

if($cumplimiento>=90 && $cumplimiento < 95){
    $totalApagar=300000;
} 
elseif($cumplimiento>=95 && $cumplimiento < 100){
    $totalApagar=400000;
} 
elseif($cumplimiento>=100 && $cumplimiento < 110){
    $totalApagar=500000;
}elseif ($cumplimiento <= 110){
    $totalApagar=700000;
}
$totalApagar=700000;
    @endphp

    <tr>
        <th> {{ $cumplimiento }}</th>
        <th>{{number_format($d->ventasGlobal)}}</th>
        <th>{{number_format($totalApagar)}}</th>
    </tr>

    </tbody>
</table>


<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    @foreach($d->productos as $productos)
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
<table border="1">
    <thead>
    <tr>
        <th >Ventas</th>
    </tr>
    <tr>
        <th>id</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Valor</th>
        <th>Descripción</th>        
        <th>Porcentaje</th>
        <th>Comision</th>
    </tr>
    </thead>
    <tbody>
    @php
   
$sumaTotal1=0;
$sumaTotalComision=0;
@endphp
    @foreach($d->Ventas as $ventas)
    @php
    
     

    
$sumaTotal1+=$ventas->amount;

if($cumplimiento>=80){
    $comision=($ventas->amount*5)/100;
    $porcentaje=5;
} else{
    $comision=0;
    $porcentaje=0;
}

$sumaTotalComision+=$comision;
@endphp
        <tr>
            <td>I-{{ $ventas->id }}</td>  
            <td>{{ $ventas->patient->name . " " . $ventas->patient->lastname }}</td>  
            <td>{{ $ventas->patient->identy}}</td>     
            <td>{{ number_format($ventas->amount)}}</td>       
            <td>{{ $ventas->comment}}</td>                   
            <td>{{ number_format($porcentaje)}}</td>       
            <td>{{ number_format($comision)}}</td> 
        </tr>


    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>      
        <td>Total</td>        
        <td>${{number_format($sumaTotal1)}}</td>         
        <td></td>
        <td>Total comision</td>         
        <td>${{number_format($sumaTotalComision)}}</td> 

    </tr>
</tfoot>
</table>
<br>
@php
    
     

$valorGlobalTotal=$sumaTotalComision+$sumaTotal+$totalApagar;
    @endphp
<h1>Valor total a pagar es: {{number_format($valorGlobalTotal)}}</h1>
@endforeach










@elseif($departamento==23)

@foreach($data as $d)

@php
    $cantidad=0;
    $valor=0;
    $cumplimiento=0;
    @endphp


<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    $sumaTotalf=0;
    $a=0;

    @endphp
    @foreach($d->productos as $productos)
    @php
$total=$productos->sum_of_1*$productos->price_vent;
$sumaTotalf +=$total;
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
        <td>${{number_format($sumaTotalf)}}</td> 
    </tr>
</tfoot>
</table>
<br>
<br>
<table border="1">
    <thead>
    <tr>
        <th >Productos</th>
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
    @foreach($d->productosGlobal as $productosGlobal)
    @php
$total=($productosGlobal->cantidad*$productosGlobal->price)-$productosGlobal->discount_cop;
$sumaTotal+=$total;

@endphp
        <tr>
            <td>{{ $productosGlobal->name }}</td>
            <td>{{ number_format($productosGlobal->cantidad) }}</td>
            <td>${{ number_format($productosGlobal->price_vent) }}</td>
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

@php

if($sumaTotal>=20000000 && $sumaTotal < 25000000){
$comision = 150000;
} elseif($sumaTotal>=25000000 && $sumaTotal < 3000000){
    $comision = 200000;
} elseif($sumaTotal>=30000000 && $sumaTotal < 3500000){
    $comision = 300000;
} elseif($sumaTotal>=35000000){
    $comision = 400000;
} else{
    $comision = 0;
}
$comisionFarmacia=$comision+$sumaTotalf;
@endphp
<h1>Valor total a pagar es: {{number_format($comisionFarmacia)}}</h1>
<br>
<br>




@endforeach


@endif



