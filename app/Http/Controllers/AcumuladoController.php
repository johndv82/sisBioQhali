<?php

namespace App\Http\Controllers;

use App\Models\Acumulado;
use Illuminate\Http\Request;

class AcumuladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('ventas.acumulados');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request)
    {
        $respuesta = 404;
        $idcliente = $request->input('idcliente');
        $acumulados= Acumulado::with('producto')->where([['finalizado_acum', 0], ['idcliente_acum', $idcliente]])->get();
        if($acumulados != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $acumulados, 'code' => $respuesta]);
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
