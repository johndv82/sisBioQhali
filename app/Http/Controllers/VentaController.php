<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Services\AcumuladoService;
use App\Services\VentaService;

class VentaController extends Controller
{
    protected $serviceAcumulado;
    protected $serviceVenta;

    public function __construct(AcumuladoService $acumuladoServ, VentaService $ventaServ)
    {
        $this->serviceAcumulado = $acumuladoServ;
        $this->serviceVenta = $ventaServ;
    }

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
    public function list(Request $request)
    {
        $respuesta = 404;
        $fecha_ini = date("Y-m-d", strtotime($request->input('fecha_ini')));
        $fecha_fin = date("Y-m-d", strtotime($request->input('fecha_fin')));
        $ventas = Venta::with('cliente')->where('estado_ven', 1)->whereBetween('fecha_ven', [$fecha_ini, $fecha_fin])->get();
        if($ventas != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $ventas, 'code' => $respuesta]);
    }

    /**
     * Return a listing of the Venta Detail.
     *
     * @param  int  $id
     * @return Response
     */
    public function listdetalle($id)
    {
        $respuesta = 404;
        $detalle = DetalleVenta::with('producto')->where('idventa_detven', $id)->get();
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
        while(Venta::where('id_ven', $nuevoIdVenta)->exists()){
            $nuevoIdVenta++;
        }
        
        $detalle_venta = [];
        $total_venta = 0;
        $fecha_venta = strtotime($request->input('fecha_ven'));
        $acumulado = (bool)$request->input('acumulado');

        foreach($request->input('detalle_venta') as $key => $item){
            $total_venta += $item['cantidad'] * $item['preciov'];
            $detVenta = array(
                'IdProducto' => (int)$item['id_producto'],
                'IdVenta' => (int)$nuevoIdVenta,
                'Precio' => (double)$item['preciov'],
                'Cantidad' => (int)$item['cantidad'],
                'Puntos' => (double)$item['puntos'],
                'MedidaProd' => 'ENTERO',
                'UserCreated' => 'USR1',
            );
            array_push($detalle_venta, $detVenta);
        }

        $venta = new Venta();
        $venta->id_ven = $nuevoIdVenta;
        $venta->idcliente_ven = $request->input('idcliente_ven');
        $venta->seriecomp_ven = $request->input('seriecomp_ven');
        $venta->numerocomp_ven = $request->input('numerocomp_ven');
        $venta->tipocomp_ven = 0;
        $venta->total_ven = $total_venta;
        $venta->subtotal_ven = $total_venta - ($total_venta * 0.18);
        $venta->igv_ven = ($total_venta * 0.18);
        $venta->valorigv_ven = 18;
        $venta->dscto_ven = (int)$request->input('dscto_ven');
        $venta->fecha_ven = date('Y-m-d', $fecha_venta);
        $venta->montoresto_ven = 0;
        $venta->formapago_ven = 'CONTADO';
        $venta->numeropago_ven = '';
        $venta->saldo_ven = 0;
        $venta->tipocambio_ven = 'PEN';
        $venta->valorcambio_ven = 1;
        $venta->obs_ven = $request->input('obs_ven')??'';
        $venta->usercreated_ven = "USR1";

        try {
            if($acumulado){
                $this->serviceAcumulado->create($venta, $detalle_venta);
            }else{
                $this->serviceVenta->create($venta, $detalle_venta);
            }

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
     * Returna último Número de Comprobante.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNumeroComprobante()
    {
        $ultimo_numero = Venta::all()->last()->numerocomp_ven;
        if($ultimo_numero != null){
            $ultimo_numero = (int)$ultimo_numero + 1;
        }else{
            $ultimo_numero = 1;
        }
        return response()->json(['data' => $ultimo_numero, 'code' => '200']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        DB::beginTransaction();
        try {
            $venta = Venta::find($id);
            $venta->estado_ven = 0;
            $venta->usermodified_ven = "USR1_DELETE";
            $venta->save();

            Inventario::where('idmovimiento_inv', $id)->update(['estado_inv' => 0]);

            DB::commit();
            $code = 200;
            $message = "Se eliminó correctamente";
        } catch (\Exception $e) {
            DB::rollback();
            $code = 500;
            $message = $e->getMessage();
        }
        return response()->json(['code'=>$code, 'msg'=>$message]);
    }
}
