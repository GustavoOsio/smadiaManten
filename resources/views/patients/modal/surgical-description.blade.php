<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',16)
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
                Servicio:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->diagnosis}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Diagnostico Preoperatorio:
            </h6>
            <textarea readonly class="form-control">{{$idBefore->preoperative_diagnosis}}</textarea>
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Diagnostico Posoperatorio:
            </h6>
            <textarea readonly class="form-control">{{$idBefore->postoperative_diagnosis}}</textarea>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Cirujano:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->surgeon}}">
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
                Ayudante:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->assistant}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Instrumentador quirurjico:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->surgical_instrument}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Fecha:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->date}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Hora de inicio:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->start_time}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Hora de fin:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->end_time}}">
        </div>
    </div>
    <!--
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Código Cups:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->code_cups}}">
        </div>
    </div>
    -->
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Intervencion:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->intervention}}">
        </div>
    </div>
    <!--
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Control Compresas:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->control_compresas}}">
        </div>
    </div>
    -->
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Tipo Anestesia :
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->type_anesthesia}}">
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Descripción del procedimiento:
            </h6>
            @php
                $replace = str_replace("<br>","\r",$idBefore->description_findings);
            @endphp
            <textarea readonly class="form-control">{{$replace}}</textarea>
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Observaciones:
            </h6>
            <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
        </div>
    </div>
</div>