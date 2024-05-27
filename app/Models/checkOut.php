<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkOut extends Model
{
    use HasFactory;
    public $table = "check_out";
    // protected $connection = 'other_bd'; // Descomentar esta linea y agregar la bd que se requiere...
    protected $fillable =   [     'id'
                                , 'vCampo1_check_out'
                                , 'vCampo2_check_out'
                                , 'vCampo3_check_out'
                                , 'vCampo4_check_out'
                                , 'vCampo5_check_out'
                                , 'vCampo6_check_out'
                                , 'vCampo7_check_out'
                                , 'vCampo8_check_out'
                                , 'vCampo9_check_out'
                                , 'vCampo10_check_out'
                                , 'vCampo11_check_out'
                                , 'vCampo12_check_out'
                                , 'vCampo13_check_out'
                                , 'vCampo14_check_out'
                                , 'vCampo15_check_out'
                                , 'vCampo16_check_out'
                                , 'vCampo17_check_out'
                                , 'vCampo18_check_out'
                                , 'vCampo19_check_out'
                                , 'vCampo20_check_out'
                                , 'vCampo21_check_out'
                                , 'vCampo22_check_out'
                                , 'vCampo23_check_out'
                                , 'vCampo24_check_out'
                                , 'vCampo25_check_out'
                                , 'vCampo26_check_out'
                                , 'vCampo27_check_out'
                                , 'vCampo28_check_out'
                                , 'vCampo29_check_out'
                                , 'vCampo30_check_out'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
