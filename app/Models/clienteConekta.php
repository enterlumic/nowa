<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clienteConekta extends Model
{
    use HasFactory;
    public $table = "cliente_conekta";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'name'
                                , 'number'
                                , 'cvc'
                                , 'exp_month'
                                , 'exp_year'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
