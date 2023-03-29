<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use App\Models\comisionesdepartamentos;
use App\Models\productoscomisiones;
use App\Models\Service;
use App\Models\Role;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Cell;

class productosComisionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    

        $data = productoscomisiones::join('products', 'products.id', '=', 'productoscomisiones.idProducto')->get();
        return view('productosComisiones.index', ['productos' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Product::orderByDesc('created_at')->get();
        $Service = Service::where('status', 'activo')->orderByDesc('created_at')->get();

        return view('productosComisiones.create', ['productos' => $data, 'services' => $Service]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

  
                $productoscomisiones = new productoscomisiones();
                $productoscomisiones->idProducto = $request->idProducto;
                $productoscomisiones->valor = $request->valor;
                $productoscomisiones->save();


      
                
       

        return redirect()->route('productosComisiones.create')
            ->with('success','Comisión creada exitosamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cellar $cellar)
    {
        $this->authorize('update', Cellar::class);
        return view('cellars.edit',['cellar' => $cellar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cellar $cellar)
    {
        $this->authorize('update', Cellar::class);
        request()->validate([
            'name' => 'required|string|min:3|max:100',
            'status' => 'required|alpha|max:8',
        ]);


        $cellar->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('cellars.index')
            ->with('success','Bodega actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
