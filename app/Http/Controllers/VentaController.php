<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a view of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('ventas.listar');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $ventas = Venta::where('estado_ven', 1)->get();
        if($ventas != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $ventas, 'code' => $respuesta]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('ventas.agregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevoIdVenta = Venta::count() + 1;
        $ultimoIdDetVenta = DetalleVenta::count();
        while(Venta::where('id_ven', $nuevoIdVenta)->exists()){
            $nuevoIdVenta++;
        }
        $venta = new Venta();
        $detalle_venta = [];
        $total_venta = 0;
        $fecha_venta = strtotime($request->input('fecha_ven'));
        foreach($request->input('detalle_venta') as $key => $item){
            $total_venta += $item['cantidad'] * $item['preciov'];
            //Insert Detalle
            $detVenta = new DetalleVenta();
            $detVenta->id_detven = $ultimoIdDetVenta + ($key +1);
            $detVenta->idproducto_detven = $item['id_producto'];
            $detVenta->idventa_detven = $nuevoIdVenta; //Se agrega el id de venta manualmente, por que no hay relación en BD
            $detVenta->precio_detven = $item['preciov'];
            $detVenta->cantidad_detven = $item['cantidad'];
            $detVenta->medidaprod_detven = 'ENTERO';
            $detVenta->usercreated_detven = 'USR1';
            $detalle_venta[] = $detVenta;
        }
        $venta->id_ven = $nuevoIdVenta;
        $venta->idcliente_ven = $request->input('idcliente_ven');
        $venta->seriecomp_ven = $request->input('seriecomp_ven');
        $venta->numerocomp_ven = $request->input('numerocomp_ven');
        $venta->tipocomp_ven = 0;
        $venta->total_ven = $total_venta;
        $venta->subtotal_ven = $total_venta - ($total_venta * 0.18);
        $venta->igv_ven = ($total_venta * 0.18);
        $venta->valorigv_ven = 18;
        $venta->dscto_ven = 0;
        $venta->fecha_ven = date('Y/m/d', $fecha_venta);
        $venta->montoresto_ven = 0;
        $venta->formapago_ven = 'CONTADO';
        $venta->numeropago_ven = '';
        $venta->saldo_ven = 0;
        $venta->tipocambio_ven = 'PEN';
        $venta->valorcambio_ven = 0;
        $venta->obs_ven = '';
        $venta->estadofac_ven = 0;
        $venta->usercreated_ven = "USR1";

        DB::beginTransaction();
        try {
            $venta->save();
            $venta->detalle()->saveMany($detalle_venta);
            DB::commit();
            return Response()->json([
                'msg' => 'Se registró correctamente',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return Response()->json([
                'msg' => $e->getMessage(),
                'code' => 500
            ]);
        } 
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
    public function edit($id)
    {
        return response()->view('ventas.editar');
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
