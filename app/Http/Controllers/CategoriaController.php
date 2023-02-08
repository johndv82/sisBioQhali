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
        return response()->view('categoria.listado');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $categorias = Categoria::all();
        if($categorias != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $categorias, 'code' => $respuesta]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
        $categoria = new Categoria();
        $categoria->id_cat = $nuevoIdCategoria;
        $categoria->nombre_cat = $request->input('nombre');
        $categoria->codigo_cat = "EJM01";
        $categoria->obs_cat = $request->input('observaciones');
        $categoria->usercreated_cat = "USR1";
        $categoria->save();
        return Response()->json([
            'msg' => 'OK'
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
        return Response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return Response();
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
        return Response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return Response();
    }
}
