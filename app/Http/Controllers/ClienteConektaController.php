<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\clienteConektaSendMail as FnclienteConektaSendMail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\clienteConekta;
use App\Services\ConektaService;
use App\Lib\LibCore;
use Session;

class ClienteConektaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    | Auth::user()->email;
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;
    protected $conektaService;

    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public function __construct(ConektaService $conektaService){
        $this->LibCore = new LibCore();
        $this->conektaService = $conektaService;
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS cliente_conekta.js
    |
    */
    public function index()
    {

        $this->LibCore->setSkynet( ['vc_evento'=> 'index_cliente_conekta' , 'vc_info' => "index - cliente_conekta" ] );
        return view('cliente_conekta');
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cliente_conekta_datatable(Request $request)
    {
        if(!\Schema::hasTable('cliente_conekta')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_name) && !empty($request->buscar_name) )
            || ( isset($request->buscar_number) && !empty($request->buscar_number) )
            || ( isset($request->buscar_cvc) && !empty($request->buscar_cvc) )
            || ( isset($request->buscar_exp_month) && !empty($request->buscar_exp_month) )
            || ( isset($request->buscar_exp_year) && !empty($request->buscar_exp_year) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_name= isset($request->buscar_name) ? $request->buscar_name :'';
        $buscar_number= isset($request->buscar_number) ? $request->buscar_number :'';
        $buscar_cvc= isset($request->buscar_cvc) ? $request->buscar_cvc :'';
        $buscar_exp_month= isset($request->buscar_exp_month) ? $request->buscar_exp_month :'';
        $buscar_exp_year= isset($request->buscar_exp_year) ? $request->buscar_exp_year :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_cliente_conekta(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_name.'"
            , "'.$buscar_number.'"
            , "'.$buscar_cvc.'"
            , "'.$buscar_exp_month.'"
            , "'.$buscar_exp_year.'"
            ,  '.$request->start.'
            ,  '.$request->length.'
            ,  '.$request->column.'
            ,  "'.$request->order.'"
            ,  @v_registro_total)';

        $result = DB::select($sql);

        // Recuperar el valor de la variable de salida
        $v_registro_total = DB::select('SELECT @v_registro_total as v_registro_total')[0]->v_registro_total;

        return response()->json([
            'data' => $result,
            'recordsTotal' => $v_registro_total,
            'recordsFiltered' => $v_registro_total,
        ]);
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
    public function set_cliente_conekta(Request $request)
    {
        $customerData = [
            'name'  => $request->name,
            'email' => Auth::user()->email,
            'phone' => "8187074784",
            'payment_sources' => [
                [
                    'type' => 'card',
                    'token_id' => $request->token_id
                ]
            ]
        ];

        // ================================
        // Crear un nuevo cliente CONKEKTA
        // ================================
        try {

            // Validar que no este actualizando el registro
            if (!isset($request->id)){
                $customer = $this->conektaService->createCustomer($customerData);
            }

            // Guarda en bd el id de conekta
            $data=[ 'user_id' => Auth::user()->id,
                    'id_conekta' => isset($customer->id)? $customer->id: "",
                    'payment_source_id' => isset($customer->default_payment_source_id)? $customer->default_payment_source_id: "",
                    'name' => isset($request->name)? $request->name:"",
                    'number' => isset($request->number)? $request->number: "",
                    'cvc' => isset($request->cvc)? $request->cvc: "",
                    'exp_month' => isset($request->exp_month)? $request->exp_month: "",
                    'exp_year' => isset($request->exp_year)? $request->exp_year: "",
            ];

            // Si ya existe solo se actualiza el registro
            if (isset($request->id)){
                unset($data['id_conekta'], $data['payment_source_id']);
                DB::table('cliente_conekta')->where('id', $request->id)->update($data);
            }else{ // Nuevo registro
                DB::table('cliente_conekta')->insert($data);
            }

            // Valido que hay podido crear un nuevo Cliente en conekta
            if (isset($customer)){

                // Después de crear el cliente, crea la orden
                $orderData = [
                    'line_items' => [
                        [
                            'name'        => 'Afinacion Mayor',
                            'unit_price'  => 23000,
                            'quantity'    => 1
                        ]
                    ],
                    'currency'    => 'MXN',
                    'customer_info' => [
                        'customer_id' => $customer->id
                    ],
                    'charges' => [
                        [
                            'payment_method' => [
                                'type' => 'card',
                                'payment_source_id' => $customer->default_payment_source_id

                            ]
                        ]
                    ]
                ];

                $order = $this->conektaService->createOrder($orderData);

                // return response()->json($order);

                return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));                
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Validar existencia antes de crear un nuevo registro
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function validar_existencia_cliente_conekta(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= clienteConekta::select('name')
            ->where('name' ,'=', trim($request->name))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= clienteConekta::select('name')
            ->where('name' ,'=', trim($request->name))
            ->get();
        }

        if ( $data->count() > 0 ){
            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "data" => 'sin resultados'));
        }
    }

      public function getServerSidecliente_conekta(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('cliente_conekta')
            ->Where('id', ' > ', 0)
            ->OrWhere('name', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", name, " ", number ) as name')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'name' =>Str::headline($item->name) ];
        });

        return response()->json($options);
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cliente_conekta_by_id(Request $request)
    {
        $data= clienteConekta::select('name'
                                    , 'number'
                                    , 'cvc'
                                    , 'exp_month'
                                    , 'exp_year'
        )->where('id', $request->id)->get();

        if ( $data->count() > 0 ){
            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "data" => 'sin resultados'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Solo se usa para mostrar en una lista <select> ---- </select>
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cat_cliente_conekta(Request $request)
    {
        $data= clienteConekta::select(  'id'
                                    , 'name'
                                    , 'number'
                                    , 'cvc'
                                    , 'exp_month'
                                )->where('b_status', 1)->get();

        if ( $data->count() > 0 ){
            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "data" => 'sin resultados'));
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
    public function delete_cliente_conekta(Request $request)
    {
        $id=$request->id;

        $result = DB::table('cliente_conekta')
            ->select('id_conekta')
            ->where('id', $id)
            ->first();

        // Valido si tiene al menos un registro
        if (!empty($result->id_conekta)){
            $customer = $this->conektaService->deleteCustomer($result->id_conekta);
        }

        clienteConekta::where('id', $id)->delete();
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
    public function undo_delete_cliente_conekta(Request $request)
    {
        $id=$request->id;
        clienteConekta::where('id', $id)->update(['b_status' => 1]);        
        return $id;
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_cliente_conekta()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_cliente_conekta` ');
    }
}
