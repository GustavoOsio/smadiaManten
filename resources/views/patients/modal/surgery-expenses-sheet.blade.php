<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',14)
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
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Fecha de Cirugia:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->date_of_surgery}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-1">
        <div class="form-group">
            <h6>
                Sala:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->room}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-1">
        <div class="form-group">
            <h6>
                Peso:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->weight}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Tipo de Paciente:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->type_patient}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Tipo de Anestesia:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->type_anesthesia}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Tipo de Cirugia :
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->type_surgery}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Cirugia::
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->surgery}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Código de Cirugia:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->surgery_code}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Hora de Ingreso:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->time_entry}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Hora de Inicio de Cirugia :
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->start_time_surgery}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Hora de Final de Cirugia:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->end_time_surgery}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Cirujano:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->surgeon}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Ayudante:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->assistant}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Anestesiologo:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->anesthesiologist}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Rotadora:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->rotary}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Instrumentadora:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->instrument}}">
        </div>
    </div>
</div>
@foreach($relation as $rel)
    <div class="line-form"></div>
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
@endforeach
