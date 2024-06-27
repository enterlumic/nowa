<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\checkOutSendMail as FncheckOutSendMail;
use App\Services\ConektaService;
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
use App\Models\checkOut;
use App\Lib\LibCore;
use Session;

class CheckOutController extends Controller
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
    | Todo es controlado por JS check_out.js
    |
    */
    public function index(Request $request)
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_check_out' , 'vc_info' => "index - check_out" ] );

        // Recuperar los datos de la tabla productos
        $productos = DB::table('productos as p')
            ->join('promocion_fotos as pf', function ($join) {
                $join->on('pf.promocion_id', '=', 'p.id')
                     ->where('pf.size', '=', 'small')
                     ->where('pf.order', '=', 0);
            })
            ->where('p.b_status', '>', 0)
            ->orderBy('pf.order', 'asc')
            ->select('p.id', 'p.titulo', 'pf.foto_url', 'p.precio', 'p.marca')
            ->get();
        // Pasar los datos a la vista
        return view('check_out', compact('productos'));

    }

    /*
    |--------------------------------------------------------------------------
    | Agrega o modificar registro
    |--------------------------------------------------------------------------
    | 
    | Modifica el registro solo si manda el parametro '$request->id'
    | @return json
    | fn_fnCreateOrder JS
    |
    */
    public function fnCreateOrder(Request $request)
    {

        if (!isset($request->customer_id) || empty($request->customer_id)){
                return json_encode(array("b_status"=> false, "vc_message" =>'Favor de seleccionar una Tarjeta'  ));
        }

        try {
           // Crear orden
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
                    'customer_id' => $request->customer_id
                ],
                'charges' => [
                    [
                        'payment_method' => [
                            'type' => 'card',
                            'payment_source_id' => $request->card_id

                        ]
                    ]
                ]
            ];

            $order = $this->conektaService->createOrder($orderData);
            $this->LibCore->setLogs( ['event_type'=> 'fnCreateOrder' , 'context'=> 'data', 'event_data' => json_encode($orderData) ] );
            $this->LibCore->setLogs( ['event_type'=> 'fnCreateOrder' , 'context'=> 'request', 'event_data' => json_encode($order) ] );

            if ($order['b_status']){
                return json_encode(array("b_status"=> true, "vc_message" => $order['vc_message']));
            }else{
                return json_encode(array("b_status"=> false, "vc_message" => $order['vc_message']));
            }

        } catch (Exception $e) {
            return json_encode(array("b_status"=> false, "vc_message" => $e->getMessage()));
        }
        
        return json_encode(array("b_status"=> false, "vc_message" => 'Ocurrio un error'));

    }

    /*
    |--------------------------------------------------------------------------
    | Validar existencia antes de crear un nuevo registro
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function validar_existencia_check_out(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= checkOut::select('vCampo1_check_out')
            ->where('vCampo1_check_out' ,'=', trim($request->vCampo1_check_out))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= checkOut::select('vCampo1_check_out')
            ->where('vCampo1_check_out' ,'=', trim($request->vCampo1_check_out))
            ->get();
        }

        if ( $data->count() > 0 ){
            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "data" => 'sin resultados'));
        }
    }

      public function getServerSidecheck_out(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('check_out')
            ->Where('id', ' > ', 0)
            ->OrWhere('vCampo1_check_out', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", vCampo1_check_out, " ", vCampo2_check_out ) as vCampo1_check_out')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'vCampo1_check_out' =>Str::headline($item->vCampo1_check_out) ];
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
    public function get_check_out_by_id(Request $request)
    {
        $promocion = DB::table('productos')
                        ->select('fotos', 'titulo', 'descripcion', 'precio', 'marca')
                        ->where('id', $request->id)
                        ->first();

        return response()->json($promocion);
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener clientes conekta desde la bd
    |--------------------------------------------------------------------------
    | fn_customerConnekta JS
    | @return json
    |
    */
    public function fn_getCustomerConekta(Request $request)
    {
        $results = DB::table('cliente_conekta')
            ->select('id', 'user_id', 'customer_id', 'payment_source_id', 'name', 'number', 'cvc', 'card_type', 'brand', 'exp_month', 'exp_year', 'created_at', 'updated_at', 'b_status')
            ->where('user_id', Auth::user()->id)
            ->get();

        if ($results->isEmpty()) {
            return false;
        }

        $logos = config('logos');

        $results->transform(function($item) use ($logos) {
            $item->logo_url = $logos[strtolower($item->brand)] ?? $logos['default'];
            return $item;
        });

        return $results;
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar registro por id
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function delete_check_out(Request $request)
    {
        $id=$request->id;
        checkOut::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_check_out(Request $request)
    {
        $id=$request->id;
        checkOut::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_check_out()
    {
        checkOut::where('b_status', 1)->update(['b_status' => 0]);        
    }

    public function processPayment(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'card_id' => 'required|exists:cliente_conekta,id',
        ]);

        try {
            // Obtener la tarjeta seleccionada utilizando el Query Builder
            $card = DB::table('cliente_conekta')
                        ->select('id', 'user_id', 'customer_id', 'payment_source_id')
                        ->where('id', $request->card_id)
                        ->first();

            if (!$card) {
                return response()->json(['success' => false, 'message' => 'Tarjeta no encontrada.'], 404);
            }

            // Aquí deberías implementar la lógica para procesar el pago con la tarjeta seleccionada.
            // Esta es solo una demostración simplificada.
            // Llama a tu servicio de pago o lógica de negocio aquí.

            // Simulación de éxito de pago
            $paymentSuccess = true;

            if ($paymentSuccess) {

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
                        'customer_id' => $card->customer_id
                    ],
                    'charges' => [
                        [
                            'payment_method' => [
                                'type' => 'card',
                                'payment_source_id' => $card->payment_source_id

                            ]
                        ]
                    ]
                ];

                $order = $this->conektaService->createOrder($orderData);

                return response()->json(['success' => true, 'message' => 'Pago procesado con éxito.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Error al procesar el pago.'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al procesar el pago.'], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Compra completaado
    |--------------------------------------------------------------------------
    |
    */
    public function completado()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_check_out' , 'vc_info' => "index - check_out" ] );

        // Pasar los datos a la vista
        return view('completado');

    }
}
