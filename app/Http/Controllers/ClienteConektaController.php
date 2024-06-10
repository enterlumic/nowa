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

        // $getCustomers = $this->conektaService->getCustomers();
        // dd($getCustomers);

        // $customer = $this->conektaService->deleteCustomer('cus_2w4jue1dNCPz1kyqQ');
        // dd($customer);

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
                    'customer_id' => isset($customer->id)? $customer->id: "",
                    'payment_source_id' => isset($customer->default_payment_source_id)? $customer->default_payment_source_id: "",
                    'name' => isset($request->name)? $request->name:"",
                    'number' => isset($request->number)? $request->number: "",
                    'cvc' => isset($request->cvc)? $request->cvc: "",
                    'exp_month' => isset($request->exp_month)? $request->exp_month: "",
                    'exp_year' => isset($request->exp_year)? $request->exp_year: "",
            ];

            // Si ya existe solo se actualiza el registro
            if (isset($request->id)){
                unset($data['customer_id'], $data['payment_source_id']);
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
    | Agrega o modificar registro
    |--------------------------------------------------------------------------
    | 
    | Modifica el registro solo si manda el parametro '$request->id'
    | @return json
    |
    */
    public function createCustomer(Request $request)
    {
        // $result = DB::table('cliente_conekta')
        //                     ->where('user_id',Auth::user()->id)
        //                     ->value('customer_id');

        // // Valido si ya tiene cuenta en conekta
        // if (!is_null($result)){
        //     // Agregar uno nuevo
        //     $request->merge(["customer_id" => $result]);
        //     return $this->fnAddPaymentSource($request);
        // }

        // ================================
        // Crear un nuevo cliente CONKEKTA
        // ================================
        try {

            $result = DB::table('sandbox_types')
                        ->select('id', 'b_status')
                        ->where('name', 'Tarjetas')
                        ->first();

            if ($result) {
                $request->token_id= 'tok_test_mastercard_4444';
                $request->number = '5555555555554444';
                $request->cvc= 123;
            }

            // Validar que no este actualizando el registro
            if (!isset($request->id)){

                $customerData = [
                    'name'  => $request->name,
                    'email' => Auth::user()->email,
                    // 'phone' => "8187074784",
                    'payment_sources' => [
                        [
                            'type' => 'card',
                            'token_id' => $request->token_id
                        ]
                    ]
                ];

                $customer = $this->conektaService->fnCreateCustomer($customerData);
            }

            // Guarda en bd el id de conekta
            $data=[ 'user_id' => Auth::user()->id,
                    'customer_id' => isset($customer->id)? $customer->id: "",
                    'payment_source_id' => isset($customer->default_payment_source_id)? $customer->default_payment_source_id: "",
                    'name' => isset($request->name)? $request->name:"",
                    'number' => isset($request->number)? $request->number: "",
                    'card_type' => $customer->payment_sources[0]['card_type'],
                    'brand' => $customer->payment_sources[0]['brand'],
                    'cvc' => isset($request->cvc)? $request->cvc: "",
                    'exp_month' => isset($request->exp_month)? $request->exp_month: "",
                    'exp_year' => isset($request->exp_year)? $request->exp_year: "",
            ];

            // Si ya existe solo se actualiza el registro

            if (isset($request->id)){
                unset($data['customer_id'], $data['payment_source_id']);
                DB::table('cliente_conekta')->where('id', $request->id)->update($data);
            }else{ // Nuevo registro
                DB::table('cliente_conekta')->insert($data);
            }

            // $this->LibCore->setSkynet( ['vc_evento'=> 'createCustomer' , 'request' => json_encode($data) ] );
            // $this->LibCore->setSkynet( ['vc_evento'=> 'createCustomer' , 'reponse' => json_encode($customer) ] );

            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));


        } catch (Exception $e) {
            return json_encode(array("b_status"=> false, "vc_message" => "Ocurrio un error..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    |  Esta función tomará el ID del cliente y los datos de la fuente de pago, 
    |  luego utilizará la API de Conekta para agregar la fuente de pago al cliente.
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function fnAddPaymentSource(Request $request)
    {
        $paymentSourceData = [
            'type' => 'card',
            'token_id' => $request->token_id,
            "name" => $request->name,
            "exp_month" => $request->exp_month,
            "exp_year" => $request->exp_year,
            "cvc" => $request->cvc
        ];

        $result = $this->conektaService->AddPaymentSource($request->customer_id, $paymentSourceData);

        if ($result['b_status']) {
            return response()->json(['message' => 'Fuente de pago agregada con éxito.', 'data' => $result['vc_message']], 200);
        } else {
            return response()->json(['message' => $result['vc_message']], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  Para obtener las tarjetas asociadas a un cliente específico en Conekta,
    |  devolver las fuentes de pago asociadas a dicho cliente.
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function fnGetCustomerPaymentSources()
    {

        $customerId = DB::table('cliente_conekta')
                        ->where('user_id', Auth::user()->id)
                        ->value('customer_id');

        if ($customerId) {
            // Llamar al servicio ConektaService para obtener las fuentes de pago
            $response = $this->conektaService->getCustomerPaymentSources($customerId);

            if ($response['b_status']) {
                $paymentSources = $response['vc_message']->params['data'];

                // Formatear los datos de las fuentes de pago
                $formattedSources = [];
                foreach ($paymentSources as $source) {
                    $formattedSources[] = [
                        'id' => $source['id'],
                        'parent_id' => $source['parent_id'],
                        'name' => $source['name'],
                        'last4' => $source['last4'],
                        'card_type' => $source['card_type'],
                        'brand' => $source['brand']
                    ];
                }

                return response()->json(['b_status' => true, 'vc_message' => $formattedSources]);
            } else {
                return response()->json($response);
            }
        } else {
            return response()->json(['b_status' => false, 'vc_message' => 'No se encontraron registros.']);
        }


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
            ->select('customer_id')
            ->where('id', $id)
            ->first();

        // Valido si tiene al menos un registro
        if (!empty($result->customer_id)){
            $customer = $this->conektaService->deleteCustomer($result->customer_id);
        }

        clienteConekta::where('id', $id)->delete();
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

    public function getConektaKey()
    {
        $conektaKey = config('services.conekta.public_key');
        return response()->json(['key' => $conektaKey]);
    }

}
