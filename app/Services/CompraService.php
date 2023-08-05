<?php

namespace App\Services;

use App\Models\Compra;
use Illuminate\Support\Facades\DB;

class CompraService{
    public function create(Compra $compra, array $detalle):bool{
        $row_count = 0;
        DB::statement('call insertCompra(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                $compra->id_com,
                $compra->idproveedor_com,
                $compra->numerocomp_com,
                $compra->seriecomp_com,
                $compra->fecha_com,
                $compra->tipocambio_com,
                $compra->valorcambio_com,
                $compra->subtotal_com,
                $compra->igv_com,
                $compra->valorigv_com,
                $compra->dscto_com,
                $compra->total_com,
                $compra->obs_com,
                $compra->usercreated_com,
                json_encode($detalle),
                $row_count,
            ));
        return true;
    }
}