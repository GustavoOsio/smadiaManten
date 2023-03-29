<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LabResults;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LabResultsController extends Controller
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
        $this->authorize('view', LabResults::class);
        $patient = session()->get('patient');
        $idBefore = LabResults::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('lab-results.index', [
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
        $this->authorize('create', LabResults::class);
        request()->validate([
            'description' => 'required|string|min:3',
        ]);

        $patient = Patient::find($request->patient_id);
        $files = $request->file('files');
        $array_db = array();
        $cont = 0;
        foreach($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = Storage::disk('public')->put('lab_results/'. time().str_slug($patient->name . " " . $patient->lastname), $file);
            $array_db[$cont] = $path;
            $cont= $cont + 1;
        }

        $id = User::find(Auth::id());

        $LabResults = new LabResults();
        $LabResults->user_id = $id->id;
        $LabResults->patient_id = $patient->id;
        $LabResults->array_files = json_encode($array_db);
        $LabResults->description = $request->input('description');
        $LabResults->save();

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
            'id_type'=>18,
            'id_relation'=>$LabResults->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('lab-results.show',$request->patient_id)
            ->with('success','Resultados de Laboratorio subidos exitosamente.');
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
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', Product::class);
        $types = Type::where('status', 'activo')->orderBy('name')->get();
        $providers = Provider::where('status', 'activo')->orderBy('company')->get();
        return view('products.edit',['product' => $product, 'types' => $types, 'providers' => $providers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', Product::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'reference' => 'required|string|max:30',
            'tax' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'presentation_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'category_id' => 'required|integer',
            'inventory_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'status' => 'required|alpha|max:8',
        ]);


        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success','Producto actualizado exitosamente.');
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
