<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\CompraService;

class CompraController extends Controller
{
    protected $serviceCompra;

    public function __construct(CompraService $compraServ)
    {
        $this->serviceCompra = $compraServ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('compras.listar');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request)
    {
        $respuesta = 404;
        $fecha_ini = date("Y-m-d", strtotime($request->input('fecha_ini')));
        $fecha_fin = date("Y-m-d", strtotime($request->input('fecha_fin')));
        $compras = Compra::with('proveedor')->where('estado_com', 1)->whereBetween('fecha_com', [$fecha_ini, $fecha_fin])->get();
        if($compras != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $compras, 'code' => $respuesta]);
    }

    /**
     * Return a listing of the Compra Detail.
     *
     * @param  int  $id
     * @return Response
     */
    public function listdetalle($id)
    {
        $respuesta = 404;
        $detalle = DetalleCompra::with('producto')->where('idcompra_detcom', $id)->get();
        if($detalle != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $detalle, 'code' => $respuesta]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('compras.agregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevoIdCompra = Compra::count() + 1;
        while(Compra::where('id_com', $nuevoIdCompra)->exists()){
            $nuevoIdCompra++;
        }
        
        $detalle_compra = [];
        $total_compra = 0;
        $fecha_compra = strtotime($request->input('fecha_com'));

        foreach($request->input('detalle_compra') as $key => $item){
            $total_compra += $item['cantidad'] * $item['precioc'];
            $det = array(
                'IdProducto' => (int)$item['id_producto'],
                'IdCompra' => (int)$nuevoIdCompra,
                'Precio' => (double)$item['precioc'],
                'Cantidad' => (int)$item['cantidad'],
                'Descuento' => 0,
                'UserCreated' => 'USR1',
            );
            array_push($detalle_compra, $det);
        }

        $compra = new Compra();
        $compra->id_com = $nuevoIdCompra;
        $compra->idproveedor_com = $request->input('idproveedor_com');
        $compra->seriecomp_com = $request->input('seriecomp_com');
        $compra->numerocomp_com = $request->input('numerocomp_com');
        $compra->tipocambio_com = 'PEN';
        $compra->valorcambio_com = 1;
        $compra->total_com = $total_compra;
        $compra->subtotal_com = $total_compra - ($total_compra * 0.18);
        $compra->igv_com = ($total_compra * 0.18);
        $compra->valorigv_com = 18;
        $compra->dscto_com = 0;
        $compra->fecha_com = date('Y-m-d', $fecha_compra);
        $compra->obs_com = $request->input('obs_com')??'';
        $compra->usercreated_com = "USR1";

        try {
            $this->serviceCompra->create($compra, $detalle_compra);
            return Response()->json([
                'msg' => 'Se registró correctamente',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return Response()->json([
                'msg' => $e->getMessage(),
                'code' => 500
            ]);
        } 
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
