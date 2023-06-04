<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a view of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('mantenimiento.clientes');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $clientes = Cliente::with('membresia')->where('estado_cli', 1)->get();
        if($clientes != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $clientes, 'code' => $respuesta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevoIdCliente = Cliente::count() + 1;
        while(Cliente::where('id_cli', $nuevoIdCliente)->exists()){
            $nuevoIdCliente++;
        }
        
        $cliente = new Cliente();
        $cliente->id_cli = $nuevoIdCliente;
        $cliente->nombrec_cli = strtoupper($request->input('nombrec_cli'));

        $codigo = trim($request->input('codigo_cli') ?? '');
        if($codigo){
            $cliente->codigo_cli = strtoupper($codigo);
        }else{
            $cliente->codigo_cli = 'CLI' . sprintf('%05d', $nuevoIdCliente);
        }
        $cliente->tipodoc_cli = $request->input('tipodoc_cli');
        $cliente->numerodoc_cli = $request->input('numerodoc_cli');
        $cliente->domicilio_cli = $request->input('domicilio_cli')??'';
        $cliente->telefono_cli = $request->input('telefono_cli')??'';
        $cliente->email_cli = $request->input('email_cli')??'';
        $cliente->idmembresia_cli = $request->input('idmembresia_cli');
        $cliente->obs_cli = $request->input('obs_cli')??'';
        $cliente->usercreated_cli = "USR1";
        $cliente->save();
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
        $cliente = Cliente::find($id);
        if($cliente != null){
            $respuesta = 200;
        }
        return Response()->json([
            'data' => $cliente, 'code' => $respuesta
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findbydocument(Request $request)
    {
        $respuesta = 404;
        $cliente = Cliente::where('numerodoc_cli', $request->input('numero_documento'))->first();
        if($cliente != null){
            $respuesta = 200;
        }
        return Response()->json([
            'data' => $cliente, 'code' => $respuesta
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
        $cliente = Cliente::find($id);
        $cliente->nombrec_cli = strtoupper($request->input('nombrec_cli'));
        $cliente->domicilio_cli = $request->input('domicilio_cli')??'';
        $cliente->telefono_cli = $request->input('telefono_cli')??'';
        $cliente->email_cli = $request->input('email_cli')??'';
        $cliente->idmembresia_cli = $request->input('idmembresia_cli');
        $cliente->obs_cli = $request->input('obs_cli')??'';
        $cliente->usermodified_cli = "USR1";
        $cliente->save();
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
        $cliente = Cliente::find($id);
        $cliente->estado_cli = 0;
        $cliente->usermodified_cli = "USR1_DELETE";
        $cliente->save();
        return Response()->json([
            'msg' => 'Se eliminó correctamente',
            'code' => 200
        ]);
    }
}
