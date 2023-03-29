<table border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Referencia</th>
            <th>Precio</th>
            <th>IVA %</th>
            <th>Tipo</th>
            <th>Formulación</th>
            <th>Farmacia</th>
            <th>Inventario Personal</th>
            <th>Quirofano</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Fecha Invima</th>
            <th>Fecha creación</th>
        </tr>
    </thead>
    <tbody>
        @php
            $type = \App\Models\Type::where('type','inventory')
            ->where('status','activo')
            ->get();
            $pCount = 0;
            $pCount_2 = 0;
            $qty = 0;
            $qty_inventary = 0;
        @endphp
        @foreach ($data as $product)
            @php
                $qty = 0;
                $qty_inventary = 0;
                $pCount = 0;
                $purchase = \App\Models\PurchaseProduct::where('product_id',$product->id)
                ->where('inventory','si')
                ->get();
                $personalInventory = \App\Models\PersonalInventory::where('product_id',$product->id)
                    ->get();
                foreach($personalInventory as $p_2){
                    $pCount = $pCount + $p_2->qty;
                }
                $transferObs = \App\Models\TransferWineryObservations::where('product_id',$product->id)
                    ->get();
                foreach($transferObs as $p_3){
                    $pCount_2 = $pCount_2 + $p_3->qty;
                }
                foreach($purchase as $p){
                    $qty_inventary = $qty_inventary + intval($p->qty_inventory);
                    $qty = $qty_inventary + intval($pCount) + intval($pCount_2);
                }
            @endphp
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->reference }}</td>
                <td>{{ number_format($product->price, 0) }}</td>
                <td>{{ $product->tax }}</td>
                <td>{{ $product->inventory->name }}</td>
                <td>{{ $product->form }}</td>
                <td>
                    {{$qty_inventary}}
                </td>
                <td>
                    {{$pCount}}
                </td>
                <td>
                    {{$pCount_2}}
                </td>
                <td>
                    {{$qty}}
                </td>
                <td>{{ ucfirst($product->status) }}</td>
                @if($product->date_invima != '')
                    <td>{{ date("Y-m-d", strtotime($product->date_invima)) }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ date("Y-m-d", strtotime($product->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
