<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = "tb_detcompra";
    protected $primaryKey = 'id_detcom';
    protected $hidden = ['usercreated_detcom'];

    protected $casts = [
        'created_detcom' => 'date:d/m/Y',
    ];

    public $timestamps = false;

    public function compra()
    {
        return $this->belongsTo(Compra::class,'idcompra_detcom','id_com');
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'idproducto_detcom', 'id_prod');
    }
}
