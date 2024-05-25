<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promociones extends Model
{
    use HasFactory;
    public $table = "promociones";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'fotos'
                                , 'titulo'
                                , 'descripcion'
                                , 'precio'
                                , 'marca'
                                , 'review'
                                , 'cantidad'
                                , 'color'
                                , 'precio_anterior'
                                , 'target'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
