<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\logssSendMail as FnlogssSendMail;
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
use App\Models\logss;
use App\Lib\LibCore;
use Session;

class LogssController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    | Auth::user()->email;
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
    | Todo es controlado por JS logss.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_logss' , 'vc_info' => "index - logss" ] );
        return view('logss');
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_logss_datatable(Request $request)
    {
        if(!\Schema::hasTable('logss')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_user_id) && !empty($request->buscar_user_id) )
            || ( isset($request->buscar_event_type) && !empty($request->buscar_event_type) )
            || ( isset($request->buscar_context) && !empty($request->buscar_context) )
            || ( isset($request->buscar_event_data) && !empty($request->buscar_event_data) )
            || ( isset($request->buscar_execution_time) && !empty($request->buscar_execution_time) )
            || ( isset($request->buscar_status) && !empty($request->buscar_status) )
            || ( isset($request->buscar_severity) && !empty($request->buscar_severity) )
            || ( isset($request->buscar_source) && !empty($request->buscar_source) )
            || ( isset($request->buscar_ip_address) && !empty($request->buscar_ip_address) )
            || ( isset($request->buscar_user_agent) && !empty($request->buscar_user_agent) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_user_id= isset($request->buscar_user_id) ? $request->buscar_user_id :'';
        $buscar_event_type= isset($request->buscar_event_type) ? $request->buscar_event_type :'';
        $buscar_context= isset($request->buscar_context) ? $request->buscar_context :'';
        $buscar_event_data= isset($request->buscar_event_data) ? $request->buscar_event_data :'';
        $buscar_execution_time= isset($request->buscar_execution_time) ? $request->buscar_execution_time :'';
        $buscar_status= isset($request->buscar_status) ? $request->buscar_status :'';
        $buscar_severity= isset($request->buscar_severity) ? $request->buscar_severity :'';
        $buscar_source= isset($request->buscar_source) ? $request->buscar_source :'';
        $buscar_ip_address= isset($request->buscar_ip_address) ? $request->buscar_ip_address :'';
        $buscar_user_agent= isset($request->buscar_user_agent) ? $request->buscar_user_agent :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_logss(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_user_id.'"
            , "'.$buscar_event_type.'"
            , "'.$buscar_context.'"
            , "'.$buscar_event_data.'"
            , "'.$buscar_execution_time.'"
            , "'.$buscar_status.'"
            , "'.$buscar_severity.'"
            , "'.$buscar_source.'"
            , "'.$buscar_ip_address.'"
            , "'.$buscar_user_agent.'"
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
    public function set_logss(Request $request)
    {
        if(!\Schema::hasTable('logss')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnlogssSendMail(
                    'Notificación no existe tabla logss'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla logss"));
        }

        $data=[ 'user_id' => isset($request->user_id)? $request->user_id:"",
                'event_type' => isset($request->event_type)? $request->event_type: "",
                'context' => isset($request->context)? $request->context: "",
                'event_data' => isset($request->event_data)? $request->event_data: "",
                'execution_time' => isset($request->execution_time)? $request->execution_time: "",
                'status' => isset($request->status)? $request->status: "",
                'severity' => isset($request->severity)? $request->severity: "",
                'source' => isset($request->source)? $request->source: "",
                'ip_address' => isset($request->ip_address)? $request->ip_address: "",
                'user_agent' => isset($request->user_agent)? $request->user_agent: "",
                'description' => isset($request->description)? $request->description: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('logss')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('logss')->insert($data);
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
    public function validar_existencia_logss(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= logss::select('user_id')
            ->where('user_id' ,'=', trim($request->user_id))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= logss::select('user_id')
            ->where('user_id' ,'=', trim($request->user_id))
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
    public function set_import_logss(Request $request)
    {
        if(!\Schema::hasTable('logss')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_logss' , 'vc_info' => "set_import_logss" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['user_id'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            logss::truncate();
            logss::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSidelogss(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('logss')
            ->Where('id', ' > ', 0)
            ->OrWhere('user_id', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", user_id, " ", event_type ) as user_id')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'user_id' =>Str::headline($item->user_id) ];
        });

        return response()->json($options);
    } 

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_logss(Request $request)
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

                $data_insert[]=  array(  "user_id"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"event_type"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"context"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"event_data"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"execution_time"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"status"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"severity"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"source"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"ip_address"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"user_agent"  =>  isset($t[9]) ? $t[9] : ''
                                        ,"description"  =>  isset($t[10]) ? $t[10] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('logss')->insert( $temp );
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
    public function descargar_plantilla_logss(Request $request)
    {
            $nombre_archivo= 'plantilla_logss.xlsx';

            $title[]= [  "User_Id"
                        ,"Event_Type"
                        ,"Context"
                        ,"Event_Data"
                        ,"execution_time"
                        ,"Status"
                        ,"Severity"
                        ,"Source"
                        ,"Ip_Address"
                        ,"User_Agent"
                        ,"Description"
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
    public function get_logss_by_id(Request $request)
    {
        $data= logss::select('user_id'
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
    public function get_cat_logss(Request $request)
    {
        $data= logss::select(  'id'
                                    , 'user_id'
                                    , 'event_type'
                                    , 'context'
                                    , 'event_data'
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
    public function get_logss_diez(Request $request)
    {
        if(!\Schema::hasTable('logss')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("logss")
        ->select("id"
            , "user_id"
            , "event_type"
            , "context"
            , "event_data"
            , "execution_time"
            , "status"
            , "severity"
        )
        ->where("logss.b_status", ">", 0)
        ->limit(50)
        ->orderBy("logss.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'user_id'=>$value->user_id
                                , 'event_type'=>$value->event_type
                                , 'context'=>$value->context
                                , 'event_data'=>$value->event_data
                                , 'execution_time'=>$value->execution_time
                                , 'status'=>$value->status
                                , 'severity'=>$value->severity
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
    public function get_logss_by_list(Request $request)
    {
        if(!\Schema::hasTable('logss')){
            return json_encode(array("data"=>"" ));
        }

        $data= logss::select(  "id"
                                    , "user_id"
                                    , "event_type"
                                    , "context"
                                    , "event_data"
                                    , "execution_time"
                                    , "status"
                                    , "severity"
                                    , "source"
                                    , "ip_address"
                                    , "user_agent"
                                    , 'description'
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->user_id
                                , $value->event_type
                                , $value->context
                                , $value->event_data
                                , $value->execution_time
                                , $value->status
                                , $value->severity
                                , $value->source
                                , $value->ip_address
                                , $value->user_agent
                                , $value->description
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
    public function export_excel_logss(Request $request){

        if(!\Schema::hasTable('logss')){
            return json_encode(array("data"=>"" ));
        }

        $data= logss::select("id"
                                    , "user_id"
                                    , "event_type"
                                    , "context"
                                    , "event_data"
                                    , "execution_time"
                                    , "status"
                                    , "severity"
                                    , "source"
                                    , "ip_address"
                                    , "user_agent"
                                    , 'description'
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->user_id
                                    , $value->event_type
                                    , $value->context
                                    , $value->event_data
                                    , $value->execution_time
                                    , $value->status
                                    , $value->severity
                                    , $value->source
                                    , $value->ip_address
                                    , $value->user_agent
                                    , $value->description
                );
            }

            $nombre_archivo= 'Reporte_de_logss.xlsx';

            $title[]= [  "id"
                        ,"User_Id"
                        ,"Event_Type"
                        ,"Context"
                        ,"Event_Data"
                        ,"execution_time"
                        ,"Status"
                        ,"Severity"
                        ,"Source"
                        ,"Ip_Address"
                        ,"User_Agent"
                        ,"Description"
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
    public function delete_logss(Request $request)
    {
        $id=$request->id;
        logss::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_logss(Request $request)
    {
        $id=$request->id;
        logss::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_logss()
    {
        logss::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_logss()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_logss` ');
    }
}
