@extends('pdf.layout')
@section('title', 'Historia Clinica')
@section('content')
@php
function wrapText($text, $maxwidth){
$gtcount = 0;
$wholewidth = 0;

$fontarr = [];
$fontsizearr = [];
$fontcolorarr = [];
$boldarr = [];
$chararr = [];

$formatedText = "";

$text = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

$dom = new DOMPDF();
$pdf = Canvas_Factory::get_instance($dom);

for($i = 0; $i < count($text); $i++){ if($text[$i]==='<' ){ $gtcount++; $close=textArrPos($text, '>' , $i) + 1; $interest=textArrsubstr($text, $i, $close - $i); if($text[$i + 1]==='/' ){ array_pop($fontarr); array_pop($fontcolorarr); array_pop($fontsizearr); array_pop($boldarr); }else{ if(count($fontcolorarr)-1>= 0){
    $fontcolor = $fontcolorarr[count($fontcolorarr)-1];
    }else{
    $fontcolor = null;
    }

    if(count($fontarr)-1 >= 0){
    $font = $fontarr[count($font)-1];
    }else{
    $font = null;
    }

    if(count($fontsizearr)-1 >= 0){
    $fontsize = $fontsizearr[count($fontsizearr)-1];
    }else{
    $fontsize = null;
    }

    if(count($boldarr)-1 >= 0){
    $bold = $boldarr[count($boldarr)-1];
    }else{
    $bold = null;
    }

    if($interest === "<strong>"){
        $bold = true;
        }else if($interest === "<br>"){
        $chararr[] = [];
        $curca = count($chararr) - 1;
        $chararr[$curca]['char'] = "<br>";
        $chararr[$curca]['font'] = $fontarr[count($fontarr) - 1];
        $chararr[$curca]['size'] = 0;
        $chararr[$curca]['color'] = $fontcolorarr[count($fontcolorarr) - 1];
        $chararr[$curca]['weight'] = $bold;
        }else{
        $interest = substr($interest, strpos($interest, 'style="') + 7);
        $interest = substr($interest, 0, -2);

        $css = explode(';',$interest);
        for($j = 0 ; $j < count($css) ; $j++){ $css[$j]=trim($css[$j]); $css[$j]=explode(':', $css[$j]); if($css[$j][0]==='color' ){ $fontcolor=$css[$j][1]; }else if($css[$j][0]==='font-family' ){ $font=$css[$j][1]; }else if($css[$j][0]==='font-size' ){ $fontsize=floatval($css[$j][1]); } } } $fontarr[]=trim($font, " '" ); $fontcolorarr[]=trim($fontcolor, " '" ); $fontsizearr[]=trim($fontsize, " '" ); $boldarr[]=trim($bold, " '" ); } }else if($text[$i]==='>' ){ $gtcount--; }else{ if($gtcount===0){ if($text[$i]==='&' ){ $close=textArrPos($text, ';' , $i) + 1; $chartext=textArrsubstr($text, $i, $close - $i); $char=html_entity_decode($chartext); $i +=strlen($chartext) - 1; }else{ $char=$text[$i]; } if(!$boldarr[count($boldarr) - 1]){ $bold='normal' ; }else{ $bold='bold' ; } $chararr[]=[]; $curca=count($chararr) - 1; $chararr[$curca]['char']=$char; $chararr[$curca]['font']=$fontarr[count($fontarr) - 1]; $chararr[$curca]['size']=$fontsizearr[count($fontsizearr) - 1]; $chararr[$curca]['color']=$fontcolorarr[count($fontcolorarr) - 1]; $chararr[$curca]['weight']=$bold; } } } for($i=0; $i < count($chararr); $i++){ if($chararr[$i]['char']==="<br>" ){ $wholewidth=0; $formatedText .='<br>' . "\n" ; continue; } $wholewidth +=$pdf->get_text_width($chararr[$i]['char'], Font_Metrics::get_font($chararr[$i]['font'], $chararr[$i]['weight']), $chararr[$i]['size']);;
            if($chararr[$i]['char'] === ' '){
            $nextspace = charArrPos($chararr, ' ', $i+1);

            if($nextspace === FALSE){
            $nextspace = count($chararr) - 1;
            }

            $curwidth = $wholewidth;

            for($k = $i + 1; $k < $nextspace; $k++){ if($chararr[$k]['char'] !=="<br>" ){ $width=$pdf->get_text_width($chararr[$k]['char'], Font_Metrics::get_font($chararr[$k]['font'], $chararr[$k]['weight']), $chararr[$k]['size']);
                $curwidth += $width;
                }
                }

                if($curwidth >= $maxwidth){
                $wholewidth = 0;
                $formatedText .= '<br>' . "\n";
                continue;
                }
                }


                $formatedText .= '<span style="font-family: ' . $chararr[$i]['font'] . '; font-size: ' . $chararr[$i]['size'] . '; color: ' . $chararr[$i]['color'] . '; font-weight: ' . $chararr[$i]['weight'] . '">' . $chararr[$i]['char'] . "</span>" . "\n";
                }

                return $formatedText;
                }
                @endphp
                <style>
                    table td,
                    table tr,
                    table th,
                    table {
                        padding: 0% !important;
                        margin: 0% !important;
                        font-family: Arial;
                        font-size: 14px;
                    }

                    .font {
                        font-family: Arial;
                    }

                    p {
                        margin: 0.1% 0% !important;
                    }

                    .line-form {
                        margin: 1% 0%;
                        padding: 1% 0%;
                        margin-bottom: 10px;
                        background: 1px solid #c1c1c2;
                    }

                    .logo .img {

                        width: 250px;
                        height: 40px;
                        background-size: contain;

                        margin-top: 25px;
                    }

                    .fz13 {
                        font-size: 13pt;
                    }

                    .fz11 {
                        font-size: 13pt;
                    }

                    .fz10 {
                        font-size: 13pt;
                    }

                    .fz9 {
                        font-size: 13pt;
                    }

                    .page-break {
                        page-break-after: always;
                    }

                    .acomodation {
                        padding-left: 60px;
                    }
                </style>
                <header>
                    <img src="https://smadiasoft.com/img/logo-smadia-02.png" style="margin-top: 25px !important;" />
                    <h3 class="fz13">Historia Clinica</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <p class="fz9">Generado el: {{ date("d-m-Y") }}</p>
                                </th>
                                <th>
                                    <p class="fz9">Numero de historia: {{ $data->identy }}</p>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </header>

                <table style="border: 1px solid black;">
                    <td>
                        <p class="fz11"><strong>Nombre: </strong><label for="" class="acomodation">{{ ucwords(mb_strtolower($data->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->lastname, "UTF-8")) }}</label></p>
                        <p class="fz11"><strong>N° de Identificación: </strong><label for="" style="padding-left: 100px;">{{ $data->identy }}</label></p>
                        <p class="fz11"><strong>Fecha de nacimiento: </strong> <label for="" style="padding-left: 90px;">{{ $data->birthday }}</label></p>
                        @php
                        $stateName = '';
                        $cityName = '';
                        if(!empty($data->state->name))
                        {
                        $stateName = $data->state->name;
                        }
                        if(!empty($data->city->name))
                        {
                        $cityName = $data->city->name;
                        }
                        @endphp
                        <p class="fz11"><strong>Departamento: </strong><label for="" style="padding-left: 80px;">{{ $stateName }}</label></p>
                        <p class="fz11"><strong>Ciudad: </strong><label for="" style="padding-left: 30px;">{{ $cityName }}</label></p>
                        <p class="fz11"><strong>Telefono: </strong><label for="" style="padding-left: 80px;">{{ $data->phone }}</label></p>
                    </td>
                    <td>
                        <p class="fz11"><strong>Genero: </strong><label for="" style="padding-left: 60px;">{{ $data->gender->name }} </label></p>
                        <!-- <p class="fz11"><strong>Servicio: </strong><label for="" style="padding-left: 60px;">
                                @if(!empty($data->service->name))
                                {{ $data->service->name }}
                                @endif
                            </label>
                        </p> -->
                        <p class="fz11"><strong>EPS: </strong><label for="" style="padding-left: 60px;">
                                @if(!empty($data->eps->name))
                                {{ $data->eps->name }}
                                @endif
                            </label>
                        </p>
                        <p class="fz11"><strong>Estado Civil: </strong> <label for="" style="padding-left: 60px;">
                                @if(!empty($data->civil->name))
                                {{ $data->civil->name }}
                                @endif
                            </label>
                        </p>
                        <p class="fz11"><strong>Email: </strong><label for="" style="padding-left: 40px;">{{ $data->email }}</label></p>
                        <p class="fz11"><strong>Celular: </strong><label for="" style="padding-left: 40px;">{{ $data->cellphone }}</label></p>
                    </td>
                </table>

                <hr>
                @if(!empty($historia['anamnesis']))
                <div style="text-align: center;background-color: #c1c1c2;"> <strong> ANAMNESIS </strong></div>
                @foreach($historia['anamnesis'] as $anamnesis)
                <p style="font-size: 12px;"><strong>Elaborado por: {{$anamnesis['user_id']}}</strong> </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$anamnesis['created_at']}}</strong> </p>

                <table>
                    <tr>
                        <td>
                            <p><strong>Motivo de la consulta: </strong><label for="" style="padding-left: 110px;font-size: 12px">{{$anamnesis['reason_consultation']}}</label></p>
                            <p><strong>Enfermedad actual: </strong><label for="" style="padding-left: 70px;font-size: 12px">{{$anamnesis['current_illness']}}</label></p>
                            <p><strong>Antecedentes patológicos: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_patologico']}}</label></p>
                            <p><strong>Antecedentes quirurgicos: </strong><label for="" style="padding-left: 110px;font-size: 12px">{{$anamnesis['ant_surgical']}}</label></p>
                            <p><strong>Antecedentes traumáticos: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_traumatic']}}</label></p>
                            <p><strong>Antecedentes medicamentos: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_medicines']}}</label></p>
                            <p><strong>Antecedentes ginecológicos: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_gynecological']}}</label></p>
                            <p><strong>Antecedentes hábitos: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_habits']}}</label></p>
                            <p><strong>Antecedentes nutricionales: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_nutritional']}}</label></p>
                            <p><strong>Antecedentes familiares: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$anamnesis['ant_familiar']}}</label></p>
                        </td>
                    </tr>
                    <tr>
                        <div>
                            <strong> Observaciones pacientes:</strong> <label for="" style="padding-left: 110px;font-size: 12px">{{$anamnesis['observations']}}</label><br>

                        </div>
                    </tr>
                </table>
                <br>
                @endforeach
                @endif

                @if(!empty($historia['examFisico']))
                <div style="text-align: center;background-color: #c1c1c2;"> <strong> EXAMEN FISICO</strong></div>
                @foreach($historia['examFisico'] as $examFisico)

                <p style="font-size: 12px;"><strong>Elaborado por: {{$examFisico['user_id']}} </strong></p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$examFisico['created_at']}}</strong> </p>
                <table>
                    <tr>
                        <td>
                            <p><strong>Peso: </strong><label for="" style="padding-left: 30px;font-size: 12px">{{$examFisico['weight']}}</label></p>
                            <p><strong>Altura: </strong><label for="" style="padding-left: 30px;font-size: 12px">{{$examFisico['height']}}</label></p>
                            <p><strong>Imc: </strong><label for="" style="padding-left: 40px;font-size: 12px">{{$examFisico['imc']}}</label></p>
                            <p><strong>Cabeza y cuello: </strong><label for="" style="padding-left: 80px;font-size: 12px">{{$examFisico['head_neck']}}</label></p>
                            <p><strong>Cardio pulmonar: </strong><label for="" style="padding-left: 90px;font-size: 12px">{{$examFisico['cardiopulmonary']}}</label></p>
                            <p><strong>Abdomen: </strong><label style="padding-left: 40px;font-size: 12px">{{$examFisico['abdomen']}}</label></p>
                            <p><strong>Extremidades: </strong><label for="" style="padding-left: 50px;font-size: 12px">{{$examFisico['extremities']}}</label></p>
                            <p><strong>Sistema nervioso: </strong><label for="" style="padding-left: 90px;font-size: 12px">{{$examFisico['nervous_system']}}</label></p>
                            <p><strong>Piel y fanera: </strong><label for="" style="padding-left: 50px;font-size: 12px">{{$examFisico['skin_fanera']}}</label></p>
                            <p><strong>Otros: </strong><label for="" style="padding-left: 50px;font-size: 12px">{{$examFisico['others']}}</label></p>
                        </td>
                    </tr>
                    <tr>
                        <div>
                            <strong> Observaciones pacientes:</strong> <label for="" style="padding-left: 110px;font-size: 12px">{{$examFisico['observations']}}</label><br>

                        </div>
                    </tr>
                </table>
                <br>
                @endforeach
                @endif

                @if(!empty($historia['tmedidas']))
                <div style="text-align: center;background-color: #c1c1c2;"><strong>TABLA DE MEDIDAS</strong></div>
                @foreach($historia['tmedidas'] as $tmedidas)
                <p style="font-size: 12px;"> <strong>Elaborado por: {{$tmedidas['user_id']}}</strong> </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$tmedidas['created_at']}}</strong> </p>
                <table>
                    <tr>
                        <td>
                            <p><strong>Imc: </strong><label for="" style="padding-left: 30px;font-size: 12px">{{$tmedidas['imc']}}</label></p>
                            <p><strong>Peso: </strong><label for="" style="padding-left: 30px;font-size: 12px">{{$tmedidas['weight']}}</label></p>
                            <p><strong>Busto: </strong><label for="" style="padding-left: 40px;font-size: 12px">{{$tmedidas['bust']}}</label></p>
                            <p><strong>Contorno: </strong><label for="" style="padding-left: 60px;font-size: 12px">{{$tmedidas['contour']}}</label></p>
                            <p><strong>Cintura: </strong><label for="" style="padding-left: 50px;font-size: 12px">{{$tmedidas['waistline']}}</label></p>
                            <p><strong>Umbilical: </strong><label style="padding-left: 60px;font-size: 12px">{{$tmedidas['umbilical']}}</label></p>
                            <p><strong>Abd inferior: </strong><label for="" style="padding-left: 50px;font-size: 12px">{{$tmedidas['abd_lower']}}</label></p>
                        </td>
                        <td>
                            <p><strong>Abd superior: </strong><label for="" style="padding-left: 60px;font-size: 12px">{{$tmedidas['abd_higher']}}</label></p>
                            <p><strong>Cadera: </strong><label for="" style="padding-left: 20px;font-size: 12px">{{$tmedidas['hip']}}</label></p>
                            <p><strong>Piernas: </strong><label for="" style="padding-left: 50px;font-size: 12px">{{$tmedidas['legs']}}</label></p>
                            <p><strong>Muslo derecho: </strong><label for="" style="padding-left: 70px;font-size: 12px">{{$tmedidas['right_thigh']}}</label></p>
                            <p><strong>Muslo izquierdo: </strong><label for="" style="padding-left: 100px;font-size: 12px">{{$tmedidas['left_thigh']}}</label></p>
                            <p><strong>Brazo derecho: </strong><label for="" style="padding-left: 60px;font-size: 12px">{{$tmedidas['right_arm']}}</label></p>
                            <p><strong>Brazo izquierdo: </strong><label for="" style="padding-left: 80px;font-size: 12px">{{$tmedidas['left_arm']}}</label></p>

                        </td>
                    </tr>
                    <tr>
                        <div>
                            <strong> Observaciones pacientes:</strong> <label for="" style="padding-left: 110px;font-size: 12px">{{$tmedidas['observations']}}</label><br>

                        </div>
                    </tr>
                </table>
                <br>

                @endforeach
                @endif

                @if(!empty($historia['diagnostico']))
                <div style="text-align: center;background-color: #c1c1c2;"><strong>DIAGNOSTICO CLINICO</strong></div>
                @foreach($historia['diagnostico'] as $diagnostico)
                <p style="font-size: 12px;"> <strong> Elaborado por: {{$diagnostico['user_id']}}</strong> </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$diagnostico['created_at']}}</strong> </p>
                <table>
                    <tr>
                        <td>
                            <p><strong>Diagnostico : </strong><label for="" style="padding-left: 60px;font-size: 12px">{{$diagnostico['diagnosis']}}</label></p>
                        </td>
                        <td>
                            <p><strong>Observaciones: </strong><label for="" style="padding-left: 60px;font-size: 12px">{{$diagnostico['observations1']}}</label></p>
                        </td>
                    </tr>
                    <tr>
                        <div>
                            <strong> Observaciones general:</strong> <label for="" style="padding-left: 100px;font-size: 12px">{{$diagnostico['observations2']}}</label><br>
                        </div>
                    </tr>
                </table>
                <br>
                @endforeach
                @endif
                @if(!empty($historia['evolucionMedica']))
                <div style="text-align: center;background-color: #c1c1c2;"><strong>EVOLUCION MEDICA</strong></div>
                @foreach($historia['evolucionMedica'] as $evolucionMedica)
                <p style="font-size: 12px;"> <strong> Elaborado por: {{$evolucionMedica['user_id']}} </strong></p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$evolucionMedica['created_at']}}</strong> </p>

                <table>
                    <tr>
                        <td>
                            <label for="">Observacion:</label>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="padding-right: 10px;font-size: 12px">{{$evolucionMedica['observations']}}
                            <p>
                                <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <strong> Observaciones general:</strong> <br><label for="" style="padding-right: 10px;font-size: 12px">{{$evolucionMedica['observations']}}</label><br>
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                @endforeach
                @endif
                @if(!empty($historia['ayudaDiagnostica']))
                <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>AYUDA DIAGNOSTICA</strong></div>
                @foreach($historia['ayudaDiagnostica'] as $ayudaDiagnostica)
                <p style="font-size: 12px;">Elaborado por: {{$ayudaDiagnostica['user_id']}} </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$ayudaDiagnostica['created_at']}}</strong> </p>
                <table>
                    <thead>
                        <tr>
                            <th>Ayuda diagnostica</th>
                            <th>Examen</th>
                            <th>Otro examen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ayudaDiagnostica['datos'] as $datos)
                        <tr>
                            <td style="font-size: 12px;">{{$datos['exam']}}</td>
                            <td style="font-size: 12px;">{{$datos['diagnosis']}}</td>
                            <td style="font-size: 12px;">{{$datos['other_exam']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                @endforeach
                @endif

                @if(!empty($historia['evolucionCosmetologia']))
                <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>EVOLUCION COSMETOLOGICA</strong><br></div>
                @foreach($historia['evolucionCosmetologia'] as $evolucionCosmetologia)
                <p style="font-size: 12px;">Elaborado por: {{$evolucionCosmetologia['user_id']}} </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$evolucionCosmetologia['created_at']}}</strong> </p>
                <table>
                    <thead>
                        <tr>
                            <th>Evolución:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p style="padding-right: 50px;font-size: 12px">{{$evolucionCosmetologia['evolution']}}
                                <p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                @endforeach
                @endif
                @if(!empty($historia['evolucionEnfermera']))
                <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>EVOLUCION ENFERMERIA</strong><br></div>
                @foreach($historia['evolucionEnfermera'] as $evolucionEnfermera)
                <p style="font-size: 12px;"> <strong>Elaborado por: {{$evolucionEnfermera['user_id']}}</strong> </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$evolucionEnfermera['created_at']}}</strong> </p>

                <table>
                    <thead>
                        <tr>
                            <th>Evolución:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 10%;">
                                <p style="padding-right: 50px;font-size: 12px">{{$evolucionEnfermera['evolution']}}
                                <p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>

                @endforeach
                @endif

                @if(!empty($historia['hojaGastos']))
                <div style="page-break-after: always;">
                    <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>HOJA DE GASTOS</strong><br></div>
                    @foreach($historia['hojaGastos'] as $hojaGastos)
                    <hr>
                    <p style="font-size: 12px;"> <strong> Elaborado por: {{$hojaGastos['user_id']}} </strong></p>
                    <p style="font-size: 12px;"> <strong> Fecha creacion: {{$hojaGastos['created_at']}}</strong> </p>

                    <table>
                        <thead>
                            <tr>
                                <th>Producto:</th>
                                <th>cantidad:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hojaGastos['relacion'] as $datos)

                            <tr>
                                <td>
                                    <p>{{$datos['product']}}
                                    <p>
                                </td>
                                <td>
                                    <p>{{$datos['cant']}}
                                    <p>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <div> <strong> Observacion:</strong> <br> {{$hojaGastos['observations']}}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <hr>
                    @endforeach
                </div>
                @endif




                @if(!empty($historia['hojaGastosCirugia']))
                <div style="page-break-after: always;">
                    <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>HOJA DE GASTOS DE CIRUGIA</strong></div>
                    @foreach($historia['hojaGastosCirugia'] as $hojaGastosCirugia)
                    <p style="font-size: 12px;"> <strong> Elaborado por: {{$hojaGastosCirugia['user_id']}}</strong> </p>
                    <p style="font-size: 12px;"> <strong> Fecha creacion: {{$hojaGastosCirugia['created_at']}}</strong> </p>
                    <br>
                    <!-- primera parte -->
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Fecha de cirugia</th>
                                <th>Sala</th>
                                <th>Peso</th>
                                <th>Tipo de Paciente</th>
                                <th>Tipo de Anestesia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$hojaGastosCirugia['date_of_surgery']}}</td>
                                <td>{{$hojaGastosCirugia['room']}}</td>
                                <td>{{$hojaGastosCirugia['weight']}}</td>
                                <td>{{$hojaGastosCirugia['type_patient']}}</td>
                                <td>{{$hojaGastosCirugia['type_anesthesia']}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- segunda parte -->
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 40px;">Tipo de Cirugia</th>
                                <th style="width: 40px;">Hora Ingreso</th>
                                <th style="width: 40px;">Hora Inicio</th>
                                <th style="width: 70px;">Cirugia</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$hojaGastosCirugia['type_surgery']}}</td>
                                <td>{{$hojaGastosCirugia['time_entry']}}</td>
                                <td>{{$hojaGastosCirugia['start_time_surgery']}}</td>
                                <td>{{$hojaGastosCirugia['surgery']}}</td>

                            </tr>
                        </tbody>
                    </table>

                    <!-- parte 3 -->
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Hora Terminacion </th>

                                <th>Ayudante</th>
                                <th>Anestesiologo</th>
                                <th>Rotadora</th>
                                <th>Instrumentadora</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$hojaGastosCirugia['end_time_surgery']}}</td>
                                <td>{{$hojaGastosCirugia['assistant']}}</td>
                                <td>{{$hojaGastosCirugia['anesthesiologist']}}</td>
                                <td>{{$hojaGastosCirugia['rotary']}}</td>
                                <td>{{$hojaGastosCirugia['instrument']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div> <strong>Cirujano: {{$hojaGastosCirugia['surgeon']}}</strong> </div>
                    <hr>
                    @endforeach
                </div>
                @endif

                @if(!empty($historia['notasdeEnfermeria']))

                <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>NOTAS DE ENFERMERIA</strong></div>
                @foreach($historia['notasdeEnfermeria'] as $notasdeEnfermeria)
                <p style="font-size: 12px;"> <strong> Elaborado por: {{$notasdeEnfermeria['user_id']}}</strong> </p>
                <p style="font-size: 12px;"> <strong> Fecha creacion: {{$notasdeEnfermeria['created_at']}}</strong> </p>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$notasdeEnfermeria['date']}}</td>
                            <td>{{$notasdeEnfermeria['hour']}}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th>Nota: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            
                                <p style="padding-right: 10px;font-size: 12px"> {{$notasdeEnfermeria['note']}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @endforeach
                @endif


                @if(!empty($historia['descQuirurgica']))
                <div style="page-break-before: always;">
                    <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>DESCRIPCION QUIRURGICA</strong></div>
                    @foreach($historia['descQuirurgica'] as $descQuirurgica)
                    <p style="font-size: 12px;"> <strong> Elaborado por: {{$descQuirurgica['user_id']}}</strong> </p>
                    <p style="font-size: 12px;"> <strong> Fecha creacion: {{$descQuirurgica['created_at']}}</strong> </p>
                    <br>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 190px;">Servicio</th>
                                <th>Diagnostico Preoperatorio</th>
                                <th>Diagnostico Preoperatorio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$descQuirurgica['diagnosis']}}</td>
                                <td>{{$descQuirurgica['preoperative_diagnosis']}}</td>
                                <td>{{$descQuirurgica['postoperative_diagnosis']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- parte 2 -->
                    <table>
                        <thead>
                            <tr>
                                <th>Cirujano</th>
                                <th>Anestesiologo</th>
                                <th>Ayudante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$descQuirurgica['surgeon']}}</td>
                                <td>{{$descQuirurgica['anesthesiologist']}}</td>
                                <td>{{$descQuirurgica['assistant']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- parte 3 -->
                    <table>
                        <thead>
                            <tr>
                                <th>Instrumentador</th>
                                <th>Fecha</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$descQuirurgica['surgical_instrument']}}</td>
                                <td>{{$descQuirurgica['date']}}</td>
                                <td>{{$descQuirurgica['start_time']}}</td>
                                <td>{{$descQuirurgica['end_time']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- parte 4 -->
                    <table>
                        <thead>
                            <tr>
                                <th>Intervencion</th>
                                <th>Tipo Anestesia</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$descQuirurgica['intervention']}}</td>
                                <td>{{$descQuirurgica['type_anesthesia']}}</td>
                                <td>{{$descQuirurgica['observations']}}</td>s
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div> <strong>Descripción del procedimiento: </strong></div>
                    <p style="padding-right: 10px;font-size: 12px">{{$descQuirurgica['description_findings']}}</p>
                    <hr>
                    @endforeach
                </div>
                @endif

                @if(!empty($historia['controlMedicamento']))
                <div style="page-break-before: always;">
                    <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>CONTROL DE MEDICAMENTOS</strong></div>
                    @foreach($historia['controlMedicamento'] as $controlMedicamento)
                    <p style="font-size: 12px;"> <strong> Elaborado por: {{$controlMedicamento['user_id']}}</strong> </p>
                    <p style="font-size: 12px;"> <strong> Fecha creacion: {{$controlMedicamento['created_at']}}</strong> </p>

                    <table>
                        <thead>
                            <tr>
                                <th>Servicio:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$controlMedicamento['service']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @foreach($controlMedicamento['relacion_control_medicamentos'] as $datos)

                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Medicamento</th>
                                <th style="width: 20%;">Hora</th>
                                <th>Fecha</th>
                                <th>Iniciales de enfermera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$datos['medicine']}}</td>
                                <td>{{$datos['hour']}}</td>
                                <td>{{$datos['date']}}</td>
                                <td>{{$datos['initial']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                    @endforeach
                </div>
                @endif

                @if(!empty($historia['contolLiquidos']))
                <div style="page-break-before: always;">
                    <div class="panel-heading" style="text-align: center;background-color: #c1c1c2;"><strong>CONTROL DE LIQUIDOS</strong></div>
                    @foreach($historia['contolLiquidos'] as $contolLiquidos)
                    <p style="font-size: 12px;"> <strong> Elaborado por: {{$contolLiquidos['user_id']}}</strong> </p>
                    <p style="font-size: 12px;"> <strong> Fecha creacion: {{$contolLiquidos['created_at']}}</strong> </p>

                    <table ">
                        <thead>
                            <tr>
                                <th>Parenteral 1:</th>
                                <th>Parenteral 2:</th>
                                <th>Parenteral 3:</th>
                                <th>Parenteral 4:</th>
                                <th>Parenteral 5:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$contolLiquidos['parental_1']}}</td>
                                <td>{{$contolLiquidos['parental_2']}}</td>
                                <td>{{$contolLiquidos['parental_3']}}</td>
                                <td>{{$contolLiquidos['parental_4']}}</td>
                                <td>{{$contolLiquidos['parental_5']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @foreach($contolLiquidos['relacion_control_liquidos'] as $datos)
<br>
                    <table style=" width: 100%;">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th style="width: 20%;">Tipo</th>
                                <th>Elemento</th>
                                <th>Cantidad cc</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$datos['hour']}}</td>
                                <td>{{$datos['type']}}</td>
                                <td>{{$datos['type_element']}}</td>
                                <td>{{$datos['box']}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Total administrado</th>
                                <th>Total eliminado</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$contolLiquidos['total_adm']}}</td>
                                <td>{{$contolLiquidos['total_del']}}</td>

                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                </div>
                @endif



                <script type="text/php">
                    if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 780, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
	</script>
                @endsection