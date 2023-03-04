<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "tb_cliente";
    protected $primaryKey = 'id_cli';
    protected $hidden = ['modified_cli' ,'usercreated_cli', 'usermodified_cli'];

    protected $casts = [
        'created_cli' => 'date:d/m/Y',
    ];

    public $timestamps = false;
}
