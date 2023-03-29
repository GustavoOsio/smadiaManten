<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',20)
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
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Parenteral 1:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->parental_1}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Parenteral 2:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->parental_2}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Parenteral 3:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->parental_3}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Parenteral 4:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->parental_4}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Parenteral 5:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->parental_5}}">
        </div>
    </div>
</div>
@foreach($relation as $rel)
    <div class="line-form"></div>
    <div class="row justify-content-md-center">
        <div class="col-lg-2 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Hora:</strong>
                <input readonly type="text" class="form-control" required value="{{$rel->hour}}">
            </div>
        </div>
        <div class="col-lg-2 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Tipo:</strong>
                <input readonly type="text" class="form-control" value="{{$rel->type}}">
            </div>
        </div>
        <div class="col-lg-3 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Elemento:</strong>
                <input readonly type="text" class="form-control" value="{{$rel->type_element}}">
            </div>
        </div>
        <div class="col-lg-2 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Cantidad CC::</strong>
                <input readonly type="text" class="form-control" required value="{{$rel->box}}">
            </div>
        </div>
    </div>
@endforeach
<div class="line-form"></div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Total Administrados:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->total_adm}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Total eliminados:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->total_del}}">
        </div>
    </div>
</div>