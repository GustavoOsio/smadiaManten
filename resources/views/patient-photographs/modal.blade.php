<div class="modal fade" id="modalPhotos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-align: center;width: 100%;" id="exampleModalCenterTitle">
                    Fotografias Anteriores
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators" style="bottom: -11px;">
                        @foreach($photos as $key => $fot)
                            @php
                                $vector = json_decode($fot->array_photos)
                            @endphp
                            @for($i=0;$i< count($vector);$i++)
                                <li style="background-color: #D3C18E;border-radius: 100%;width: 15px;height: 15px;" data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="{{($key==0) ? "active":""}}"></li>
                            @endfor
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($photos as $key => $fot)
                            @php
                                $vector = json_decode($fot->array_photos)
                            @endphp
                            @for($i=0;$i< count($vector);$i++)
                                <div class="carousel-item {{($key==0) ? "active":""}}">
                                    @if(
                                        strpos($vector[$i], 'jpeg') == true ||
                                        strpos($vector[$i], 'jpg') == true ||
                                        strpos($vector[$i], 'png') == true
                                    )
                                        <img class="d-block w-100" src="{{asset($vector[$i])}}" alt="">
                                    @else
                                        <img class="d-block w-100" src="{{asset('img/file.jpg')}}" alt="">
                                    @endif
                                    <div style="background:#80746B;text-align: center;padding: 2% 0%">
                                        <h5 style="color: #D3C18E">{{$fot->comments}}</h5>
                                        @php
                                            $create = App\Models\MedicalHistory::where('id_relation',$fot->id)
                                                ->where('id_type',17)
                                                ->first();
                                        @endphp
                                        <a class="btn" href="{{url($vector[$i])}}" target="_blank">
                                            <button type="button" class="btn btn-primary w-100">VER FOTO</button>
                                        </a>
                                        <h6>
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                        </h6>
                                    </div>
                                </div>
                            @endfor
                        @endforeach
                    </div>
                    <a style="color: #D3C18E;opacity: 1;" class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span style="color: #D3C18E;
    background-image: none;
    font-size: 39pt;
    opacity: 1 !important;
    font-weight: 900;
    width: initial;
    height: initial;" class="carousel-control-prev-icon" aria-hidden="true">
            <
        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a style="color: #D3C18E;opacity: 1;" class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span style="color: #D3C18E;
    background-image: none;
    font-size: 39pt;
    opacity: 1 !important;
    font-weight: 900;
    width: initial;
    height: initial;" class="carousel-control-next-icon" aria-hidden="true">
            >
        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #modalPhotos img{
        width: 70% !important;
        margin-left: auto !important;
        margin-right: auto !important;
        display: block !important;
        vertical-align: middle !important;
    }
    #modalPhotos .btn button,#modalPhotos .btn{
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
    }
</style>
