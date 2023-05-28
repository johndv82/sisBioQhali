<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriaController extends Controller
{
    /**
     * Display index of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->view('mantenimiento.categorias');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $categorias = Categoria::where('estado_cat', 1)->get();
        if($categorias != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $categorias, 'code' => $respuesta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $nuevoIdCategoria = Categoria::count() + 1;
        while(Categoria::where('id_cat', $nuevoIdCategoria)->exists()){
            $nuevoIdCategoria++;
        }
        $categoria = new Categoria();
        $categoria->id_cat = $nuevoIdCategoria;
        $categoria->nombre_cat = strtoupper($request->input('nombre_cat'));
        $categoria->codigo_cat = 'CTG' . sprintf('%05d', $nuevoIdCategoria);
        $categoria->obs_cat = $request->input('obs_cat')??'';
        $categoria->usercreated_cat = "USR1";
        $categoria->save();
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
        $categoria = Categoria::find($id);
        if($categoria != null){
            $respuesta = 200;
        }
        return Response()->json([
            'data' => $categoria, 'code' => $respuesta
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        $categoria->nombre_cat = $request->input('nombre_cat');
        $categoria->obs_cat = $request->input('obs_cat');
        $categoria->usermodified_cat = "USR1";
        $categoria->save();
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
        $categoria = Categoria::find($id);
        $categoria->estado_cat = 0;
        $categoria->save();
        return Response()->json([
            'msg' => 'Se eliminó correctamente',
            'code' => 200
        ]);
    }
}
