<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',1)
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
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Motivo de la consulta:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->reason_consultation}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Enfermedad actual:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->current_illness}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes patológicos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_patologico}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes quirurgicos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_surgical}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes alergicos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_allergic}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes traumáticos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_traumatic}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes medicamentos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_medicines}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes ginecológicos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_gynecological}}">
        </div>
    </div>
    <!--
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes F.U.M:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_fum}}">
        </div>
    </div>
    -->
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes hábitos:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_habits}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes nutricionales:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_nutritional}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="form-group">
            <h6>
                Antecedentes familiares:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->ant_familiar}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <h6>
                Observaciones pacientes:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->observations}}">
        </div>
    </div>
</div>