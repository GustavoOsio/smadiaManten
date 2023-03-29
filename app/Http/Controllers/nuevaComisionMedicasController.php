<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\User;
class nuevaComisionMedicasController extends Controller
{
    public function index()
    {
        return view('nuevaComisionMedica.index');
    }

    public function create(Service $services, User $user)
    {
     
        return view('nuevaComisionMedica.create',[
            "servicios"=>$services::all(),
            "medicos"=>$user::where('role_id',2)->get()
        ]);
    }
    public function show()
    {
        return "show";
    }

    public function update()
    {
        return "update";
    }

    public function delete()
    {
        return "delete";
    }
}
