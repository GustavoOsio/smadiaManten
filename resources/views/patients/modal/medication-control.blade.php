<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',19)
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
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
        <div class="form-group">
            <h6>
                Servicio:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->service}}">
        </div>
    </div>
</div>
@foreach($relation as $rel)
    <div class="line-form"></div>
    <div class="row justify-content-md-center">
        <div class="col-lg-3 col-md-4 margin-tb">
            <div class="form-group">
                <strong>Medicamento:</strong>
                <input readonly type="text" class="form-control" required value="{{$rel->medicine}}">
            </div>
        </div>
        <div class="col-lg-2 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Hora:</strong>
                <input readonly type="text" class="form-control" required value="{{$rel->hour}}">
            </div>
        </div>
        <div class="col-lg-2 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Fecha:</strong>
                <input readonly type="text" class="form-control" value="{{$rel->date}}">
            </div>
        </div>
        <div class="col-lg-3 col-md-5 margin-tb">
            <div class="form-group">
                <strong>Iniciales de enfermera:</strong>
                <input readonly type="text" class="form-control" value="{{$rel->initial}}">
            </div>
        </div>
    </div>
@endforeach