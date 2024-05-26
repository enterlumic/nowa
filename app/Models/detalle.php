<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle extends Model
{
    use HasFactory;
    public $table = "detalle";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'vCampo1_detalle'
                                , 'vCampo2_detalle'
                                , 'vCampo3_detalle'
                                , 'vCampo4_detalle'
                                , 'vCampo5_detalle'
                                , 'vCampo6_detalle'
                                , 'vCampo7_detalle'
                                , 'vCampo8_detalle'
                                , 'vCampo9_detalle'
                                , 'vCampo10_detalle'
                                , 'vCampo11_detalle'
                                , 'vCampo12_detalle'
                                , 'vCampo13_detalle'
                                , 'vCampo14_detalle'
                                , 'vCampo15_detalle'
                                , 'vCampo16_detalle'
                                , 'vCampo17_detalle'
                                , 'vCampo18_detalle'
                                , 'vCampo19_detalle'
                                , 'vCampo20_detalle'
                                , 'vCampo21_detalle'
                                , 'vCampo22_detalle'
                                , 'vCampo23_detalle'
                                , 'vCampo24_detalle'
                                , 'vCampo25_detalle'
                                , 'vCampo26_detalle'
                                , 'vCampo27_detalle'
                                , 'vCampo28_detalle'
                                , 'vCampo29_detalle'
                                , 'vCampo30_detalle'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
