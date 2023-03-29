<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',13)
                ->first();
        @endphp
        <div class="form-group">
            <h6>
                Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                Fecha: {{$create->date}}
            </h6>
        </div>
    </div>
</div>
@foreach($relation as $rel)
    <div class="row justify-content-md-center">
        <div class="col-lg-2 margin-tb">
            <div class="form-group">
                <strong>Codigo:</strong>
                <input value="{{$rel->code}}" type="text" class="form-control" readonly>
            </div>
        </div>
        <div class="col-lg-3 margin-tb">
            <div class="form-group">
                <strong>Producto:</strong>
                <input value="{{$rel->product}}" type="text" class="form-control" readonly>
            </div>
        </div>
        <div class="col-lg-1 margin-tb">
            <div class="form-group">
                <strong>Cant:</strong>
                <input value="{{$rel->cant}}" type="number" class="form-control" readonly>
            </div>
        </div>
    </div>
    <!--
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
            <div class="form-group">
                <h6>
                    Codigo
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->code}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Producto
                </h6>
                <input readonly type="text" class="form-control" required value="">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="form-group">
                <h6>
                    Lote:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->lote}}">
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Presentación:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->presentation}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Unidad de Medida:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->medid}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
            <div class="form-group">
                <h6>
                    Cant:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->cant}}">
            </div>
        </div>
    </div>
    -->
    <div class="line-form"></div>
@endforeach
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
        <div class="form-group">
            <h6>
                Observaciones:
            </h6>
            <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
        </div>
    </div>
</div>
