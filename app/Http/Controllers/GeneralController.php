<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function cities(Request $request)
    {
        request()->validate([
            'id' => 'required|integer',
        ]);

        $data= City::where('state_id', $request->id)->orderBy('name')->get();

        return response(json_encode($data), 201)->header('Content-Type', 'text/json');
    }
}