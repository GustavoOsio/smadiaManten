<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InfirmaryNotes;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfirmaryNotesController extends Controller
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
        $this->authorize('view', InfirmaryNotes::class);
        //$patient = session()->get('patient');
        $idBefore = InfirmaryNotes::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('infirmary-notes.index', [
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
        $this->authorize('create', Product::class);
        $types = Type::where('status', 'activo')->orderBy('name')->get();
        $providers = Provider::where('status', 'activo')->orderBy('company')->get();
        return view('products.create', ['types' => $types, 'providers' => $providers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', InfirmaryNotes::class);
        request()->validate([
            'date' => 'required|string|min:1|max:100',
            'hour' => 'required|string|min:1|max:100',
            //'note' => 'required|string|min:1|max:500',
            //'observations' => 'required|string|min:1|max:500',
        ]);


        $InfirmaryNotes =  InfirmaryNotes::create($request->except('user_id'));

        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $InfirmaryNotes->update([
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
            'id_type'=>15,
            'id_relation'=>$InfirmaryNotes->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('infirmary-notes.show',$request->patient_id)
            ->with('success','Nota de Enfermería creada exitosamente.');
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
        $this->authorize('view', Product::class);
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InfirmaryNotes $InfirmaryNotes)
    {
        $this->authorize('update', InfirmaryNotes::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = InfirmaryNotes::find($id[2]);
        return view('infirmary-notes.show',[
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
    public function update(Request $request, InfirmaryNotes $InfirmaryNotes)
    {
        $this->authorize('update', InfirmaryNotes::class);
        request()->validate([
            'date' => 'required|string|min:1|max:100',
            'hour' => 'required|string|min:1|max:100',
            //'note' => 'required|string|min:1|max:500',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $InfirmaryNotes = InfirmaryNotes::find($id[2]);
        $InfirmaryNotes->update($request->all());
        return redirect()->route('infirmary-notes.edit',$id[2])
            ->with('success','Nota de Enfermería actualizada exitosamente.');
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
