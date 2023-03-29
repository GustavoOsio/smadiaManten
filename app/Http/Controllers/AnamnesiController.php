<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anamnesis;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnamnesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $this->authorize('view', Anamnesis::class);
        $patient = session()->get('patient');
        $idBefore = Anamnesis::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('anamnesis.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'patient_id'=>$id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Anamnesis::class);
        //$types = Type::where('status', 'activo')->orderBy('name')->get();
        //$providers = Provider::where('status', 'activo')->orderBy('company')->get();
        return view('anamnesis.create', ['types' => '', 'providers' => '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Anamnesis::class);
        request()->validate([
            'reason_consultation' => 'required|string|min:1',
            'current_illness' => 'required|string|min:1',
            'ant_patologico' => 'required|string|min:1',
            'ant_surgical' => 'required|string|min:1',
            'ant_allergic' => 'required|string|min:1',
            'ant_traumatic' => 'required|string|min:1',
            'ant_medicines' => 'required|string|min:1',
            'ant_gynecological' => 'required|string|min:1',
            //'ant_fum' => 'required|string|min:3|max:500',
            'ant_habits' => 'required|string|min:1',
            'ant_familiar' => 'required|string|min:1',
            'ant_nutritional' => 'required|string|min:1',
            //'observations' => 'required|string|min:1',
        ]);


        $Anamnesis =  Anamnesis::create($request->except('user_id'));

        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $Anamnesis->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
        ]);


        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $todayh = getdate();
        $d = date("d");
        $m = date("m");
        $y = $todayh['year'];
        $date = $d.'/'.$m.'/'.$y;

        $medicalHistory = MedicalHistory::create([
            'user_id'=> $id->id,
            'id_type'=>1,
            'id_relation'=>$Anamnesis->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('anamnesis.show',$request->patient_id)
            ->with('success','Anamnesis creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function show($id)
    {
        $this->authorize('view', Anamnesis::class);
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Anamnesis $Anamnesis)
    {
        $this->authorize('update', Anamnesis::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = Anamnesis::find($id[2]);
        return view('anamnesis.show',[
            'value'=>$value,
            'patient_id'=>$value->patient_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anamnesis $anamnesis)
    {
        $this->authorize('update', Anamnesis::class);
        request()->validate([
            'reason_consultation' => 'required|string|min:1',
            'current_illness' => 'required|string|min:1',
            'ant_patologico' => 'required|string|min:1',
            'ant_surgical' => 'required|string|min:1',
            'ant_allergic' => 'required|string|min:1',
            'ant_traumatic' => 'required|string|min:1',
            'ant_medicines' => 'required|string|min:1',
            'ant_gynecological' => 'required|string|min:1',
            'ant_habits' => 'required|string|min:1',
            'ant_familiar' => 'required|string|min:1',
            'ant_nutritional' => 'required|string|min:1',
            //'observations' => 'required|string|min:1',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $anamnesis = Anamnesis::find($id[2]);
        $anamnesis->update($request->all());
        return redirect()->route('anamnesis.edit',$id[2])
            ->with('success','Anamnesis actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', Product::class);
        $product->delete();
        return redirect()->route('products.index')
            ->with('success','Producto eliminado exitosamente');
    }
}
