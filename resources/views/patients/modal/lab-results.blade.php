<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',18)
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
                Arcchivos
            </h6>
            @php
                $relation = json_decode($idBefore->array_files);
            @endphp
            @foreach($relation as $key => $rel)
                <a href="{{url($rel)}}" target="_blank">
                    Archivo{{$key+1}}
                </a>
            @endforeach
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
        <div class="form-group">
            <h6>
                Descripcion
            </h6>
            <textarea readonly class="form-control">{{$idBefore->description}}</textarea>
        </div>
    </div>
</div>