<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',15)
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
                Fecha de Nota:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->date}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Hora de Nota:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->hour}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-8">
        <div class="form-group">
            <h6>
                Nota
            </h6>
            <textarea readonly class="form-control" rows="12">{{$idBefore->note}}</textarea>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-8">
        <div class="form-group">
            <h6>
                Observaciones
            </h6>
            <textarea readonly class="form-control" rows="12">{{$idBefore->observations}}</textarea>
        </div>
    </div>
</div>
