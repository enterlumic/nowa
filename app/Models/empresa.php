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
                                , 'nombre'
                                , 'descripcion'
                                , 'telefono'
                                , 'whatsapp'
                                , 'ubicacion'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
