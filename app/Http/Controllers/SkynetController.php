<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Skynet;
use App\Models\Users;
use App\Lib\LibCore;
use Illuminate\Support\Facades\Auth;
class SkynetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;

    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public function __construct(){
        $this->LibCore = new LibCore();
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS skynet.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('skynet')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla skynet"));
        }

        return view('skynet');
    }

    /*
    |--------------------------------------------------------------------------
    | Agrega o modificar registro
    |--------------------------------------------------------------------------
    | 
    | Modifica el registro solo si manda el parametro '$request->id'
    | @return json
    |
    */
    public function set_skynet($params)
    {
        if(!\Schema::hasTable('skynet')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Skynet"));
        }

        $id_user_o_id_cliente= isset($params['id_user_o_id_cliente']) ? $params['id_user_o_id_cliente'] : 0;
        $vc_evento= isset($params['vc_evento']) ? $params['vc_evento'] : '';
        $vc_query= isset($params['vc_query']) ? $params['vc_query'] : '';
        $vc_info= isset($params['vc_info']) ? $params['vc_info'] : '';

        $data=[ 'id_user_o_id_cliente' => $id_user_o_id_cliente,
                'vc_evento' => $vc_evento,
                'vc_query' => $vc_query,
                'vc_info' => $vc_info,
        ];

        $skynet = Skynet::create( $data );
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_skynet_by_id(Request $request)
    {
        $data= Skynet::select('id_user_o_id_cliente'
                                    , 'vc_evento'
                                    , 'vc_query'
                                    , 'vc_info'
        )->where('id', $request->id)->get();
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_skynet_by_datatable()
    {
        if(!\Schema::hasTable('skynet')){
            return json_encode(array("data"=>"" ));
        }

        $data= Skynet::select(    "id"
                                , "id_user_o_id_cliente"
                                , "vc_evento"
                                , "vc_query"
                                , "vc_info"
        )
        ->orderBy('id', 'desc');


        $total  = $data->count();

        foreach ($data->where('b_status', 1)->orderBy('id', 'DESC')->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->id_user_o_id_cliente
                            , $value->vc_evento
                            , $value->vc_query
                            , '<pre>' . $value->vc_info .'</pre>'
                            , $value->id
            );
        }

        $json_data = array(
            "draw"            => intval( 10 ),   
            "recordsTotal"    => intval( $total ),  
            "recordsFiltered" => intval( $total ),
            "data"            => isset($arr) && is_array($arr)? $arr : ''
        );

        if($total > 0){
            return json_encode($json_data);
        }else{
            return json_encode(array("data"=>"" ));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar registro por id
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function delete_skynet(Request $request)
    {
        $id=$request->id;
        Skynet::where('id', $id)->update(['b_status' => 0]);
        return $id;
    }

    /*
    |--------------------------------------------------------------------------
    | Desahacer el registro que se elimino
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function undo_delete_skynet(Request $request)
    {
        $id=$request->id;
        Skynet::where('id', $id)->update(['b_status' => 1]);
        return $id;
    }

    /*
    |--------------------------------------------------------------------------
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_Skynet()
    {
        Skynet::where('b_status', 1)->update(['b_status' => 0]);
    }

    /*
    |--------------------------------------------------------------------------
    | Solo para desarrolador, para ver lo que va pasando
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function validar_debug()
    {
        if (Auth::user()->email == "gmartinez@tecsa.mx" 
            || Auth::user()->email == "gustavo.gnu87@gmail.com"){
            return true;
        }else{
            return false;
        }
    }
}
