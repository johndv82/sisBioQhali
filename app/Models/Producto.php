<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "tb_producto";
    protected $primaryKey = 'id_prod';
    protected $hidden = ['modified_prod' ,'usercreated_prod', 'usermodified_prod'];

    protected $attributes = [
        'idmed_prod' => 1,
        'contenido_prod' => 1
    ];

    protected $casts = [
        'created_prod' => 'date:d/m/Y',
    ];

    public $timestamps = false;

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'idcat_prod', 'id_cat');
    }
}
