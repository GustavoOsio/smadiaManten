<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',6)
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
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Tratamiento:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->service_line}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Observaciones:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->observations}}">
            </div>
        </div>
    </div>
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