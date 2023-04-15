<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "tb_proveedor";
    protected $primaryKey = 'id_prov';
    protected $hidden = ['modified_prov' ,'usercreated_prov', 'usermodified_prov'];

    protected $casts = [
        'created_prov' => 'date:d/m/Y',
    ];

    public $timestamps = false;
}
