<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\promocionesSendMail as FnpromocionesSendMail;
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
use App\Models\promociones;
use App\Lib\LibCore;
use Session;

class PromocionesController extends Controller
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
    | Todo es controlado por JS promociones.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_promociones' , 'vc_info' => "index - promociones" ] );
        return view('promociones');
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_promociones_datatable(Request $request)
    {
        if(!\Schema::hasTable('promociones')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_vCampo1_promociones) && !empty($request->buscar_vCampo1_promociones) )
            || ( isset($request->buscar_vCampo2_promociones) && !empty($request->buscar_vCampo2_promociones) )
            || ( isset($request->buscar_vCampo3_promociones) && !empty($request->buscar_vCampo3_promociones) )
            || ( isset($request->buscar_vCampo4_promociones) && !empty($request->buscar_vCampo4_promociones) )
            || ( isset($request->buscar_vCampo5_promociones) && !empty($request->buscar_vCampo5_promociones) )
            || ( isset($request->buscar_vCampo6_promociones) && !empty($request->buscar_vCampo6_promociones) )
            || ( isset($request->buscar_vCampo7_promociones) && !empty($request->buscar_vCampo7_promociones) )
            || ( isset($request->buscar_vCampo8_promociones) && !empty($request->buscar_vCampo8_promociones) )
            || ( isset($request->buscar_vCampo9_promociones) && !empty($request->buscar_vCampo9_promociones) )
            || ( isset($request->buscar_vCampo10_promociones) && !empty($request->buscar_vCampo10_promociones) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_vCampo1_promociones= isset($request->buscar_vCampo1_promociones) ? $request->buscar_vCampo1_promociones :'';
        $buscar_vCampo2_promociones= isset($request->buscar_vCampo2_promociones) ? $request->buscar_vCampo2_promociones :'';
        $buscar_vCampo3_promociones= isset($request->buscar_vCampo3_promociones) ? $request->buscar_vCampo3_promociones :'';
        $buscar_vCampo4_promociones= isset($request->buscar_vCampo4_promociones) ? $request->buscar_vCampo4_promociones :'';
        $buscar_vCampo5_promociones= isset($request->buscar_vCampo5_promociones) ? $request->buscar_vCampo5_promociones :'';
        $buscar_vCampo6_promociones= isset($request->buscar_vCampo6_promociones) ? $request->buscar_vCampo6_promociones :'';
        $buscar_vCampo7_promociones= isset($request->buscar_vCampo7_promociones) ? $request->buscar_vCampo7_promociones :'';
        $buscar_vCampo8_promociones= isset($request->buscar_vCampo8_promociones) ? $request->buscar_vCampo8_promociones :'';
        $buscar_vCampo9_promociones= isset($request->buscar_vCampo9_promociones) ? $request->buscar_vCampo9_promociones :'';
        $buscar_vCampo10_promociones= isset($request->buscar_vCampo10_promociones) ? $request->buscar_vCampo10_promociones :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_promociones(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_vCampo1_promociones.'"
            , "'.$buscar_vCampo2_promociones.'"
            , "'.$buscar_vCampo3_promociones.'"
            , "'.$buscar_vCampo4_promociones.'"
            , "'.$buscar_vCampo5_promociones.'"
            , "'.$buscar_vCampo6_promociones.'"
            , "'.$buscar_vCampo7_promociones.'"
            , "'.$buscar_vCampo8_promociones.'"
            , "'.$buscar_vCampo9_promociones.'"
            , "'.$buscar_vCampo10_promociones.'"
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
    public function set_promociones(Request $request)
    {
        if(!\Schema::hasTable('promociones')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnpromocionesSendMail(
                    'Notificación no existe tabla promociones'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla promociones"));
        }

        $data=[ 'vCampo1_promociones' => isset($request->vCampo1_promociones)? $request->vCampo1_promociones:"",
                'vCampo2_promociones' => isset($request->vCampo2_promociones)? $request->vCampo2_promociones: "",
                'vCampo3_promociones' => isset($request->vCampo3_promociones)? $request->vCampo3_promociones: "",
                'vCampo4_promociones' => isset($request->vCampo4_promociones)? $request->vCampo4_promociones: "",
                'vCampo5_promociones' => isset($request->vCampo5_promociones)? $request->vCampo5_promociones: "",
                'vCampo6_promociones' => isset($request->vCampo6_promociones)? $request->vCampo6_promociones: "",
                'vCampo7_promociones' => isset($request->vCampo7_promociones)? $request->vCampo7_promociones: "",
                'vCampo8_promociones' => isset($request->vCampo8_promociones)? $request->vCampo8_promociones: "",
                'vCampo9_promociones' => isset($request->vCampo9_promociones)? $request->vCampo9_promociones: "",
                'vCampo10_promociones' => isset($request->vCampo10_promociones)? $request->vCampo10_promociones: "",
                'vCampo11_promociones' => isset($request->vCampo11_promociones)? $request->vCampo11_promociones: "",
                'vCampo12_promociones' => isset($request->vCampo12_promociones)? $request->vCampo12_promociones: "",
                'vCampo13_promociones' => isset($request->vCampo13_promociones)? $request->vCampo13_promociones: "",
                'vCampo14_promociones' => isset($request->vCampo14_promociones)? $request->vCampo14_promociones: "",
                'vCampo15_promociones' => isset($request->vCampo15_promociones)? $request->vCampo15_promociones: "",
                'vCampo16_promociones' => isset($request->vCampo16_promociones)? $request->vCampo16_promociones: "",
                'vCampo17_promociones' => isset($request->vCampo17_promociones)? $request->vCampo17_promociones: "",
                'vCampo18_promociones' => isset($request->vCampo18_promociones)? $request->vCampo18_promociones: "",
                'vCampo19_promociones' => isset($request->vCampo19_promociones)? $request->vCampo19_promociones: "",
                'vCampo20_promociones' => isset($request->vCampo20_promociones)? $request->vCampo20_promociones: "",
                'vCampo21_promociones' => isset($request->vCampo21_promociones)? $request->vCampo21_promociones: "",
                'vCampo22_promociones' => isset($request->vCampo22_promociones)? $request->vCampo22_promociones: "",
                'vCampo23_promociones' => isset($request->vCampo23_promociones)? $request->vCampo23_promociones: "",
                'vCampo24_promociones' => isset($request->vCampo24_promociones)? $request->vCampo24_promociones: "",
                'vCampo25_promociones' => isset($request->vCampo25_promociones)? $request->vCampo25_promociones: "",
                'vCampo26_promociones' => isset($request->vCampo26_promociones)? $request->vCampo26_promociones: "",
                'vCampo27_promociones' => isset($request->vCampo27_promociones)? $request->vCampo27_promociones: "",
                'vCampo28_promociones' => isset($request->vCampo28_promociones)? $request->vCampo28_promociones: "",
                'vCampo29_promociones' => isset($request->vCampo29_promociones)? $request->vCampo29_promociones: "",
                'vCampo30_promociones' => isset($request->vCampo30_promociones)? $request->vCampo30_promociones: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('promociones')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('promociones')->insert($data);
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
    public function validar_existencia_promociones(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= promociones::select('vCampo1_promociones')
            ->where('vCampo1_promociones' ,'=', trim($request->vCampo1_promociones))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= promociones::select('vCampo1_promociones')
            ->where('vCampo1_promociones' ,'=', trim($request->vCampo1_promociones))
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
    public function set_import_promociones(Request $request)
    {
        if(!\Schema::hasTable('promociones')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_promociones' , 'vc_info' => "set_import_promociones" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['vCampo1_promociones'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            promociones::truncate();
            promociones::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSidepromociones(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('promociones')
            ->Where('id', ' > ', 0)
            ->OrWhere('vCampo1_promociones', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", vCampo1_promociones, " ", vCampo2_promociones ) as vCampo1_promociones')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'vCampo1_promociones' =>Str::headline($item->vCampo1_promociones) ];
        });

        return response()->json($options);
    } 

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_promociones(Request $request)
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

                $data_insert[]=  array(  "vCampo1_promociones"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"vCampo2_promociones"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"vCampo3_promociones"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"vCampo4_promociones"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"vCampo5_promociones"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"vCampo6_promociones"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"vCampo7_promociones"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"vCampo8_promociones"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"vCampo9_promociones"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"vCampo10_promociones"  =>  isset($t[9]) ? $t[9] : ''
                                        ,"vCampo11_promociones"  =>  isset($t[10]) ? $t[10] : ''
                                        ,"vCampo12_promociones"  =>  isset($t[11]) ? $t[11] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('promociones')->insert( $temp );
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
    public function descargar_plantilla_promociones(Request $request)
    {
            $nombre_archivo= 'plantilla_promociones.xlsx';

            $title[]= [  "vTema1_promociones"
                        ,"vTema2_promociones"
                        ,"vTema3_promociones"
                        ,"vTema4_promociones"
                        ,"vTema5_promociones"
                        ,"vTema6_promociones"
                        ,"vTema7_promociones"
                        ,"vTema8_promociones"
                        ,"vTema9_promociones"
                        ,"vTema10_promociones"
                        ,"vTema11_promociones"
                        ,"vTema12_promociones"
                        ,"vTema13_promociones"
                        ,"vTema14_promociones"
                        ,"vTema15_promociones"
                        ,"vTema16_promociones"
                        ,"vTema17_promociones"
                        ,"vTema18_promociones"
                        ,"vTema19_promociones"
                        ,"vTema20_promociones"
                        ,"vTema21_promociones"
                        ,"vTema22_promociones"
                        ,"vTema23_promociones"
                        ,"vTema24_promociones"
                        ,"vTema25_promociones"
                        ,"vTema26_promociones"
                        ,"vTema27_promociones"
                        ,"vTema28_promociones"
                        ,"vTema29_promociones"
                        ,"vTema30_promociones"
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
    public function get_promociones_by_id(Request $request)
    {
        $data= promociones::select('vCampo1_promociones'
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
    public function get_cat_promociones(Request $request)
    {
        $data= promociones::select(  'id'
                                    , 'vCampo1_promociones'
                                    , 'vCampo2_promociones'
                                    , 'vCampo3_promociones'
                                    , 'vCampo4_promociones'
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
    public function get_promociones_diez(Request $request)
    {
        if(!\Schema::hasTable('promociones')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("promociones")
        ->select("id", "vCampo1_promociones", "vCampo2_promociones")
        ->where("promociones.b_status", ">", 0)
        ->limit(50)
        ->orderBy("promociones.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id_promociones'=> $value->id
                                , 'vCampo1_promociones'=>$value->vCampo1_promociones
                                , 'vCampo2_promociones'=>$value->vCampo2_promociones
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
    public function get_promociones_by_list(Request $request)
    {
        if(!\Schema::hasTable('promociones')){
            return json_encode(array("data"=>"" ));
        }

        $data= promociones::select(  "id"
                                    , "vCampo1_promociones"
                                    , "vCampo2_promociones"
                                    , "vCampo3_promociones"
                                    , "vCampo4_promociones"
                                    , "vCampo5_promociones"
                                    , "vCampo6_promociones"
                                    , "vCampo7_promociones"
                                    , "vCampo8_promociones"
                                    , "vCampo9_promociones"
                                    , "vCampo10_promociones"
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
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->vCampo1_promociones
                                , $value->vCampo2_promociones
                                , $value->vCampo3_promociones
                                , $value->vCampo4_promociones
                                , $value->vCampo5_promociones
                                , $value->vCampo6_promociones
                                , $value->vCampo7_promociones
                                , $value->vCampo8_promociones
                                , $value->vCampo9_promociones
                                , $value->vCampo10_promociones
                                , $value->vCampo11_promociones
                                , $value->vCampo12_promociones
                                , $value->vCampo13_promociones
                                , $value->vCampo14_promociones
                                , $value->vCampo15_promociones
                                , $value->vCampo16_promociones
                                , $value->vCampo17_promociones
                                , $value->vCampo18_promociones
                                , $value->vCampo19_promociones
                                , $value->vCampo20_promociones
                                , $value->vCampo21_promociones
                                , $value->vCampo22_promociones
                                , $value->vCampo23_promociones
                                , $value->vCampo24_promociones
                                , $value->vCampo25_promociones
                                , $value->vCampo26_promociones
                                , $value->vCampo27_promociones
                                , $value->vCampo28_promociones
                                , $value->vCampo29_promociones
                                , $value->vCampo30_promociones
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
    public function export_excel_promociones(Request $request){

        if(!\Schema::hasTable('promociones')){
            return json_encode(array("data"=>"" ));
        }

        $data= promociones::select("id"
                                    , "vCampo1_promociones"
                                    , "vCampo2_promociones"
                                    , "vCampo3_promociones"
                                    , "vCampo4_promociones"
                                    , "vCampo5_promociones"
                                    , "vCampo6_promociones"
                                    , "vCampo7_promociones"
                                    , "vCampo8_promociones"
                                    , "vCampo9_promociones"
                                    , "vCampo10_promociones"
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
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->vCampo1_promociones
                                    , $value->vCampo2_promociones
                                    , $value->vCampo3_promociones
                                    , $value->vCampo4_promociones
                                    , $value->vCampo5_promociones
                                    , $value->vCampo6_promociones
                                    , $value->vCampo7_promociones
                                    , $value->vCampo8_promociones
                                    , $value->vCampo9_promociones
                                    , $value->vCampo10_promociones
                                    , $value->vCampo11_promociones
                                    , $value->vCampo12_promociones
                                    , $value->vCampo13_promociones
                                    , $value->vCampo14_promociones
                                    , $value->vCampo15_promociones
                                    , $value->vCampo16_promociones
                                    , $value->vCampo17_promociones
                                    , $value->vCampo18_promociones
                                    , $value->vCampo19_promociones
                                    , $value->vCampo20_promociones
                                    , $value->vCampo21_promociones
                                    , $value->vCampo22_promociones
                                    , $value->vCampo23_promociones
                                    , $value->vCampo24_promociones
                                    , $value->vCampo25_promociones
                                    , $value->vCampo26_promociones
                                    , $value->vCampo27_promociones
                                    , $value->vCampo28_promociones
                                    , $value->vCampo29_promociones
                                    , $value->vCampo30_promociones
                );
            }

            $nombre_archivo= 'Reporte_de_promociones.xlsx';

            $title[]= [  "id"
                        ,"vTema1_promociones"
                        ,"vTema2_promociones"
                        ,"vTema3_promociones"
                        ,"vTema4_promociones"
                        ,"vTema5_promociones"
                        ,"vTema6_promociones"
                        ,"vTema7_promociones"
                        ,"vTema8_promociones"
                        ,"vTema9_promociones"
                        ,"vTema10_promociones"
                        ,"vTema11_promociones"
                        ,"vTema12_promociones"
                        ,"vTema13_promociones"
                        ,"vTema14_promociones"
                        ,"vTema15_promociones"
                        ,"vTema16_promociones"
                        ,"vTema17_promociones"
                        ,"vTema18_promociones"
                        ,"vTema19_promociones"
                        ,"vTema20_promociones"
                        ,"vTema21_promociones"
                        ,"vTema22_promociones"
                        ,"vTema23_promociones"
                        ,"vTema24_promociones"
                        ,"vTema25_promociones"
                        ,"vTema26_promociones"
                        ,"vTema27_promociones"
                        ,"vTema28_promociones"
                        ,"vTema29_promociones"
                        ,"vTema30_promociones"
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
    public function delete_promociones(Request $request)
    {
        $id=$request->id;
        promociones::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_promociones(Request $request)
    {
        $id=$request->id;
        promociones::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_promociones()
    {
        promociones::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_promociones()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_promociones` ');
    }
}
