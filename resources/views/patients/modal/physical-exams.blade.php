<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',3)
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
<div class="row justify-content-md-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Peso:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->weight}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Altura:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->height}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                IMC:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->imc}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Cabeza y cuello:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->head_neck}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Cardiopulmonar:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->cardiopulmonary}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Abdomen:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->abdomen}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Extremidades:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->extremities}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Sistema nervioso:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->nervous_system}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Piel y fanera:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->skin_fanera}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Otros:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->others}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Observaciones:
            </h6>
            <textarea readonly type="text" class="form-control" required>{{$idBefore->observations}}</textarea>
        </div>
    </div>
</div>