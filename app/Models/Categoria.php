<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "tb_categoria";
    protected $primaryKey = 'id_cat';
    protected $hidden = ['modified_cat' ,'usercreated_cat', 'usermodified_cat'];

    public $timestamps = false;
}
