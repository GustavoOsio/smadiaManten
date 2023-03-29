<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Identificación</th>
        <th>Valor</th>
        <th>Descripción</th>
        <th>Centro de Costo</th>
        <th>Forma de Pago</th>
        <th>Banco origen</th>
        <th>Cuenta Bancaria</th>
        <th>Numero Aprobación</th>
        <th>Contrato</th>
        <th>Vendedor</th>
        <th>Responsable</th>
        <th>Seguimiento</th>
        <th>Estado</th>
        <th>Fecha</th> 
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        @php
            $method_pay = ucfirst($d->method_of_pay);
            if($d->method_of_pay_2 != ''){
                $method_pay = $method_pay .'/'.ucfirst($d->method_of_pay_2);
            }
        @endphp
        @if($d->method_of_pay_2 != '')
            <tr>
                <td>I-{{ $d->id }}</td>
                <td>{{ $d->patient->name . " " . $d->patient->lastname }}</td>
                <td>{{ $d->patient->identy }}</td>
                <td>{{ number_format($d->amount_one, 0,',','')  }}</td>
                <td>{{ $d->comment }}</td>
                @if($d->center_cost_id != '')
                    <td>{{ $d->center->name }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ ucfirst($d->method_of_pay) }}</td>
                
                <td>{{ ucfirst($d->origin_bank) }}</td>
                <td>
                    
                {{ $d->origin_account }}
  
                </td>
                @if($d->method_of_pay == 'consignacion')
                <td>{{ $d->approved_Banco }}</td>
                @elseif($d->method_of_pay == 'tarjeta')
                    <td>{{ $d->approved_of_card }}</td>
                @else
                    <td>{{ $d->approved_epayco }}</td>
                @endif
                <td>{{ ($d->contract) ? "C-" . $d->contract->id : "" }}</td>
                <td>{{ $d->seller->name . " " . $d->seller->lastname }}</td>
                <td>{{ $d->responsable->name . " " . $d->responsable->lastname }}</td>
                @if($d->follow_id != 0)
                    <td>{{ $d->follow->name . " " . $d->follow->lastname }}</td>
                @else
                    <td>No aplica</td>
                @endif
                <td>{{ $d->status }}</td>
                <td>{{ date("Y-m-d h:i a", strtotime($d->created_at)) }}</td>
            </tr>
            <tr>
                <td>I-{{ $d->id }}</td>
                <td>{{ $d->patient->name . " " . $d->patient->lastname }}</td>
                <td>{{ $d->patient->identy }}</td>
                <td>{{ number_format($d->amount_two, 0,',','')  }}</td>
                <td>{{ $d->comment }}</td>
                @if($d->center_cost_id != '')
                    <td>{{ $d->center->name }}</td>
                @else
                    <td></td>
                @endif
                
                <td>{{ ucfirst($d->method_of_pay_2) }}</td>
                <td>
                    @if($d->account_2_id != '')
                        {{ $d->account2->account }}
                    @endif
                </td> 
                
                
                <td>{{ ucfirst($d->origin_bank_2) }}</td>

                @if($d->method_of_pay_2 == 'consignacion')
                <td>{{ $d->approved_Banco }}</td>
                @elseif($d->method_of_pay_2 == 'tarjeta')
                    <td>{{ $d->approved_of_card_2 }}</td>
                @else
                    <td>{{ $d->approved_epayco_2 }}</td>
                @endif
                <td>{{ ($d->contract) ? "C-" . $d->contract->id : "" }}</td>
                <td>{{ $d->seller->name . " " . $d->seller->lastname }}</td>
                <td>{{ $d->responsable->name . " " . $d->responsable->lastname }}</td>
                @if($d->follow_id != 0)
                    <td>{{ $d->follow->name . " " . $d->follow->lastname }}</td>
                @else
                    <td>No aplica</td>
                @endif
                <td>{{ $d->status }}</td>
                <td>{{ date("Y-m-d h:i a", strtotime($d->created_at)) }}</td>
            </tr>
        @else
            <tr>
                <td>I-{{ $d->id }}</td>
                <td>{{ $d->patient->name . " " . $d->patient->lastname }}</td>
                <td>{{ $d->patient->identy }}</td>
                <td>{{ number_format($d->amount, 0,',','')  }}</td>
                <td>{{ $d->comment }}</td>
                @if($d->center_cost_id != '')
                    <td>{{ $d->center->name }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ ucfirst($method_pay) }}</td>
                
                @if($d->method_of_pay == 'consignacion' || $d->method_of_pay == 'online')
                <td>{{ ucfirst($d->origin_bank) }}</td>
                @elseif($d->method_of_pay == 'tarjeta')
                    <td>{{ $d->card_entity }}</td>
                @else
                    <td></td>
                @endif
                <td>
                        {{ $d->origin_account }}
                   
                </td>
                @if($d->method_of_pay == 'consignacion')
                <td>{{ $d->approved_Banco }}</td>
                @elseif($d->method_of_pay == 'tarjeta')
                    <td>{{ $d->approved_of_card }}</td>
                @else
                    <td>{{ $d->approved_epayco }}</td>
                @endif
                <td>{{ ($d->contract) ? "C-" . $d->contract->id : "" }}</td>
                <td>{{ $d->seller->name . " " . $d->seller->lastname }}</td>
                <td>{{ $d->responsable->name . " " . $d->responsable->lastname }}</td>
                @if($d->follow_id != 0)
                    <td>{{ $d->follow->name . " " . $d->follow->lastname }}</td>
                @else
                    <td>No aplica</td>
                @endif
                <td>{{ $d->status }}</td>
                <td>{{ date("Y-m-d h:i a", strtotime($d->created_at)) }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
