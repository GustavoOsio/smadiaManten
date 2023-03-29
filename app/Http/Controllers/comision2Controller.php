<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Models\comisionesmedicas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class comision2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     //agregar parametro

     public function indexParametro()
     {
        $data= DB::select(" SELECT * FROM parametro ");
         return view('parametro.index',
         ['parametro'=>$data]);

         //
     }

     public function showParametro()
     {
        $data= DB::select(" SELECT * FROM parametro ");
         return view('parametro.index',
         ['parametro'=>$data]);

         //
     }

     public function updateParametro(Request $request)

     {
        request()->validate([
            'parametro'=>'required',
            'valor' =>'required|numeric|between:0,100',

         ],[
            'parametro.required' => __('Debe elegir un parametro'),
              'valor.required' => __('El campo valor es obligatorio.'),
            'valor.between' => __('El valor ingresado debe ser un porcentaje entre 0 y 100. Por favor, asegúrese de ingresar un valor mayor que cero y menor o igual a 100'),
            'valor.numeric' => __('El porcentaje debe ser un número')
        ]);

        $parametro = $request->input('parametro');
        $porcentaje=  $request->input('valor');
        $total=$porcentaje/100;
        DB::update(" UPDATE parametro SET porcentaje= ? WHERE tipo = ? ", [ $total,$parametro]);

        $data= DB::select(" SELECT * FROM parametro ");
         return view('parametro.index',
         ['parametro'=>$data ]);

         //
     }
     //fin agregar parametro

     //comisiones nuevas logica

     public function indexAdicional($id)
     {

        $budge=$id;

 $detalleAdicionales = DB::select("
 SELECT id,id_presupuesto, concepto, valor, comentario FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$budge]);


         return view('budgets.form_budget',
         ['budget_id'=>$budge,'adicional'=>$detalleAdicionales]);

         //
     }


     public function deleteAdicional($id, $id_date)
     {
        $id=$id;
        $budge=$id_date;

 $detalleAdicionales = DB::select("
 SELECT id,id_presupuesto, concepto, valor, comentario FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$budge]);

 DB::delete('DELETE FROM adicional WHERE id= ? ', [$id]);

         return view('budgets.form_budget',
         ['budget_id'=>$budge,'adicional'=>$detalleAdicionales,]);

         //
     }


     public function storeAdicional(Request $request)
     {
         //agregar los servicios comisionables de  los usuarios

           request()->validate([
             'concepto'=>'required',
             'valor' =>'required|numeric|min:1',
             'coment' =>'required'
          ],[
             'concepto.required' => __('Debe elegir un concepto'),
             'valor.required' => __('El campo valor es obligatorio.'),
             'coment.required' => __('El campo comentario es obligatorio.')
         ]);
         $concepto = $request->input('concepto');

         if($concepto=="Deducible"){
            request()->validate([
                'valor' =>'required|numeric|between:0,100',
            ],[
                'valor.between' => __('El valor ingresado debe ser un porcentaje entre 0 y 100. Por favor, asegúrese de ingresar un valor mayor que cero y menor o igual a 100'),
                'valor.numeric' => __('El porcentaje debe ser un número')

            ]);

         }
         $concepto = $request->input('concepto');
         $valor = $request->input('valor');
         $coment = $request->input('coment');
         $estado="Agregado con exito";
         $budget_id=$request->input('budget_id');

     DB::insert("INSERT INTO adicional (id_presupuesto, concepto, valor, comentario)
     VALUES (?, ?, ?, ?)", [$budget_id,$concepto,$valor,$coment]);

$detalleAdicionales = DB::select("
SELECT * FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$budget_id]);

 return view('budgets.form_budget', ['estado' => $estado,'budget_id'=>$budget_id,'adicional'=>$detalleAdicionales]);
     }




//aqui finaliza nueva logica


    public function index()
    {

// Crear un objeto Carbon para la fecha actual
$fechaActual = Carbon::now();

$fechaInicialMes = $fechaActual->startOfMonth()->format('Y-m-d');
$fechaFinalMes = $fechaActual->endOfMonth()->format('Y-m-d');

        //vista inicial de los empleados productos
        $saleEmpleado = DB::select("SELECT DISTINCT id_user,title,cedula, vendedor,apellido, rol,
        SUM(valor_comision) AS total  FROM bonus_application_producto  GROUP BY id_user  ORDER BY total DESC ");

        return view('comision.index', ['salesProducto'=>$saleEmpleado, 'fechaIni'=>$fechaInicialMes, 'fechaFin'=>$fechaFinalMes, 'total'=>null]);

        //
    }



    public function detalle($id,$fehaIni,$fechaFin,$total)
    {
       //aqui se ven los detalles de las ventas filtrados por fecha
        $idEmpleado=$id;
        $startDate = $fehaIni;
        $endDate = $fechaFin;
        $valor=$total;
$detalleVentas = DB::select("
SELECT fecha, vendedor,apellido, rol, paciente, linea, producto, valor,
method_payment, no_deducible, p_tarjeta, p_comision, valor_base_comisionable, valor_comision
FROM bonus_application_producto WHERE id_user= ? AND  fecha
BETWEEN ? AND ? ORDER BY valor_comision DESC  ",[$idEmpleado,$startDate,$endDate]);

return view('comision.detalle', ['detalle' => $detalleVentas,
'total'=> $valor, 'id'=>$idEmpleado, 'fechaIni'=>$startDate,'fechaFin'=>$endDate ]);

}


public function detalle2($id2,$total2)
{
   //aqui se ven los detalles de las ventas filtrados por fecha
    $idEmpleado=$id2;

    $valor=$total2;

if(isset($idEmpleado)){
    $detalleVentas = DB::select("
    SELECT fecha, vendedor,apellido, rol, paciente, linea, producto, valor,
    method_payment, no_deducible, p_tarjeta, p_comision, valor_base_comisionable, valor_comision
    FROM bonus_application_producto  WHERE id_user= ? ORDER BY valor_comision DESC  " ,[$idEmpleado]);
}
return view('comision.detalle', ['detalle' => $detalleVentas, 'total'=> $valor,
 'id'=>$idEmpleado, 'fechaIni'=>null,'fechaFin'=>null, 'token'=>'true' ]);


}

    public function servicio()
    {

        $fechaActual = Carbon::now();
        $fechaInicialMes = $fechaActual->startOfMonth()->format('Y-m-d');
        $fechaFinalMes = $fechaActual->endOfMonth()->format('Y-m-d');
        //vista inicial de los empleados productos
        $contratoServicio = DB::select("SELECT DISTINCT usuario_id,cedula, contrato_id,
        medico, medico_apellido, cargo, tipo_comision , p_comision, SUM(valor_base_comisionable) AS total,
        meta_hacer
        FROM bonus_application_service2
        WHERE tipo_comision='por_hacer'
        GROUP BY usuario_id ORDER BY total DESC ");
        return view('comision.servicio', ['comisionContrato'=>$contratoServicio, 'fechaIni'=>$fechaInicialMes, 'fechaFin'=> $fechaFinalMes, 'total'=>null , 'medico'=>null]);
    }


public function detalleServicio($id,$fehaIni,$fechaFin,$total)
{
   //aqui se ven los detalles de las ventas filtrados por fecha
    $idEmpleado=$id;
    $startDate = $fehaIni;
    $endDate = $fechaFin;
    $valor=$total;

     $detalleVentas = DB::select("
     SELECT fecha_cita, titulo, cargo, medico, medico_apellido, paciente, paciente_apellido, contrato,
servicio, precio_servicio, item_servicio, cita_comentario, medio_pago ,p_tarjeta,
insumo,obsequio,otro, capital, abono,valor_base_comisionable , p_comision
FROM bonus_application_service2 WHERE usuario_id= ? AND  fecha_cita
BETWEEN ? AND ? ",[$idEmpleado,$startDate,$endDate]);

return view('comision.detalleServicio', ['detalle' => $detalleVentas,
'total'=> $valor,'fechaIni'=>$startDate, 'fechaFin'=>$endDate, 'id'=>$idEmpleado]);

}

public function detalleServicio2($id,$total)
{
   //aqui se ven los detalles de las ventas filtrados por fecha
    $idEmpleado=$id;
    $valor=$total;

     $detalleVentas = DB::select("
     SELECT fecha_cita, titulo, cargo, medico, medico_apellido, paciente, paciente_apellido, contrato,
servicio, precio_servicio, item_servicio, cita_comentario, medio_pago,p_tarjeta,
insumo,obsequio,otro ,capital, abono,valor_base_comisionable , p_comision
FROM bonus_application_service2 WHERE usuario_id= ? ",[$idEmpleado]);

return view('comision.detalleServicio', ['detalle' => $detalleVentas, 'total'=> $valor, 'token'=>'true','id'=>$idEmpleado]);

}


public function showServicio(Request $request)
{

$tipo=$request->input('tipo_comision');
$idEmpleado=$request->input('empleado');
$startDate = $request->input('date_start');
$endDate = $request->input('date_end');

if(isset($idEmpleado) and isset($startDate ) and isset($endDate)  ){

    $contratoServicio = DB::select("SELECT DISTINCT usuario_id,cedula, contrato_id,
    medico, medico_apellido, cargo, tipo_comision , p_comision, SUM(valor_base_comisionable) AS total,
    meta_hacer
    FROM bonus_application_service2
    WHERE tipo_comision= ? AND usuario_id = ? AND
         fecha_cita BETWEEN ? AND ?
    GROUP BY usuario_id ORDER BY total DESC ", [$tipo,$idEmpleado,$startDate,$endDate]);


}else if( isset($startDate ) and isset($endDate)  ){
    $contratoServicio = DB::select("SELECT DISTINCT usuario_id,cedula, contrato_id,
    medico, medico_apellido, cargo, tipo_comision , p_comision, SUM(valor_base_comisionable) AS total,
    meta_hacer
    FROM bonus_application_service2
    WHERE tipo_comision= ?  AND
         fecha_cita BETWEEN ? AND ?
    GROUP BY usuario_id ORDER BY total DESC ", [$tipo,$startDate,$endDate]);
}
$medico = DB::select("SELECT DISTINCT usuario_id, contrato_id,
medico, medico_apellido, cargo, SUM(valor_base_comisionable) AS total
FROM bonus_application_service2  GROUP BY usuario_id ORDER BY total DESC ");

return view('comision.servicio', ['comisionContrato'=>$contratoServicio,
'fechaIni'=>$startDate, 'fechaFin'=>$endDate, 'total'=>null, 'medico'=>$medico, 'token'=>'true', 'tipo'=>$tipo ]);

}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePago($id_user,$fechaIni, $fechaFin)
    {
        // guardar historico registro pago comision
        $idEmpleado=$id_user;
        $startDate=$fechaIni;
        $endDate=$fechaFin;
//consulta para pago

if($startDate=='0' and  $endDate=='0' ){
    $registros = DB::select("
    SELECT id_producto, id_comision, fecha, vendedor,apellido, rol, paciente, linea, producto, valor,
    method_payment, no_deducible, p_tarjeta, p_comision, valor_base_comisionable, valor_comision
    FROM bonus_application_producto WHERE id_user= ? ORDER BY valor_comision DESC  ",[$idEmpleado]);

}else{
    $registros = DB::select("
    SELECT id_producto, id_comision, fecha, vendedor,apellido, rol, paciente, linea, producto, valor,
    method_payment, no_deducible, p_tarjeta, p_comision, valor_base_comisionable, valor_comision
    FROM bonus_application_producto WHERE id_user= ? AND  fecha
    BETWEEN ? AND ? ORDER BY valor_comision DESC  ",[$idEmpleado,$startDate,$endDate]);
}

foreach ($registros as $registro) {
    DB::insert("INSERT INTO bonushistory (id_comision, id_product, id_user, status, comment )
    VALUES (?, ?, ?, ?, ?)", [$registro->id_comision,$registro->id_producto , $idEmpleado, 'pagada', 'venta producto' ]);
}
        return view('comision.store', ['pagoComision' => 'pago realizado', 'registro'=> $registros   ]);

    }


    public function storeDescartar($id_user,$fechaIni, $fechaFin)
    {
        // guardar historico registro descarte de comision
        $idEmpleado=$id_user;
        $startDate=$fechaIni;
        $endDate=$fechaFin;
//consulta para pago

if($startDate=='0' and  $endDate=='0' ){
    $registros = DB::select("
    SELECT id_producto, id_comision, fecha, vendedor,apellido, rol, paciente, linea, producto, valor,
    method_payment, no_deducible, p_tarjeta, p_comision, valor_base_comisionable, valor_comision
    FROM bonus_application_producto WHERE id_user= ? ORDER BY valor_comision DESC  ",[$idEmpleado]);

}else{
    $registros = DB::select("
    SELECT id_producto, id_comision, fecha, vendedor,apellido, rol, paciente, linea, producto, valor,
    method_payment, no_deducible, p_tarjeta, p_comision, valor_base_comisionable, valor_comision
    FROM bonus_application_producto WHERE id_user= ? AND  fecha
    BETWEEN ? AND ? ORDER BY valor_comision DESC  ",[$idEmpleado,$startDate,$endDate]);
}

foreach ($registros as $registro) {
    DB::insert("INSERT INTO bonushistory (id_comision, id_product, id_user, status, comment )
    VALUES (?, ?, ?, ?, ?)", [$registro->id_comision,$registro->id_producto , $idEmpleado, 'descartada', 'venta producto' ]);
}
        return view('comision.store', ['pagoComision' => 'Descarte realizado', 'registro'=> $registros   ]);

    }


    public function storePagoServicio($id_user,$fechaIni, $fechaFin)
    {
        // guardar historico registro pago comision
        $idEmpleado=$id_user;
        $startDate=$fechaIni;
        $endDate=$fechaFin;
//consulta para pago

if($startDate=='0' and  $endDate=='0' ){
    $registros = DB::select("
    SELECT id_comision, id_product, fecha_cita, titulo, cargo, medico, medico_apellido, paciente, paciente_apellido, contrato,
servicio, precio_servicio, item_servicio, cita_comentario, medio_pago ,p_tarjeta,
insumo,obsequio,otro, capital, abono,valor_base_comisionable ,valor_comision, p_comision
FROM bonus_application_service WHERE usuario_id= ? ",[$idEmpleado]);

}else{
    $registros = DB::select("
    SELECT id_comision, id_product, fecha_cita, titulo, cargo, medico, medico_apellido, paciente, paciente_apellido, contrato,
servicio, precio_servicio, item_servicio, cita_comentario, medio_pago ,p_tarjeta,
insumo,obsequio,otro, capital, abono,valor_base_comisionable ,valor_comision, p_comision
FROM bonus_application_service WHERE usuario_id= ? AND  fecha_cita
BETWEEN ? AND ? ",[$idEmpleado,$startDate,$endDate]);
}

foreach ($registros as $registro) {
    DB::insert("INSERT INTO bonushistory (id_comision, id_product, id_user, status, comment )
    VALUES (?, ?, ?, ?, ?)", [$registro->id_comision,$registro->id_product , $idEmpleado, 'pagada', 'comision servicio' ]);
}
        return view('comision.store', ['pagoComision' => 'pago realizado', 'registro'=> $registros   ]);

    }

    public function storeDescartarServicio($id_user,$fechaIni, $fechaFin)
    {
        // guardar historico registro pago comision
        $idEmpleado=$id_user;
        $startDate=$fechaIni;
        $endDate=$fechaFin;
//consulta para pago

if($startDate=='0' and  $endDate=='0' ){
    $registros = DB::select("
    SELECT id_comision, id_product, fecha_cita, titulo, cargo, medico, medico_apellido, paciente, paciente_apellido, contrato,
servicio, precio_servicio, item_servicio, cita_comentario, medio_pago ,p_tarjeta,
insumo,obsequio,otro, capital, abono,valor_base_comisionable ,valor_comision, p_comision
FROM bonus_application_service WHERE usuario_id= ? ",[$idEmpleado]);

}else{
    $registros = DB::select("
    SELECT id_comision, id_product, fecha_cita, titulo, cargo, medico, medico_apellido, paciente, paciente_apellido, contrato,
servicio, precio_servicio, item_servicio, cita_comentario, medio_pago ,p_tarjeta,
insumo,obsequio,otro, capital, abono,valor_base_comisionable ,valor_comision, p_comision
FROM bonus_application_service WHERE usuario_id= ? AND  fecha_cita
BETWEEN ? AND ? ",[$idEmpleado,$startDate,$endDate]);
}

foreach ($registros as $registro) {
    DB::insert("INSERT INTO bonushistory (id_comision, id_product, id_user, status, comment )
    VALUES (?, ?, ?, ?, ?)", [$registro->id_comision,$registro->id_product , $idEmpleado, 'descartada', 'comision servicio' ]);
}
        return view('comision.store', ['pagoComision' => 'Descarte realizado', 'registro'=> $registros   ]);

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      /*  request()->validate([

            'date_start'=>'required',
            'date_end' =>'required'
         ],[
            'date_start.required' => __('El campo fecha inicial es obligatorio.'),
            'date_end.required' => __('El campo fecha final es obligatorio.')
        ]);*/

   $idEmpleado=$request->input('empleado');
   $startDate = $request->input('date_start');
   $endDate = $request->input('date_end');



   $medico = DB::select("SELECT DISTINCT id_user,title,cedula, vendedor,apellido, rol,
   SUM(valor_comision) AS total  FROM bonus_application_producto  GROUP BY id_user ");

if(isset($idEmpleado) and isset($startDate ) and isset($endDate)  ){

    $saleEmpleado = DB::select(" SELECT DISTINCT  id_user, vendedor,apellido,cedula, rol,
    SUM(valor_comision) AS total  FROM bonus_application_producto WHERE id_user = ? AND
     fecha BETWEEN ? AND ? GROUP BY id_user  ORDER BY total DESC ", [$idEmpleado,$startDate,$endDate]);
}else if( isset($startDate ) and isset($endDate)  ){
    $saleEmpleado = DB::select(" SELECT DISTINCT id_user, vendedor,'apellido',cedula, rol,
    SUM(valor_comision) AS total  FROM bonus_application_producto WHERE
     fecha BETWEEN ? AND ?  GROUP BY id_user  ORDER BY total DESC ", [$startDate,$endDate]);
}

//consulta para obtener el valor de las comisiones
return view('comision.index', ['medico' =>$medico,
'salesProducto'=>$saleEmpleado, 'fechaIni'=> $startDate, 'fechaFin'=>$endDate, 'token'=>'true']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function indexServiciosBono($id_user)
    {
        //listado de todo los servicios que son bonificables y no

     $id=$id_user;
     $serviceBono = DB::select(" SELECT id, name AS servicio, price AS valor,
        contract AS contrato  , STATUS FROM services WHERE status='activo'
         ORDER BY id DESC ");

$serviciosAgregado = DB::select(" SELECT US.id as id, U.name AS nombre, U.lastname AS apellido, S.name as servicio, S.price
as precio, US.tipo_comision as tipo, S.contract as contrato, S.status as estado
FROM user_product_bono US
INNER JOIN users U ON US.id_user=U.id
INNER JOIN services S ON S.id=US.id_servicio
WHERE US.id_user= ?  AND US.status='activo'
ORDER BY US.id DESC ", [$id]);


return view('users.commission.form_service', ['servicio' =>$serviceBono,
 'id'=>$id, 'lista'=>$serviciosAgregado ]);
    }


    public function storeServiciosBono(Request $request)
    {
        //agregar los servicios comisionables de  los usuarios

          request()->validate([
            'id'=>'required',
            'servicio' =>'required',
            'tipo' =>'required'
         ],[
            'id.required' => __('Error Http.'),
            'servicio.required' => __('El campo servicio es obligatorio.'),
            'tipo.required' => __('El campo tipo bono es obligatorio.')
        ]);
        $servicio = $request->input('servicio');
        $id = $request->input('id');
        $tipo = $request->input('tipo');

    DB::insert("INSERT INTO user_product_bono (id_user, id_servicio, tipo_comision, status )
    VALUES (?, ?, ?, ?)", [$id,$servicio,$tipo, 'activo' ]);

$serviceBono = DB::select(" SELECT id, name AS servicio, price AS valor,
contract AS contrato  , STATUS FROM services WHERE status='activo'
 ORDER BY id DESC ");

$serviciosAgregado = DB::select(" SELECT US.id as id, U.name AS nombre, U.lastname AS apellido, S.name as servicio, S.price
as precio, US.tipo_comision as tipo, S.contract as contrato, S.status as estado
FROM user_product_bono US
INNER JOIN users U ON US.id_user=U.id
INNER JOIN services S ON S.id=US.id_servicio
WHERE US.id_user= ?  AND US.status='activo'
ORDER BY US.id DESC ", [$id]);

return view('users.commission.form_service', ['estado' =>
'servicio agregado con exito!!', 'id'=>$id, 'servicio' =>$serviceBono, 'lista'=>$serviciosAgregado]);
    }



    public function deleteServiciosBono($id, $id_d)
    {
        $idEliminar=$id_d;
        $idUser=$id;
        //eliminar registro
        DB::update(" UPDATE user_product_bono SET status='inactivo' WHERE id = ? ", [$idEliminar]);

        $serviceBono = DB::select(" SELECT id, name AS servicio, price AS valor,
        contract AS contrato  , STATUS FROM services WHERE status='activo'
         ORDER BY id DESC ");

        $serviciosAgregado = DB::select(" SELECT US.id as id,  U.name AS nombre, U.lastname AS apellido,  S.name as servicio, S.price
as precio, US.tipo_comision as tipo, S.contract as contrato, US.status as estado
FROM user_product_bono US
INNER JOIN users U ON US.id_user=U.id
INNER JOIN services S ON S.id=US.id_servicio
WHERE US.id_user= ? AND US.status='activo'
ORDER BY US.id DESC ", [$idUser]);


return view('users.commission.form_service', ['estado' =>
'servicio eliminado con exito!!', 'id'=>$idUser, 'servicio' =>$serviceBono, 'lista'=>$serviciosAgregado]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
