<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MembresiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('mantenimiento.membresias');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $membresias = Membresia::where('estado_mem', 1)->get();
        if($membresias != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $membresias, 'code' => $respuesta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevoIdMembresia = Membresia::count() + 1;
        while(Membresia::where('id_mem', $nuevoIdMembresia)->exists()){
            $nuevoIdMembresia++;
        }
        $membresia = new Membresia();
        $membresia->id_mem = $nuevoIdMembresia;
        $membresia->nombre_mem = $request->input('nombre_mem');
        $membresia->monto_mem = $request->input('monto_mem');
        $membresia->descuento_mem = $request->input('descuento_mem');
        $membresia->obs_mem = $request->input('obs_mem')??'';
        $membresia->usercreated_mem = "USR1";
        $membresia->save();
        return Response()->json([
            'msg' => 'Se registró correctamente',
            'code' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $respuesta = 404;
        $membresia = Membresia::find($id);
        if($membresia != null){
            $respuesta = 200;
        }
        return Response()->json([
            'data' => $membresia, 'code' => $respuesta
        ]);
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
        $membresia = Membresia::find($id);
        $membresia->nombre_mem = $request->input('nombre_mem');
        $membresia->monto_mem = $request->input('monto_mem');
        $membresia->descuento_mem = $request->input('descuento_mem');
        $membresia->obs_mem = $request->input('obs_mem')??'';
        $membresia->usermodified_mem = "USR1";
        $membresia->save();
        return Response()->json([
            'msg' => 'Se actualizó correctamente',
            'code' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $membresia = Membresia::find($id);
        $membresia->estado_mem = 0;
        $membresia->save();
        return Response()->json([
            'msg' => 'Se eliminó correctamente',
            'code' => 200
        ]);
    }
}
