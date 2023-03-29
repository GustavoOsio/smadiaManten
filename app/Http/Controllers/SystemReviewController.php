<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\SystemReview;
use App\Models\Systems;
use App\Models\SystemsPathologies;
use App\Models\SystemsReviewRelation;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemReviewController extends Controller
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
        $this->authorize('view', SystemReview::class);
        $patient = session()->get('patient');
        $idBefore = SystemReview::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = SystemsReviewRelation::where('system_review_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $systems = Systems::all();
        return view('system-review.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'systems'=>$systems,
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
        $this->authorize('create', SystemReview::class);
        /*
        request()->validate([
            'system_head_face_neck' => 'required|string|min:3|max:500',
            'system_respiratory_cardio' => 'required|string|min:3|max:500',
            'system_digestive' => 'required|string|min:3|max:500',
            'system_genito_urinary' => 'required|string|min:3|max:500',
            'system_locomotor' => 'required|string|min:3|max:500',
            'system_nervous' => 'required|string|min:3|max:500',
            'system_integumentary' => 'required|string|min:3|max:500',
            'observations' => 'required|string|min:3|max:500',
        ]);*/
        $SystemReview = SystemReview::create($request->all());
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $SystemReview->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
        ]);

        $systems = Systems::all();
        foreach($systems as $s){
            $phato = SystemsPathologies::where('systems_id',$s->id)->get();
            foreach ($phato as $p){
                $SystemsReviewRelation = new SystemsReviewRelation();
                $system_review_id = $SystemReview->id;
                $select = $request->input('system_'.$s->id.'_phato_'.$p->id);
                $SystemsReviewRelation->create([
                    'system_review_id' =>$system_review_id,
                    'systems_id'=>$s->id,
                    'pathology'=>$p->name,
                    'select' =>$select,
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
            'id_type'=>2,
            'id_relation'=>$SystemReview->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);
        return redirect()->route('system-review.show',$request->patient_id)
            ->with('success','Revisión por Sistema creada exitosamente.');
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
    public function edit(SystemReview $systemReview)
    {
        $this->authorize('update', SystemReview::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = SystemReview::find($id[2]);
        $systems = Systems::all();
        $relation = SystemsReviewRelation::where('system_review_id',$id[2])->get();
        return view('system-review.show',[
            'value'=>$value,
            'systems'=>$systems,
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
    public function update(Request $request, SystemReview $SystemReview)
    {
        $this->authorize('update', SystemReview::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $SystemReview = SystemReview::find($id[2]);
        $SystemReview->update($request->all());

        $systems = Systems::all();
        foreach($systems as $s){
            $phato = SystemsPathologies::where('systems_id',$s->id)->get();
            foreach ($phato as $p){
                $SystemsReviewRelation = SystemsReviewRelation::where('system_review_id',$SystemReview->id)
                    ->where('systems_id',$s->id)
                    ->where('pathology',$p->name)
                    ->first();
                $select = $request->input('system_'.$s->id.'_phato_'.$p->id);
                $SystemsReviewRelation->select = $select;
                $SystemsReviewRelation->save();
            }
        }
        return redirect()->route('system-review.edit',$id[2])
            ->with('success','Revisión por Sistema actualizada exitosamente.');
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
