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
            <th>Tratamiento con Descuento</th>

            <th>Valor comision</th>
            <th>Vendedor</th>
            <th>Estableció estado</th>
            <th>Total de pago</th>
            <th>Saldo a Favor</th>
            <!--valores de descuento-->
            <th>Valor tratamiento</th>
            <th>Valor tratamiento con descuento</th>
            <th>Obsequio</th>
            <th>Otro</th>
            <th>Valor total del contrato</th>
            <th>Saldo a favor</th>
            <th>Saldo por pagar</th>
            <th>Medio de pago</th>
            <th>% Descuento medio pago</th>
            <th>Total descuento medio pago</th>
            <th>Deducible</th>
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
                $schedule = \App\Models\Schedule::find($pay->schedule_id);
                $item = \App\Models\Item::where(['contract_id' => $schedule->contract_id, 'service_id' => $schedule->service_id])->first();
                $service = \App\Models\Service::find($schedule->service_id);
                if ($service->type == 'sesion') {
                    $desc_total = $item->discount_value / $item->qty;
                    $desc_total = $item->price - $desc_total;
                    $price_item = $item->price;
                } else {
                    $desc_total = $item->total;
                    $price_item = $item->price * $item->qty;
                }
            @endphp
            @php
                $comision = $pay->comision;
                $pago = $pay->total;
                if ($schedule->service_id == 2 || $schedule->service_id == 9 || $schedule->service_id == 70) {
                    $comision = $service->price_pay;
                    $pago = $service->price_pay;
                }
            @endphp
            @php
                $value_tra = $value_tra + intval(str_replace(',', '', number_format($pay->price, 0)));
                $desc = $desc + intval(str_replace(',', '', number_format($desc_total, 0)));
                $comision = $comision + intval(str_replace(',', '', number_format($comision, 0)));
                $total = $total + intval(str_replace(',', '', number_format($pago, 0)));


            @endphp

            <!--Codigo mantenimiento Osio funciones-->
            @php
            $id=explode('-',$pay->contract)[1];
                $obsequio = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional ad
                INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
                WHERE  concepto='obsequio' AND ad.id_presupuesto=? ",[$id]);

             //   $id=explode('-',$pay->contract)[1];
                $otro = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional ad
                INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
                WHERE  concepto='otro' AND ad.id_presupuesto=? ",[$id]);

                $deducible = DB::select(
                    "SELECT SUM(valor) as suma
                 FROM adicional ad
                INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
                WHERE  concepto='Deducible' AND ad.id_presupuesto=? ",[$id]);

                $sumaDescuento=$obsequio[0]->suma+$otro[0]->suma;

            @endphp

            <tr>
                <td>{{ $pay->id }}</td>
                <td>{{ $pay->patienistst }}</td>
                <td>{{ $pay->identi }}</td>
                <td>{{ $pay->asyst }}</td>
                <td>{{ $pay->serv }}</td>
                <td>{{ $pay->sesion }}</td>
                <td>{{ $pay->date }}</td>
                <td>{{ $pay->contract }}</td>
                <td>{{ number_format($price_item, 0, ',', '') }}</td>
                <td>
                    {{ number_format($desc_total, 0, ',', '') }}
                </td>

                <td>
                    {{ number_format($comision, 0, ',', '') }}
                </td>
                <td>{{ $pay->seller }}</td>
                <td>{{ $pay->stable_status }}</td>
                <td>{{ number_format($pago, 0, ',', '') }}</td>
                <td>{{ number_format($pay->balance_favor, 0, ',', '') }}</td>

                <!--Nuevo codigo-->
                <td>{{ number_format($price_item, 0, ',', '') }}</td>
                <td>{{ number_format($desc_total, 0, ',', '') }}</td>
                <td>{{ $obsequio[0]->suma }}</td>
                <td>{{$otro[0]->suma}}</td>
                <td>{{$price_item-$sumaDescuento}}</td>
                <td>{{ $desc_total }}</td> <!--saldo a favor-->
                <td>Saldo por pagar</td>
                <td>Medio de pago</td>
                <td>% Descuento medio pago</td>
                <td>Total descuento medio pago</td>
                <td>{{$deducible[0]->suma}}</td>
                <td>Valor base comisionable</td>
                <!--Codigo comision-->

                <!--
            <td>
                @php
                    $income = \App\Models\Income::where('contract_id', str_replace('C-', '', $pay->contract))
                        ->where('status', 'activo')
                        ->get();
                    if ($pay->total <= $income->sum('amount')) {
                        $pay2 = 'SI';
                    } else {
                        $pay2 = 'NO';
                    }
                @endphp
                {{ $pay2 }}
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
            <th>$ {{ number_format($value_tra, 0) }}</th>
            <th>$ {{ number_format($desc, 0) }}</th>
            <th>$ {{ number_format($comision, 0) }}</th>
            <th></th>
            <th></th>
            <th>$ {{ number_format($total, 0) }}</th>
        </tr>
    </tfoot>
    -->
</table>
