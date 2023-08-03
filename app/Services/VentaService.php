<?php

namespace App\Services;

use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class VentaService{
    public function create(Venta $venta, array $detalle):bool{
        $row_count = 0;
        DB::statement('call insertVenta(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                $venta->id_ven,
                $venta->idcliente_ven,
                $venta->numerocomp_ven,
                $venta->seriecomp_ven,
                $venta->tipocomp_ven,
                $venta->total_ven,
                $venta->subtotal_ven,
                $venta->igv_ven,
                $venta->valorigv_ven,
                $venta->dscto_ven,
                $venta->fecha_ven,
                $venta->montoresto_ven,
                $venta->formapago_ven,
                $venta->numeropago_ven,
                $venta->saldo_ven,
                $venta->tipocambio_ven,
                $venta->valorcambio_ven,
                $venta->obs_ven,
                $venta->usercreated_ven,
                json_encode($detalle),
                $row_count,
            ));
        return true;
    }
}