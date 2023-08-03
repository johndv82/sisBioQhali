<?php

namespace App\Services;

use App\Models\Acumulado;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class AcumuladoService{
    public function create(Venta $venta, array $detalle):bool{
        $ultimoIdAcumulado = Acumulado::all()->last()->id_acum;

        DB::beginTransaction();
        try {
            
            foreach($detalle as $key=>$item){
                $acumulado = new Acumulado();
                $acumulado->id_acum = $ultimoIdAcumulado + ($key +1);
                $acumulado->idcliente_acum = $venta->idcliente_ven;
                $acumulado->idproducto_acum = $item['IdProducto'];
                $acumulado->preciouni_acum = $item['Precio'];
                $acumulado->cantidad_acum = $item['Cantidad'];
                $acumulado->medidaprod_acum = $item['MedidaProd'];
                $acumulado->puntos_acum = 0;
                $acumulado->valorigv_acum = $venta->valorigv_ven;
                $acumulado->dscto_acum = $venta->dscto_ven;
                $acumulado->formapago_acum = $venta->formapago_ven;
                $acumulado->numeropago_acum = $venta->numeropago_ven;
                $acumulado->tipocambio_acum = $venta->tipocambio_ven;
                $acumulado->valorcambio_acum = $venta->valorcambio_ven;
                $acumulado->finalizado_acum = 0;
                $acumulado->obs_acum = $venta->obs_ven;
                $acumulado->usercreated_acum = $venta->usercreated_ven;
                $acumulado->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        } 

    }
}