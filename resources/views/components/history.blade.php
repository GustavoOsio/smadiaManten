<div class="content-his mt-3">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                @php
                    $typeMedicalHistory = \App\Models\TypeMedicalHistory::all();
                    session(['menu_patient_show' => 6]);
                @endphp
                <select id="historyClinic" class="form-control">
                    @php
                        $href=$href;
                        $porciones = explode("/", $_SERVER['REQUEST_URI']);
                        $href2= $porciones[1];
                    @endphp
                    @foreach($typeMedicalHistory as $key => $tmh)
                        <option value="{{$tmh->href}}/{{$patient_id}}" @if($href2 === "$tmh->href") selected @endif>{{$tmh->name}}</option>
                    @endforeach
                </select>
            </div>
            @php
                $patient = \App\Models\Patient::find($patient_id);
                $id = \App\User::find(\Illuminate\Support\Facades\Auth::id());
            @endphp
            <div class="button-new">
                <a class="btn btn-primary" href="{{url('patients/'. $patient->id)}}">Atrás</a>
            </div>
        </div>
    </div>
</div>
<div class="content-his mt-3">
    <p class="title-form">Datos paciente</p>
    <div class="line-form"></div>
    <table class="table">
        <thead>
            <tr>
                <th class="fl-ignore">Nombre</th>
                <th class="fl-ignore">Cédula</th>
                <th class="fl-ignore">Email</th>
                <th class="fl-ignore">Celular</th>
                <th class="fl-ignore">Edad</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background: #f2f2f2;">
                <td class="openPatientdDC" id="{{$patient->id}}">
                    {{ ucwords(mb_strtolower($patient->name . " " . $patient->lastname)) }}
                </td>
                <td>{{ $patient->identy }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->cellphone }}</td>
                <td>
                    @php
                        $cumpleanos = new DateTime($patient->birthday);
                        $hoy = new DateTime();
                        $annos = $hoy->diff($cumpleanos);
                        print $annos->y;
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>
</div>
