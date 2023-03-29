<div class="content-his mt-3">
        <div class="row">
            <div class="col-lg-12 margin-tb">
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
                    <td>{{ ucwords(mb_strtolower($patient->name . " " . $patient->lastname)) }}</td>
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
