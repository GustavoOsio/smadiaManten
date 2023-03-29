<div class="style_div">
    @if(count($purchase)>0)
        <h1>
            Compras
        </h1>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>Compra</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Bodega</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchase as $p)
                <tr>
                    <td>C-{{ $p->purchase_id }}</td>
                    <td>{{$p->product->name}}</td>
                    <td>{{$p->qty_inventory}}</td>
                    <td>{{$p->cellar->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @if(count($personalInventory)>0)
        <h1>
            Inventario Personal
        </h1>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Usuario</th>
            </tr>
            </thead>
            <tbody>
            @foreach($personalInventory as $p)
                @php
                    $user = \App\User::find($p->user_id);
                @endphp
                <tr>
                    <td>{{$p->product->name}}</td>
                    <td>{{$p->qty}}</td>
                    <td>{{$user->name}} {{$user->lastname}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @if(count($transferObs)>0)
        <h1>
            Inventario Quirofano
        </h1>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transferObs as $p)
                @php
                    $product = \App\Models\Product::find($p->product_id);
                @endphp
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{number_format($p->totaly,0)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
<style>
    .style_div{
        width: 100%;
        padding: 0% 5%;
    }
    .style_div h1{
        font-size: 16px;
        color: #000000;
    }
</style>
