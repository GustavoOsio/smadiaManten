
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',7)
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
    <div class="col-lg-12">
        <div class="form-group">
            <h4 style="text-align: center">
                Ciclo {{$idBefore->cicle}} -  Sesion {{$idBefore->sesion}}
            </h4>
        </div>
    </div>
</div>
@php
    $relation = json_decode($idBefore->array_biological_medicine);
    $observations = json_decode($idBefore->array_observations);
@endphp
@foreach($relation as $key => $rel)
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
            <div class="form-group">
                <h6>
                    Medicina Biologíca:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel}}">
            </div>
        </div>
        <div class="col-lg-12">
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
            <div class="form-group">
                <h6>
                    Observaciones:
                </h6>
                <textarea class="form-control">{{$observations[$key]}}</textarea>
            </div>
        </div>
    </div>
    <div class="line-form"></div>
@endforeach
