<table class="table table-striped table-soft">
    <thead>
    <tr>
        <th>Orden de pedido</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Pedido por</th>
        <th>Area</th>
        <th>Entregar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order_p as $p)
        @php
            $purchase = \App\Models\OrderPurchase::find($p->purchase_order_id);
            $product = \App\Models\Product::find($p->product_id);
            $user = \App\User::find($purchase->receive_id);
        @endphp
        <tr>
            <td>OP-{{ $purchase->id_order }}</td>
            <td>{{$product->name}}</td>
            <td>{{$p->qty - $p->missing}}</td>
            <td>{{ ucwords(mb_strtolower($user->name . " " . $user->lastname)) }}</td>
            <td>{{$purchase->area}}</td>
            <td>
                <button
                    style="padding: 4px 8px !important;"
                    type="button"
                    class="btn btn-secondary clickHistoryAdd"
                    id_order_product="{{$p->id}}"
                    id_product="{{$product->id}}"
                    id_name="{{$product->name}}"
                    id_user="{{$purchase->receive_id}}"
                    product_qty="{{$p->qty - $p->missing}}"
                >
                    Dar a I.P
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $('.clickHistoryAdd').click(function () {
        $('#modalAdd input[name=id_order_product]').val( $(this).attr('id_order_product') );
        $('#modalAdd input[name=product_id]').val( $(this).attr('id_product') );
        $('#modalAdd input[name=product_name]').val( $(this).attr('id_name') );
        $('#modalAdd select[name=user_id]').val( $(this).attr('id_user') );
        $('#modalAdd input[name=product_qty]').val( $(this).attr('product_qty') );
        $('#modalAdd .product_qty').html( $(this).attr('product_qty') );

        $('#modal_historial_order_purchase').modal('hide');
        $('#modalAdd').modal('show');
        $("#lote_id").val('');
        $("#lote_id").select2({
            ajax: {
                dataType: "json",
                url: "/purchase-orders/lotes/get",
                data: {id:  $(this).attr('id_name')  },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    });
</script>
