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
                                , 'vCampo1_promociones'
                                , 'vCampo2_promociones'
                                , 'vCampo3_promociones'
                                , 'vCampo4_promociones'
                                , 'vCampo5_promociones'
                                , 'vCampo6_promociones'
                                , 'vCampo7_promociones'
                                , 'vCampo8_promociones'
                                , 'vCampo9_promociones'
                                , 'vCampo10_promociones'
                                , 'vCampo11_promociones'
                                , 'vCampo12_promociones'
                                , 'vCampo13_promociones'
                                , 'vCampo14_promociones'
                                , 'vCampo15_promociones'
                                , 'vCampo16_promociones'
                                , 'vCampo17_promociones'
                                , 'vCampo18_promociones'
                                , 'vCampo19_promociones'
                                , 'vCampo20_promociones'
                                , 'vCampo21_promociones'
                                , 'vCampo22_promociones'
                                , 'vCampo23_promociones'
                                , 'vCampo24_promociones'
                                , 'vCampo25_promociones'
                                , 'vCampo26_promociones'
                                , 'vCampo27_promociones'
                                , 'vCampo28_promociones'
                                , 'vCampo29_promociones'
                                , 'vCampo30_promociones'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
