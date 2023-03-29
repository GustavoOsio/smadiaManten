
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',5)
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
                    Diagnostico
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->diagnosis}}">
            </div>
        </div>
        <!--
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Tipo
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->type}}">
            </div>
        </div>
        -->
    </div>
    <!--
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="form-group">
                <h6>
                    Causa Externa:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->external_cause}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="form-group">
                <h6>
                    Plan de Tratamiento:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->treatment_plan}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
            <div class="form-group">
                <h6>
                    otro:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->other}}">
            </div>
        </div>
    </div>
    -->
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
            <div class="form-group">
                <h6>
                    Observaciones:
                </h6>
                <textarea readonly class="form-control">{{$rel->observations}}</textarea>
            </div>
        </div>
    </div>
    <div class="line-form"></div>
@endforeach
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
        <div class="form-group">
            <h6>
                Observacion General:
            </h6>
            <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
        </div>
    </div>
</div>