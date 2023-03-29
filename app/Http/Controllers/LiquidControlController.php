<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LiquidControl;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\RelationLiquidControl;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiquidControlController extends Controller
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
        $this->authorize('view', LiquidControl::class);
        $patient = session()->get('patient');
        $idBefore = LiquidControl::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationLiquidControl::where('liquid_control_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        return view('liquid_control.index', [
            'idBefore'=>$idBefore,
            'relation'=>$relation,
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
        $this->authorize('create', LiquidControl::class);
        request()->validate([
            'total_adm' => 'required',
            'total_del' => 'required',
        ]);

        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $liquidControl =  LiquidControl::create($request->all());
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $liquidControl->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
        ]);

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationLiquidControl = new RelationLiquidControl();
                $liquid_control_id = $liquidControl->id;
                $hour = $request->input('hour'.$i);
                $type = $request->input('type'.$i);
                $type_element = $request->input('type_element'.$i);
                $box = $request->input('box'.$i);
                $RelationLiquidControl->create([
                    'liquid_control_id' => $liquid_control_id,
                    'hour' =>$hour,
                    'type' => $type,
                    'type_element' =>$type_element,
                    'box' => $box,
                ]);
            }
        }

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
            'id_type'=>20,
            'id_relation'=>$liquidControl->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('liquid-control.show',$request->patient_id)
            ->with('success','Control de liquidos creado exitosamente.');

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
    public function edit(LiquidControl $LiquidControl)
    {
        $this->authorize('update', LiquidControl::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = LiquidControl::find($id[2]);
        $relation = RelationLiquidControl::where('liquid_control_id',$value->id)->get();
        return view('liquid_control.show',[
            'value'=>$value,
            'relation'=>$relation,
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
    public function update(Request $request, LiquidControl $LiquidControl)
    {
        $this->authorize('update', LiquidControl::class);
        request()->validate([
            'total_adm' => 'required',
            'total_del' => 'required',
        ]);

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $LiquidControl = LiquidControl::find($id[2]);
        $LiquidControl->update($request->all());

        $liquid_control_id = $LiquidControl->id;

        for($i = 0; $i < count($vector); ++$i){
            $hour = $request->input('hour'.$i);
            $type = $request->input('type'.$i);
            $type_element = $request->input('type_element'.$i);
            $box = $request->input('box'.$i);
            if($vector[$i] == 'new'){
                $RelationLiquidControl = new RelationLiquidControl();
                $RelationLiquidControl->create([
                    'liquid_control_id' => $liquid_control_id,
                    'hour' =>$hour,
                    'type' => $type,
                    'type_element' =>$type_element,
                    'box' => $box,
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel = $request->input('id_rel'.$i);
                $RelationLiquidControl = RelationLiquidControl::find($id_rel);
                $RelationLiquidControl->update([
                    'hour' =>$hour,
                    'type' => $type,
                    'type_element' =>$type_element,
                    'box' => $box,
                ]);
            }
        }
        return redirect()->route('liquid-control.edit',$id[2])
            ->with('success','Control de liquidos actualizado exitosamente.');
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
