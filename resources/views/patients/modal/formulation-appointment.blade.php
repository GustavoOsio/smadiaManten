
<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',12)
                ->first();
        @endphp
        <div class="form-group">
            <h6>
                Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                Fecha: {{$create->date}}
            </h6>
        </div>
    </div>
    <div class="col-lg-3">
    </div>
    <div class="col-lg-3">
        <div class="button-new">
            <a target="_blank" class="btn btn-primary" style="background: #ffffff !important;color: red" href="{{ url("formulation-appointment/pdf/".$idBefore->id) }}">
                <svg style="width: 17pt" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.5 482.5" style="enable-background:new 0 0 482.5 482.5;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M399.25,98.9h-12.4V71.3c0-39.3-32-71.3-71.3-71.3h-149.7c-39.3,0-71.3,32-71.3,71.3v27.6h-11.3    c-39.3,0-71.3,32-71.3,71.3v115c0,39.3,32,71.3,71.3,71.3h11.2v90.4c0,19.6,16,35.6,35.6,35.6h221.1c19.6,0,35.6-16,35.6-35.6    v-90.4h12.5c39.3,0,71.3-32,71.3-71.3v-115C470.55,130.9,438.55,98.9,399.25,98.9z M121.45,71.3c0-24.4,19.9-44.3,44.3-44.3h149.6    c24.4,0,44.3,19.9,44.3,44.3v27.6h-238.2V71.3z M359.75,447.1c0,4.7-3.9,8.6-8.6,8.6h-221.1c-4.7,0-8.6-3.9-8.6-8.6V298h238.3    V447.1z M443.55,285.3c0,24.4-19.9,44.3-44.3,44.3h-12.4V298h17.8c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-330    c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h19.9v31.6h-11.3c-24.4,0-44.3-19.9-44.3-44.3v-115c0-24.4,19.9-44.3,44.3-44.3h316    c24.4,0,44.3,19.9,44.3,44.3V285.3z"/>
                            <path d="M154.15,364.4h171.9c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-171.9c-7.5,0-13.5,6-13.5,13.5S146.75,364.4,154.15,364.4    z"/>
                            <path d="M327.15,392.6h-172c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h171.9c7.5,0,13.5-6,13.5-13.5S334.55,392.6,327.15,392.6z"/>
                            <path d="M398.95,151.9h-27.4c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h27.4c7.5,0,13.5-6,13.5-13.5S406.45,151.9,398.95,151.9z"/>
                        </g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    </svg>
                Imprimir
            </a>
        </div>
    </div>
</div>
@foreach($relation as $rel)
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
            <div class="form-group">
                <h6>
                    Descripción (nombre del producto o medicamento):
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->formula}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <h6>
                    Otro
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->other}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
            <div class="form-group">
                <h6>
                    Cantidad:
                </h6>
                <input readonly type="text" class="form-control" required value="{{$rel->another_formula}}">
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
            <div class="form-group">
                <h6>
                    Indicaciones
                </h6>
                <textarea readonly class="form-control" rows="4">{{$rel->indications}}</textarea>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
            <div class="form-group">
                <h6>
                    Observaciones
                </h6>
                <textarea readonly class="form-control" rows="4">{{$rel->formulation}}</textarea>
            </div>
        </div>
    </div>
    <div class="line-form"></div>
@endforeach