<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sandboxTypes extends Model
{
    use HasFactory;
    public $table = "sandbox_types";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'name'
                                , 'description'
                                , 'is_sandbox'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
