<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carrito extends Model
{
    use HasFactory;
    public $table = "carrito";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'user_id'
                                , 'producto_id'
                                , 'cantidad'
                                , 'agregado_en'
                                , 'estado'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
