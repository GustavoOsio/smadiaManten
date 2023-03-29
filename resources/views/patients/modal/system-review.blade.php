<div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
        @php
            $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                ->where('id_type',2)
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
@foreach($systems as $sy)
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="form-group">
                        <h5 style="text-align: center">{{$sy->name}}</h5>
                    </div>
                </div>
                @foreach($relation as $r)
                    @if($r->systems_id == $sy->id)
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <strong>{{$r->pathology}}:</strong>
                                <input type="text" class="form-control" readonly value="{{$r->select}}">
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="col-lg-12">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>observacion:</strong>
                        @php
                            switch ($sy->id) {
                                case 1:
                                    $observation = $idBefore->system_head_face_neck;
                                    break;
                                case 2:
                                    $observation = $idBefore->system_respiratory_cardio;
                                    break;
                                case 3:
                                    $observation = $idBefore->system_digestive;
                                    break;
                                case 4:
                                    $observation = $idBefore->system_genito_urinary;
                                    break;
                                case 5:
                                    $observation = $idBefore->system_locomotor;
                                    break;
                                case 6:
                                    $observation = $idBefore->system_nervous;
                                    break;
                                case 7:
                                    $observation = $idBefore->system_integumentary;
                                    break;
                            }
                        @endphp
                        <textarea class="form-control" rows="2" readonly>{{$observation}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                </div>
            </div>
        </div>
    </div>
    <div class="line-form"></div>
@endforeach