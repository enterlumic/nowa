<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empleados extends Model
{
    use HasFactory;
    public $table = "empleados";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'nombre'
                                , 'direccion'
                                , 'telefono'
                                , 'email'
                                , 'fecha_ingreso'
                                , 'puesto'
                                , 'salario'
                                , 'jornada'
                                , 'especialidades'
                                , 'certificaciones'
                                , 'usuario'
                                , 'contrasenia'
                                , 'estado'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
