<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductoController extends Controller
{
    /**
     * Mostrar vista blade de Productos.
     *
     * @return Response
     */
    public function index()
    {
        return response()->view('mantenimiento.productos');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $productos = Producto::where('estado_prod', 1)->get();
        if($productos != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $productos, 'code' => $respuesta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $nuevoIdProducto = Producto::count() + 1;
        while(Producto::where('id_prod', $nuevoIdProducto)->exists()){
            $nuevoIdProducto++;
        }
        $producto = new Producto();
        $producto->id_prod = $nuevoIdProducto;
        $producto->nombre_prod = strtoupper($request->input('nombre_prod'));
        
        $codigo = trim($request->input('codigo_prod') ?? '');
        if($codigo){
            $producto->codigo_prod = strtoupper($codigo);
        }else{
            $producto->codigo_prod = 'PRD' . sprintf('%05d', $nuevoIdProducto);
        }
        $producto->idcat_prod = $request->input('idcat_prod');
        $producto->puntos_prod = $request->input('puntos_prod');
        $producto->precioc_prod = $request->input('precioc_prod');
        $producto->preciov_prod = $request->input('preciov_prod');
        $producto->obs_prod = $request->input('obs_prod')??'';
        $producto->usercreated_prod = "USR1";
        $producto->save();
        return Response()->json([
            'msg' => 'Se registró correctamente',
            'code' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $respuesta = 404;
        $producto = Producto::find($id);
        if($producto != null){
            $respuesta = 200;
        }
        return Response()->json([
            'data' => $producto, 'code' => $respuesta
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->nombre_prod = strtoupper($request->input('nombre_prod'));
        $producto->idcat_prod = $request->input('idcat_prod');
        $producto->puntos_prod = $request->input('puntos_prod');
        $producto->precioc_prod = $request->input('precioc_prod');
        $producto->preciov_prod = $request->input('preciov_prod');
        $producto->obs_prod = $request->input('obs_prod')??'';
        $producto->usermodified_prod = "USR1_EDIT";
        $producto->save();
        return Response()->json([
            'msg' => 'Se actualizó correctamente',
            'code' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->estado_prod = 0;
        $producto->save();
        return Response()->json([
            'msg' => 'Se eliminó correctamente',
            'code' => 200
        ]);
    }
}
