<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "tb_producto";

    protected $casts = [
        'created_at' => 'date:d/m/Y',
    ];
}
