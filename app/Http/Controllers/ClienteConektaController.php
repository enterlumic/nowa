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
            'name'  => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => "8187074784",
            'payment_sources' => [
                [
                    'type' => 'card',
                    'token_id' => $request->token_id
                ]
            ]
        ];

        try {
            $customer = $this->conektaService->createCustomer($customerData);
            return response()->json($customer);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if(!\Schema::hasTable('cliente_conekta')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnclienteConektaSendMail(
                    'Notificación no existe tabla clienteConekta'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla clienteConekta"));
        }

        $data=[ 'name' => isset($request->name)? $request->name:"",
                'number' => isset($request->number)? $request->number: "",
                'cvc' => isset($request->cvc)? $request->cvc: "",
                'exp_month' => isset($request->exp_month)? $request->exp_month: "",
                'exp_year' => isset($request->exp_year)? $request->exp_year: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('cliente_conekta')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('cliente_conekta')->insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
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

    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_cliente_conekta(Request $request)
    {
        if(!\Schema::hasTable('cliente_conekta')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_cliente_conekta' , 'vc_info' => "set_import_cliente_conekta" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['name'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            clienteConekta::truncate();
            clienteConekta::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
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
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_cliente_conekta(Request $request)
    {
        $path = public_path('CargandoExcel');

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if (!empty($request->file('files'))){
            $path = Storage::putFile( $path, $request->file('files') );
        }

        if (!empty($path)){
            $this->LibCore->setSkynet(['vc_evento'=> 'uploadExcelSuccess' , 'vc_info' => "<b>Subiendo Excel ok </b> ". $path ] );

            ////////////////////////////////////////
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load( Storage::path($path ) );
            $d=$spreadsheet->getSheet(0)->toArray();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // DESCOMENTAR PARA OMITIR TITULO EN EXCEL
            // $i=1;
            // unset($sheetData[0]);

            // $sheetData= array_reverse($sheetData);

            foreach ($sheetData as $key => $t) {

                $data_insert[]=  array(  "name"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"number"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"cvc"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"exp_month"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"exp_year"  =>  isset($t[4]) ? $t[4] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('cliente_conekta')->insert( $temp );
            }

            return json_encode(array("b_status"=> true, "data" => [ "vc_path" =>  Storage::url( $path )  ] ));
        }

        return json_encode(array("b_status"=> false, "data" => [ "vc_message" => 'No se adjunto algun archivo' ] ));
    }

    /*
    |--------------------------------------------------------------------------
    | Generar plantilla para descargar Excel
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function descargar_plantilla_cliente_conekta(Request $request)
    {
            $nombre_archivo= 'plantilla_cliente_conekta.xlsx';

            $title[]= [  "Name"
                        ,"Number"
                        ,"Cvc"
                        ,"Exp_Month"
                        ,"Exp_Year"
                    ];

            $arr_data= $title;

            $this->LibCore->crear_archivos( $arr_data );

            $process = new Process( [ 'python3', public_path("/")."generico.py" , $nombre_archivo  ] );

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output_data = $process->getOutput();

            return Storage::download('public/'.$nombre_archivo);       
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
    | Scroll diez en diez
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cliente_conekta_diez(Request $request)
    {
        if(!\Schema::hasTable('cliente_conekta')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("cliente_conekta")
        ->select("id", "name", "number")
        ->where("cliente_conekta.b_status", ">", 0)
        ->limit(50)
        ->orderBy("cliente_conekta.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id_cliente_conekta'=> $value->id
                                , 'name'=>$value->name
                                , 'number'=>$value->number
                );
            }

            return response()
            ->json($arr)
            ->withCallback($request->input('callback'));

        }else{
            return 1;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cliente_conekta_by_list(Request $request)
    {
        if(!\Schema::hasTable('cliente_conekta')){
            return json_encode(array("data"=>"" ));
        }

        $data= clienteConekta::select(  "id"
                                    , "name"
                                    , "number"
                                    , "cvc"
                                    , "exp_month"
                                    , "exp_year"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->name
                                , $value->number
                                , $value->cvc
                                , $value->exp_month
                                , $value->exp_year
                );
            }
            return json_encode(array("b_status"=> true, "data" => $arr ));
        }else{
            return json_encode(array("b_status"=> false, "data" => 'Sin resultado' ));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Exportar Excel
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function export_excel_cliente_conekta(Request $request){

        if(!\Schema::hasTable('cliente_conekta')){
            return json_encode(array("data"=>"" ));
        }

        $data= clienteConekta::select("id"
                                    , "name"
                                    , "number"
                                    , "cvc"
                                    , "exp_month"
                                    , "exp_year"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->name
                                    , $value->number
                                    , $value->cvc
                                    , $value->exp_month
                                    , $value->exp_year
                );
            }

            $nombre_archivo= 'Reporte_de_cliente_conekta.xlsx';

            $title[]= [  "id"
                        ,"Name"
                        ,"Number"
                        ,"Cvc"
                        ,"Exp_Month"
                        ,"Exp_Year"
                    ];

            $arr_data= array_merge($title, $arr_data);

            $this->LibCore->crear_archivos( $arr_data );

            $process = new Process( [ 'python3', public_path("/")."generico.py" , $nombre_archivo  ] );

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output_data = $process->getOutput();

            return $nombre_archivo;
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
        clienteConekta::where('id', $id)->update(['b_status' => 0]);
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
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_cliente_conekta()
    {
        clienteConekta::where('b_status', 1)->update(['b_status' => 0]);        
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
