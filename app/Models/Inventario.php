<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = "tb_inventario";
    protected $primaryKey = 'id_inv';
    protected $hidden = ['usercreated_inv'];

    protected $casts = [
        'created_inv' => 'date:d/m/Y',
    ];

    public $timestamps = false;
}
