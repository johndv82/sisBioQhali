<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('mantenimiento.proveedores');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $respuesta = 404;
        $proveedores = Proveedor::where('estado_prov', 1)->get();
        if($proveedores != null){
            $respuesta = 200;
        }
        return response()->json(['data' => $proveedores, 'code' => $respuesta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevoIdProveedor = Proveedor::count() + 1;
        while(Proveedor::where('id_prov', $nuevoIdProveedor)->exists()){
            $nuevoIdProveedor++;
        }
        
        $proveedor = new Proveedor();
        $proveedor->id_prov = $nuevoIdProveedor;
        $proveedor->nombre_prov = $request->input('nombre_prov');
        $proveedor->contacto_prov = $request->input('contacto_prov');

        $codigo = trim($request->input('codigo_prov') ?? '');
        if($codigo){
            $proveedor->codigo_prov = strtoupper($codigo);
        }else{
            $proveedor->codigo_prov = 'PROV' . sprintf('%05d', $nuevoIdProveedor);
        }
        $proveedor->ruc_prov = $request->input('ruc_prov');
        $proveedor->domicilio_prov = $request->input('domicilio_prov')??'';
        $proveedor->telefono_prov = $request->input('telefono_prov')??'';
        $proveedor->email_prov = $request->input('email_prov')??'';
        $proveedor->usercreated_cli = "USR1";
        $proveedor->save();
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
        $proveedor = Proveedor::find($id);
        if($proveedor != null){
            $respuesta = 200;
        }
        return Response()->json([
            'data' => $proveedor, 'code' => $respuesta
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
        $proveedor = Proveedor::find($id);
        $proveedor->nombre_prov = $request->input('nombre_prov');
        $proveedor->contacto_prov = $request->input('contacto_prov');
        $proveedor->ruc_prov = $request->input('ruc_prov');
        $proveedor->domicilio_prov = $request->input('domicilio_prov')??'';
        $proveedor->telefono_prov = $request->input('telefono_prov')??'';
        $proveedor->email_prov = $request->input('email_prov')??'';
        $proveedor->usermodified_prov = "USR1";
        $proveedor->save();
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
        $proveedor = Proveedor::find($id);
        $proveedor->estado_prov = 0;
        $proveedor->usermodified_prov = "USR1_DELETE";
        $proveedor->save();
        return Response()->json([
            'msg' => 'Se eliminó correctamente',
            'code' => 200
        ]);
    }
}
