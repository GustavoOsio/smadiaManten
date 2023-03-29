<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PatientPhotographs;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientPhotographsController extends Controller
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
        $this->authorize('view', PatientPhotographs::class);
        $patient = session()->get('patient');
        $fotografias = PatientPhotographs::where('patient_id',$id)->get();
        return view('patient-photographs.index', [
            'fotografias' => $fotografias,
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
        $this->authorize('create', PatientPhotographs::class);
        request()->validate([
            'comments' => 'required|string|min:3',
        ]);
        $files = $request->file('files');
        $array_db = array();
        $cont = 0;
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        foreach($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = Storage::disk('public')->put('patientPhoto/'. time().str_slug($patient->name . " " . $patient->lastname), $file);
            $array_db[$cont] = $path;
            $cont= $cont + 1;
        }
        $PatientPhotographs = new PatientPhotographs();
        $PatientPhotographs->user_id = $id->id;
        $PatientPhotographs->patient_id = $patient->id;
        $PatientPhotographs->array_photos = json_encode($array_db);
        $PatientPhotographs->comments = $request->input('comments');
        $PatientPhotographs->save();
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
            'id_type'=>17,
            'id_relation'=>$PatientPhotographs->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);
        return redirect()->route('patient-photographs.show',$request->patient_id)
            ->with('success','Fotografias de Paciente guardadas exitosamente.');
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
