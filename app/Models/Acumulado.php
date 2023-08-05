<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acumulado extends Model
{
    protected $table = "tb_acumulado";
    protected $primaryKey = 'id_acum';
    protected $hidden = ['modified_acum' ,'usercreated_acum', 'usermodified_acum'];

    protected $casts = [
        'created_acum' => 'date:d/m/Y',
    ];

    public $timestamps = false;

    public function producto(){
        return $this->belongsTo(Producto::class, 'idproducto_acum', 'id_prod');
    }
}
