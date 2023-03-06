<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = "tb_membresia";
    protected $primaryKey = 'id_mem';
    protected $hidden = ['modified_mem' ,'usercreated_mem', 'usermodified_mem'];

    public $timestamps = false;
}
