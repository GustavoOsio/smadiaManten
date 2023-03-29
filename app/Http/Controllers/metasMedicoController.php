<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\CenterCost;
use App\Models\comisionesmedicas;

class metasMedicoController extends Controller
{
    public function index()
    {
        $data = comisionesmedicas::orderByDesc('created_at')->get();
        $medicos = User::where('role_id', 2)->orderByDesc('created_at')->get();
        return view('metasMedico.index', ['medicos' => $medicos]);
    }
    public function create()
    {
        // return "hola mundo";
        $data = User::where('role_id', 2)->orderByDesc('created_at')->get();
        $Service = CenterCost::where('status', 'activo')->orderBy('name', 'ASC')->get();

        return view('metasMedico.create', ['medicos' => $data, 'services' => $Service]);
    }
    public function update()
    {
    }
    public function delete()
    {
    }
}
