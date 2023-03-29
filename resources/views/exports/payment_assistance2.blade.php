<table border="1">



    <thead style="background: grey, color:white, font-weight:bold ">
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Asistencial</th>
            <th>Tratamiento realizado</th>
            <th>Sesion</th>
            <th>Fecha de acción</th>
            <th>Contrato</th>
            <th>Valor tratamiento</th>
            <th>Obsequio</th>
            <th>Otro</th>
            <th>Suma descuento</th>
            <th>Tratamiento con descuento</th>
            <th>Vendedor</th>
            <th>Establecio estado</th>
            <th>Saldo a favor</th>
            <!--valores de descuento-->
            <th>Medio de pago</th>
            <th>% Descuento tarjeta</th>
            <th>Descuento medio pago</th>
            <th>% Deducible</th>
            <th>Descuento deducible</th>
            <th>Valor base comisionable</th>
            <!--Fin-->
            <!--<th>PAGAR</th>-->
        </tr>
    </thead>
    <tbody>
        @php
            $value_tra = 0;
            $desc = 0;
            $comision = 0;
            $total = 0;
        @endphp
        @foreach ($payment as $pay)
            @php
             /*   $schedule = \App\Models\Schedule::find($pay->schedule_id);
                $item = \App\Models\Item::where(['contract_id' => $schedule->contract_id, 'service_id' => $schedule->service_id])->first();
                $service = \App\Models\Service::find($schedule->service_id);
                if ($service->type == 'sesion') {
                    $desc_total = $item->discount_value / $item->qty;
                    $desc_total = $item->price - $desc_total;
                    $price_item = $item->price;
                } else {
                    $desc_total = $item->total;
                    $price_item = $item->price * $item->qty;
                }*/
            @endphp
            @php
               /* $comision = $pay->comision;
                $pago = $pay->total;
                if ($schedule->service_id == 2 || $schedule->service_id == 9 || $schedule->service_id == 70) {
                    $comision = $service->price_pay;
                    $pago = $service->price_pay;
                }*/
            @endphp
            @php
             /*   $value_tra = $value_tra + intval(str_replace(',', '', number_format($pay->price, 0)));
                $desc = $desc + intval(str_replace(',', '', number_format($desc_total, 0)));
                $comision = $comision + intval(str_replace(',', '', number_format($comision, 0)));
                $total = $total + intval(str_replace(',', '', number_format($pago, 0)));*/


            @endphp

            <!--Codigo mantenimiento Osio funciones-->
            @php

                $obsequio = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional
                WHERE  concepto='Obsequio' AND id_presupuesto=? ",[$pay->idContrato]);

             //   $id=explode('-',$pay->contract)[1];
                $otro = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional
                 WHERE  concepto='Otro' AND id_presupuesto=? ",[$pay->idContrato]);

                $deducible = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional
                 WHERE  concepto='Deducible' AND id_presupuesto=? ",[$pay->idContrato]);

                $deducibleValor = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional
                 WHERE  concepto='Deducible_valor' AND id_presupuesto=? ",[$pay->idContrato]);

                $sumaDescuento=$obsequio[0]->suma + $otro[0]->suma;
                if( $sumaDescuento>0 and $pay->Descuento>0){
                    $sumaTotal=$pay->Descuento+$sumaDescuento;
                }else{
                    $sumaTotal=$pay->Descuento;
                }

                $deducibleTotal=$pay->pago_0*$deducible[0]->suma/100;
                if($deducible[0]->suma>0){
                    $deduciblePorcentaje=$deducible[0]->suma;
                }else{
                    $deduciblePorcentaje=0;
                }



            @endphp

            <tr>
                <td>{{ $pay->id }}</td>
                <td>{{ $pay->paciente }}</td>
                <td>{{ $pay->cedula }}</td>
                <td>{{ $pay->asistencial }}</td>
                <td>{{ $pay->tratamiento_realizado }}</td>
                <td>{{ $pay->sesiones }}</td>
                <td>{{ $pay->fecha_accion }}</td>
                <td>{{ $pay->contrato }}</td>
                <td>{{ number_format($pay->Valor_contrato, 0, ',', '') }}</td>
                <td>
                    {{ number_format($obsequio[0]->suma, 0, ',', '') }}
                </td>
                <td>
                    {{ number_format($otro[0]->suma, 0, ',', '') }}
                </td>

                <td>
                    {{ number_format($sumaTotal, 0, ',', '') }}
                </td>
                <td>
                    {{ number_format($pay->tratamiento_con_descuento-$sumaDescuento, 0, ',', '') }}
                </td>

                <td>{{ $pay->vendedor }}</td>
                <td>{{ $pay->establecio_estado }}</td>
                <td>{{ number_format($pay->pago_0, 0, ',', '') }}</td>
                <td>{{ $pay->medio_pago }}</td>
                 <!--Nuevo codigo-->
                <td>{{ $pay->p_descuento}}</td>
                 <td>{{ number_format($pay->pagoTyO, 0, ',', '') }}</td>
                <td>
                    @if ( $deducibleValor[0]->suma>0)
                    {{$deducibleValor[0]->suma}}
                    @else
                    {{$deduciblePorcentaje}}
                    @endif
                </td>
                <td>
                    @if ( $deducibleValor[0]->suma>0)
                    {{$deducibleValor[0]->suma}}
                    @else
                    {{$deducibleTotal}}
                    @endif
                </td>
                <td>
                @if ( $deducibleValor[0]->suma>0)
                {{$pay->vr_final-$deducibleValor[0]->suma}}
                @else
                {{$pay->vr_final-$deducibleTotal}}
                @endif

                </td>
                <!--Codigo comision-->

                <!--
            <td>
                @php
                 /*   $income = \App\Models\Income::where('contract_id', str_replace('C-', '', $pay->contract))
                        ->where('status', 'activo')
                        ->get();
                    if ($pay->total <= $income->sum('amount')) {
                        $pay2 = 'SI';
                    } else {
                        $pay2 = 'NO';
                    }*/
                @endphp

            </td>
            -->
            </tr>
        @endforeach
    </tbody>
    <!--
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>

        </tr>
    </tfoot>
    -->
</table>
