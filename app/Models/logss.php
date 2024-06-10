<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logss extends Model
{
    use HasFactory;
    public $table = "logss";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'user_id'
                                , 'event_type'
                                , 'context'
                                , 'event_data'
                                , 'execution_time'
                                , 'status'
                                , 'severity'
                                , 'source'
                                , 'ip_address'
                                , 'user_agent'
                                , 'description'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
