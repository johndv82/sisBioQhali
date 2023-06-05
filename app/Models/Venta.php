<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = "tb_venta";
    protected $primaryKey = 'id_ven';
    protected $hidden = ['modified_ven' ,'usercreated_ven', 'usermodified_ven'];

    protected $casts = [
        'created_ven' => 'date:d/m/Y',
    ];

    public $timestamps = false;
}