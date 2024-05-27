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
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_check_out' , 'vc_info' => "index - check_out" ] );

        $savedCards = DB::table('cliente_conekta')->where('user_id', Auth::user()->id)->get();

        // Pasar los datos a la vista
        return view('check_out', compact('savedCards'));
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_check_out_datatable(Request $request)
    {
        if(!\Schema::hasTable('check_out')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_vCampo1_check_out) && !empty($request->buscar_vCampo1_check_out) )
            || ( isset($request->buscar_vCampo2_check_out) && !empty($request->buscar_vCampo2_check_out) )
            || ( isset($request->buscar_vCampo3_check_out) && !empty($request->buscar_vCampo3_check_out) )
            || ( isset($request->buscar_vCampo4_check_out) && !empty($request->buscar_vCampo4_check_out) )
            || ( isset($request->buscar_vCampo5_check_out) && !empty($request->buscar_vCampo5_check_out) )
            || ( isset($request->buscar_vCampo6_check_out) && !empty($request->buscar_vCampo6_check_out) )
            || ( isset($request->buscar_vCampo7_check_out) && !empty($request->buscar_vCampo7_check_out) )
            || ( isset($request->buscar_vCampo8_check_out) && !empty($request->buscar_vCampo8_check_out) )
            || ( isset($request->buscar_vCampo9_check_out) && !empty($request->buscar_vCampo9_check_out) )
            || ( isset($request->buscar_vCampo10_check_out) && !empty($request->buscar_vCampo10_check_out) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_vCampo1_check_out= isset($request->buscar_vCampo1_check_out) ? $request->buscar_vCampo1_check_out :'';
        $buscar_vCampo2_check_out= isset($request->buscar_vCampo2_check_out) ? $request->buscar_vCampo2_check_out :'';
        $buscar_vCampo3_check_out= isset($request->buscar_vCampo3_check_out) ? $request->buscar_vCampo3_check_out :'';
        $buscar_vCampo4_check_out= isset($request->buscar_vCampo4_check_out) ? $request->buscar_vCampo4_check_out :'';
        $buscar_vCampo5_check_out= isset($request->buscar_vCampo5_check_out) ? $request->buscar_vCampo5_check_out :'';
        $buscar_vCampo6_check_out= isset($request->buscar_vCampo6_check_out) ? $request->buscar_vCampo6_check_out :'';
        $buscar_vCampo7_check_out= isset($request->buscar_vCampo7_check_out) ? $request->buscar_vCampo7_check_out :'';
        $buscar_vCampo8_check_out= isset($request->buscar_vCampo8_check_out) ? $request->buscar_vCampo8_check_out :'';
        $buscar_vCampo9_check_out= isset($request->buscar_vCampo9_check_out) ? $request->buscar_vCampo9_check_out :'';
        $buscar_vCampo10_check_out= isset($request->buscar_vCampo10_check_out) ? $request->buscar_vCampo10_check_out :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_check_out(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_vCampo1_check_out.'"
            , "'.$buscar_vCampo2_check_out.'"
            , "'.$buscar_vCampo3_check_out.'"
            , "'.$buscar_vCampo4_check_out.'"
            , "'.$buscar_vCampo5_check_out.'"
            , "'.$buscar_vCampo6_check_out.'"
            , "'.$buscar_vCampo7_check_out.'"
            , "'.$buscar_vCampo8_check_out.'"
            , "'.$buscar_vCampo9_check_out.'"
            , "'.$buscar_vCampo10_check_out.'"
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
    public function set_check_out(Request $request)
    {
        if(!\Schema::hasTable('check_out')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FncheckOutSendMail(
                    'Notificación no existe tabla checkOut'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla checkOut"));
        }

        $data=[ 'vCampo1_check_out' => isset($request->vCampo1_check_out)? $request->vCampo1_check_out:"",
                'vCampo2_check_out' => isset($request->vCampo2_check_out)? $request->vCampo2_check_out: "",
                'vCampo3_check_out' => isset($request->vCampo3_check_out)? $request->vCampo3_check_out: "",
                'vCampo4_check_out' => isset($request->vCampo4_check_out)? $request->vCampo4_check_out: "",
                'vCampo5_check_out' => isset($request->vCampo5_check_out)? $request->vCampo5_check_out: "",
                'vCampo6_check_out' => isset($request->vCampo6_check_out)? $request->vCampo6_check_out: "",
                'vCampo7_check_out' => isset($request->vCampo7_check_out)? $request->vCampo7_check_out: "",
                'vCampo8_check_out' => isset($request->vCampo8_check_out)? $request->vCampo8_check_out: "",
                'vCampo9_check_out' => isset($request->vCampo9_check_out)? $request->vCampo9_check_out: "",
                'vCampo10_check_out' => isset($request->vCampo10_check_out)? $request->vCampo10_check_out: "",
                'vCampo11_check_out' => isset($request->vCampo11_check_out)? $request->vCampo11_check_out: "",
                'vCampo12_check_out' => isset($request->vCampo12_check_out)? $request->vCampo12_check_out: "",
                'vCampo13_check_out' => isset($request->vCampo13_check_out)? $request->vCampo13_check_out: "",
                'vCampo14_check_out' => isset($request->vCampo14_check_out)? $request->vCampo14_check_out: "",
                'vCampo15_check_out' => isset($request->vCampo15_check_out)? $request->vCampo15_check_out: "",
                'vCampo16_check_out' => isset($request->vCampo16_check_out)? $request->vCampo16_check_out: "",
                'vCampo17_check_out' => isset($request->vCampo17_check_out)? $request->vCampo17_check_out: "",
                'vCampo18_check_out' => isset($request->vCampo18_check_out)? $request->vCampo18_check_out: "",
                'vCampo19_check_out' => isset($request->vCampo19_check_out)? $request->vCampo19_check_out: "",
                'vCampo20_check_out' => isset($request->vCampo20_check_out)? $request->vCampo20_check_out: "",
                'vCampo21_check_out' => isset($request->vCampo21_check_out)? $request->vCampo21_check_out: "",
                'vCampo22_check_out' => isset($request->vCampo22_check_out)? $request->vCampo22_check_out: "",
                'vCampo23_check_out' => isset($request->vCampo23_check_out)? $request->vCampo23_check_out: "",
                'vCampo24_check_out' => isset($request->vCampo24_check_out)? $request->vCampo24_check_out: "",
                'vCampo25_check_out' => isset($request->vCampo25_check_out)? $request->vCampo25_check_out: "",
                'vCampo26_check_out' => isset($request->vCampo26_check_out)? $request->vCampo26_check_out: "",
                'vCampo27_check_out' => isset($request->vCampo27_check_out)? $request->vCampo27_check_out: "",
                'vCampo28_check_out' => isset($request->vCampo28_check_out)? $request->vCampo28_check_out: "",
                'vCampo29_check_out' => isset($request->vCampo29_check_out)? $request->vCampo29_check_out: "",
                'vCampo30_check_out' => isset($request->vCampo30_check_out)? $request->vCampo30_check_out: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('check_out')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('check_out')->insert($data);
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

    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_check_out(Request $request)
    {
        if(!\Schema::hasTable('check_out')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_check_out' , 'vc_info' => "set_import_check_out" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['vCampo1_check_out'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            checkOut::truncate();
            checkOut::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
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
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_check_out(Request $request)
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

                $data_insert[]=  array(  "vCampo1_check_out"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"vCampo2_check_out"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"vCampo3_check_out"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"vCampo4_check_out"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"vCampo5_check_out"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"vCampo6_check_out"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"vCampo7_check_out"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"vCampo8_check_out"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"vCampo9_check_out"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"vCampo10_check_out"  =>  isset($t[9]) ? $t[9] : ''
                                        ,"vCampo11_check_out"  =>  isset($t[10]) ? $t[10] : ''
                                        ,"vCampo12_check_out"  =>  isset($t[11]) ? $t[11] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('check_out')->insert( $temp );
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
    public function descargar_plantilla_check_out(Request $request)
    {
            $nombre_archivo= 'plantilla_check_out.xlsx';

            $title[]= [  "vTema1_check_out"
                        ,"vTema2_check_out"
                        ,"vTema3_check_out"
                        ,"vTema4_check_out"
                        ,"vTema5_check_out"
                        ,"vTema6_check_out"
                        ,"vTema7_check_out"
                        ,"vTema8_check_out"
                        ,"vTema9_check_out"
                        ,"vTema10_check_out"
                        ,"vTema11_check_out"
                        ,"vTema12_check_out"
                        ,"vTema13_check_out"
                        ,"vTema14_check_out"
                        ,"vTema15_check_out"
                        ,"vTema16_check_out"
                        ,"vTema17_check_out"
                        ,"vTema18_check_out"
                        ,"vTema19_check_out"
                        ,"vTema20_check_out"
                        ,"vTema21_check_out"
                        ,"vTema22_check_out"
                        ,"vTema23_check_out"
                        ,"vTema24_check_out"
                        ,"vTema25_check_out"
                        ,"vTema26_check_out"
                        ,"vTema27_check_out"
                        ,"vTema28_check_out"
                        ,"vTema29_check_out"
                        ,"vTema30_check_out"
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
    public function get_check_out_by_id(Request $request)
    {
        $promocion = DB::table('promociones')
                        ->select('fotos', 'titulo', 'descripcion', 'precio', 'marca')
                        ->where('id', $request->id)
                        ->first();

        return response()->json($promocion);
    }

    /*
    |--------------------------------------------------------------------------
    | Solo se usa para mostrar en una lista <select> ---- </select>
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cat_check_out(Request $request)
    {
        $data= checkOut::select(  'id'
                                    , 'vCampo1_check_out'
                                    , 'vCampo2_check_out'
                                    , 'vCampo3_check_out'
                                    , 'vCampo4_check_out'
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
    public function get_check_out_diez(Request $request)
    {
        if(!\Schema::hasTable('check_out')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("check_out")
        ->select("id"
            , "vCampo1_check_out"
            , "vCampo2_check_out"
            , "vCampo3_check_out"
            , "vCampo4_check_out"
            , "vCampo5_check_out"
            , "vCampo6_check_out"
            , "vCampo7_check_out"
        )
        ->where("check_out.b_status", ">", 0)
        ->limit(50)
        ->orderBy("check_out.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'vCampo1_check_out'=>$value->vCampo1_check_out
                                , 'vCampo2_check_out'=>$value->vCampo2_check_out
                                , 'vCampo3_check_out'=>$value->vCampo3_check_out
                                , 'vCampo4_check_out'=>$value->vCampo4_check_out
                                , 'vCampo5_check_out'=>$value->vCampo5_check_out
                                , 'vCampo6_check_out'=>$value->vCampo6_check_out
                                , 'vCampo7_check_out'=>$value->vCampo7_check_out
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
    public function get_check_out_by_list(Request $request)
    {
        if(!\Schema::hasTable('check_out')){
            return json_encode(array("data"=>"" ));
        }

        $data= checkOut::select(  "id"
                                    , "vCampo1_check_out"
                                    , "vCampo2_check_out"
                                    , "vCampo3_check_out"
                                    , "vCampo4_check_out"
                                    , "vCampo5_check_out"
                                    , "vCampo6_check_out"
                                    , "vCampo7_check_out"
                                    , "vCampo8_check_out"
                                    , "vCampo9_check_out"
                                    , "vCampo10_check_out"
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
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->vCampo1_check_out
                                , $value->vCampo2_check_out
                                , $value->vCampo3_check_out
                                , $value->vCampo4_check_out
                                , $value->vCampo5_check_out
                                , $value->vCampo6_check_out
                                , $value->vCampo7_check_out
                                , $value->vCampo8_check_out
                                , $value->vCampo9_check_out
                                , $value->vCampo10_check_out
                                , $value->vCampo11_check_out
                                , $value->vCampo12_check_out
                                , $value->vCampo13_check_out
                                , $value->vCampo14_check_out
                                , $value->vCampo15_check_out
                                , $value->vCampo16_check_out
                                , $value->vCampo17_check_out
                                , $value->vCampo18_check_out
                                , $value->vCampo19_check_out
                                , $value->vCampo20_check_out
                                , $value->vCampo21_check_out
                                , $value->vCampo22_check_out
                                , $value->vCampo23_check_out
                                , $value->vCampo24_check_out
                                , $value->vCampo25_check_out
                                , $value->vCampo26_check_out
                                , $value->vCampo27_check_out
                                , $value->vCampo28_check_out
                                , $value->vCampo29_check_out
                                , $value->vCampo30_check_out
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
    public function export_excel_check_out(Request $request){

        if(!\Schema::hasTable('check_out')){
            return json_encode(array("data"=>"" ));
        }

        $data= checkOut::select("id"
                                    , "vCampo1_check_out"
                                    , "vCampo2_check_out"
                                    , "vCampo3_check_out"
                                    , "vCampo4_check_out"
                                    , "vCampo5_check_out"
                                    , "vCampo6_check_out"
                                    , "vCampo7_check_out"
                                    , "vCampo8_check_out"
                                    , "vCampo9_check_out"
                                    , "vCampo10_check_out"
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
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->vCampo1_check_out
                                    , $value->vCampo2_check_out
                                    , $value->vCampo3_check_out
                                    , $value->vCampo4_check_out
                                    , $value->vCampo5_check_out
                                    , $value->vCampo6_check_out
                                    , $value->vCampo7_check_out
                                    , $value->vCampo8_check_out
                                    , $value->vCampo9_check_out
                                    , $value->vCampo10_check_out
                                    , $value->vCampo11_check_out
                                    , $value->vCampo12_check_out
                                    , $value->vCampo13_check_out
                                    , $value->vCampo14_check_out
                                    , $value->vCampo15_check_out
                                    , $value->vCampo16_check_out
                                    , $value->vCampo17_check_out
                                    , $value->vCampo18_check_out
                                    , $value->vCampo19_check_out
                                    , $value->vCampo20_check_out
                                    , $value->vCampo21_check_out
                                    , $value->vCampo22_check_out
                                    , $value->vCampo23_check_out
                                    , $value->vCampo24_check_out
                                    , $value->vCampo25_check_out
                                    , $value->vCampo26_check_out
                                    , $value->vCampo27_check_out
                                    , $value->vCampo28_check_out
                                    , $value->vCampo29_check_out
                                    , $value->vCampo30_check_out
                );
            }

            $nombre_archivo= 'Reporte_de_check_out.xlsx';

            $title[]= [  "id"
                        ,"vTema1_check_out"
                        ,"vTema2_check_out"
                        ,"vTema3_check_out"
                        ,"vTema4_check_out"
                        ,"vTema5_check_out"
                        ,"vTema6_check_out"
                        ,"vTema7_check_out"
                        ,"vTema8_check_out"
                        ,"vTema9_check_out"
                        ,"vTema10_check_out"
                        ,"vTema11_check_out"
                        ,"vTema12_check_out"
                        ,"vTema13_check_out"
                        ,"vTema14_check_out"
                        ,"vTema15_check_out"
                        ,"vTema16_check_out"
                        ,"vTema17_check_out"
                        ,"vTema18_check_out"
                        ,"vTema19_check_out"
                        ,"vTema20_check_out"
                        ,"vTema21_check_out"
                        ,"vTema22_check_out"
                        ,"vTema23_check_out"
                        ,"vTema24_check_out"
                        ,"vTema25_check_out"
                        ,"vTema26_check_out"
                        ,"vTema27_check_out"
                        ,"vTema28_check_out"
                        ,"vTema29_check_out"
                        ,"vTema30_check_out"
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

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_check_out()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_check_out` ');
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
                        ->select('id', 'user_id', 'id_conekta', 'payment_source_id')
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
                        'customer_id' => $card->id_conekta
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
}
