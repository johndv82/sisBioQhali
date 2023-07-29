<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = "tb_compra";
    protected $primaryKey = 'id_com';
    protected $hidden = ['modified_com' ,'usercreated_com', 'usermodified_com'];

    protected $casts = [
        'created_com' => 'date:d/m/Y',
    ];

    public $timestamps = false;

    public function detalle(){
        return $this->hasMany(DetalleCompra::class,'idcompra_detcom','id_com');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'idproveedor_com', 'id_prov');
    }
}
