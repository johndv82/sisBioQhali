<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = "tb_detventa";
    protected $primaryKey = 'id_detven';
    protected $hidden = ['usercreated_detven'];

    protected $casts = [
        'created_detven' => 'date:d/m/Y',
    ];

    public $timestamps = false;
}
