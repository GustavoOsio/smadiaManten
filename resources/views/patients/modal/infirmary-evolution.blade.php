<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',11)
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
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
        <div class="form-group">
            <h6>
                Evolución
            </h6>
            <textarea readonly class="form-control">{{$idBefore->evolution}}</textarea>
        </div>
    </div>
    @if($idBefore->array_evolutions != '')
        @php
            $relation = json_decode($idBefore->array_evolutions);
        @endphp
        @foreach($relation as $key => $rel)
            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                <div class="form-group">
                    <h6>
                        Evolución {{$key+1}}
                    </h6>
                    <textarea readonly class="form-control">{{$rel}}</textarea>
                </div>
            </div>
        @endforeach
    @endif
</div>