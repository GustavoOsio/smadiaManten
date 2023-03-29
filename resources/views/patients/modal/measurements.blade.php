<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',4)
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
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                IMC:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->imc}}">
        </div>
    </div>
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
                Busto:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->bust}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Contorno:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->contour}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Cintura:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->waistline}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Umbilical:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->umbilical}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                ABD Inferior:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->abd_lower}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                ABD Superior:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->abd_higher}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Cadera:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->hip}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Piernas:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->legs}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Muslo derecho:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->right_thigh}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Muslo izquierdo:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->right_arm}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Brazo derecho:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->right_arm}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <h6>
                Brazo izquierdo:
            </h6>
            <input readonly type="text" class="form-control" required value="{{$idBefore->left_arm}}">
        </div>
    </div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
        <div class="form-group">
            <h6>
                Observaciones:
            </h6>
            <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
        </div>
    </div>
</div>