<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    use HasFactory;
    public $table = "empresa";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'logo'
                                , 'nombre'
                                , 'descripcion'
                                , 'telefono'
                                , 'whatsapp'
                                , 'ubicacion'
                                , 'longitud'
                                , 'latitud'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
