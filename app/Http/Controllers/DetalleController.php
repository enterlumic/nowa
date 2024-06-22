<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\detalleSendMail as FndetalleSendMail;
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
use App\Lib\LibCore;
use App\Models\promociones;
use Session;

class DetalleController extends Controller
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
    | Todo es controlado por JS detalle.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet(['vc_evento' => 'index_detalle', 'vc_info' => "index - detalle"]);

        // Obtener las fotos de la base de datos
        $promocion_id = 9; // Puedes cambiar esto dinámicamente según tus necesidades
        $fotos = DB::table('promocion_fotos')
            ->select('size', 'foto_url')
            ->where('promocion_id', $promocion_id)
            ->whereIn('size', ['original', 'small'])
            ->get();

        return view('detalle', ['fotos' => $fotos]);
    }

    public function get_data_by_id($id)
    {
        $id = Crypt::decrypt($id);

        $producto = promociones::find($id);

        if ($producto) {
            $producto->fotos_array = explode("\n", trim($producto->fotos));
            
            // Añadir otros campos que se necesiten en la vista
            $producto->titulo = $producto->titulo;
            $producto->descripcion = $producto->descripcion;
            $producto->precio = $producto->precio;
            $producto->color = $producto->color;
            $producto->precio_anterior = $producto->precio_anterior;
            $producto->target = $producto->target;
            
            return response()->json($producto);
        } else {
            // Manejar el caso cuando el producto no se encuentra
            return response()->json(['error' => 'Producto no encontrado'], 404);
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
    public function set_detalle(Request $request)
    {
        if(!\Schema::hasTable('detalle')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FndetalleSendMail(
                    'Notificación no existe tabla detalle'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla detalle"));
        }

        $data=[ 'vCampo1_detalle' => isset($request->vCampo1_detalle)? $request->vCampo1_detalle:"",
                'vCampo2_detalle' => isset($request->vCampo2_detalle)? $request->vCampo2_detalle: "",
                'vCampo3_detalle' => isset($request->vCampo3_detalle)? $request->vCampo3_detalle: "",
                'vCampo4_detalle' => isset($request->vCampo4_detalle)? $request->vCampo4_detalle: "",
                'vCampo5_detalle' => isset($request->vCampo5_detalle)? $request->vCampo5_detalle: "",
                'vCampo6_detalle' => isset($request->vCampo6_detalle)? $request->vCampo6_detalle: "",
                'vCampo7_detalle' => isset($request->vCampo7_detalle)? $request->vCampo7_detalle: "",
                'vCampo8_detalle' => isset($request->vCampo8_detalle)? $request->vCampo8_detalle: "",
                'vCampo9_detalle' => isset($request->vCampo9_detalle)? $request->vCampo9_detalle: "",
                'vCampo10_detalle' => isset($request->vCampo10_detalle)? $request->vCampo10_detalle: "",
                'vCampo11_detalle' => isset($request->vCampo11_detalle)? $request->vCampo11_detalle: "",
                'vCampo12_detalle' => isset($request->vCampo12_detalle)? $request->vCampo12_detalle: "",
                'vCampo13_detalle' => isset($request->vCampo13_detalle)? $request->vCampo13_detalle: "",
                'vCampo14_detalle' => isset($request->vCampo14_detalle)? $request->vCampo14_detalle: "",
                'vCampo15_detalle' => isset($request->vCampo15_detalle)? $request->vCampo15_detalle: "",
                'vCampo16_detalle' => isset($request->vCampo16_detalle)? $request->vCampo16_detalle: "",
                'vCampo17_detalle' => isset($request->vCampo17_detalle)? $request->vCampo17_detalle: "",
                'vCampo18_detalle' => isset($request->vCampo18_detalle)? $request->vCampo18_detalle: "",
                'vCampo19_detalle' => isset($request->vCampo19_detalle)? $request->vCampo19_detalle: "",
                'vCampo20_detalle' => isset($request->vCampo20_detalle)? $request->vCampo20_detalle: "",
                'vCampo21_detalle' => isset($request->vCampo21_detalle)? $request->vCampo21_detalle: "",
                'vCampo22_detalle' => isset($request->vCampo22_detalle)? $request->vCampo22_detalle: "",
                'vCampo23_detalle' => isset($request->vCampo23_detalle)? $request->vCampo23_detalle: "",
                'vCampo24_detalle' => isset($request->vCampo24_detalle)? $request->vCampo24_detalle: "",
                'vCampo25_detalle' => isset($request->vCampo25_detalle)? $request->vCampo25_detalle: "",
                'vCampo26_detalle' => isset($request->vCampo26_detalle)? $request->vCampo26_detalle: "",
                'vCampo27_detalle' => isset($request->vCampo27_detalle)? $request->vCampo27_detalle: "",
                'vCampo28_detalle' => isset($request->vCampo28_detalle)? $request->vCampo28_detalle: "",
                'vCampo29_detalle' => isset($request->vCampo29_detalle)? $request->vCampo29_detalle: "",
                'vCampo30_detalle' => isset($request->vCampo30_detalle)? $request->vCampo30_detalle: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('detalle')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('detalle')->insert($data);
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
    public function validar_existencia_detalle(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= detalle::select('vCampo1_detalle')
            ->where('vCampo1_detalle' ,'=', trim($request->vCampo1_detalle))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= detalle::select('vCampo1_detalle')
            ->where('vCampo1_detalle' ,'=', trim($request->vCampo1_detalle))
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
    public function set_import_detalle(Request $request)
    {
        if(!\Schema::hasTable('detalle')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_detalle' , 'vc_info' => "set_import_detalle" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['vCampo1_detalle'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            detalle::truncate();
            detalle::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSidedetalle(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('detalle')
            ->Where('id', ' > ', 0)
            ->OrWhere('vCampo1_detalle', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", vCampo1_detalle, " ", vCampo2_detalle ) as vCampo1_detalle')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'vCampo1_detalle' =>Str::headline($item->vCampo1_detalle) ];
        });

        return response()->json($options);
    } 

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_detalle(Request $request)
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

                $data_insert[]=  array(  "vCampo1_detalle"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"vCampo2_detalle"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"vCampo3_detalle"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"vCampo4_detalle"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"vCampo5_detalle"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"vCampo6_detalle"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"vCampo7_detalle"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"vCampo8_detalle"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"vCampo9_detalle"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"vCampo10_detalle"  =>  isset($t[9]) ? $t[9] : ''
                                        ,"vCampo11_detalle"  =>  isset($t[10]) ? $t[10] : ''
                                        ,"vCampo12_detalle"  =>  isset($t[11]) ? $t[11] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('detalle')->insert( $temp );
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
    public function descargar_plantilla_detalle(Request $request)
    {
            $nombre_archivo= 'plantilla_detalle.xlsx';

            $title[]= [  "vTema1_detalle"
                        ,"vTema2_detalle"
                        ,"vTema3_detalle"
                        ,"vTema4_detalle"
                        ,"vTema5_detalle"
                        ,"vTema6_detalle"
                        ,"vTema7_detalle"
                        ,"vTema8_detalle"
                        ,"vTema9_detalle"
                        ,"vTema10_detalle"
                        ,"vTema11_detalle"
                        ,"vTema12_detalle"
                        ,"vTema13_detalle"
                        ,"vTema14_detalle"
                        ,"vTema15_detalle"
                        ,"vTema16_detalle"
                        ,"vTema17_detalle"
                        ,"vTema18_detalle"
                        ,"vTema19_detalle"
                        ,"vTema20_detalle"
                        ,"vTema21_detalle"
                        ,"vTema22_detalle"
                        ,"vTema23_detalle"
                        ,"vTema24_detalle"
                        ,"vTema25_detalle"
                        ,"vTema26_detalle"
                        ,"vTema27_detalle"
                        ,"vTema28_detalle"
                        ,"vTema29_detalle"
                        ,"vTema30_detalle"
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
    public function get_detalle_by_id(Request $request)
    {
        $data= detalle::select('vCampo1_detalle'
                                    , 'vCampo2_detalle'
                                    , 'vCampo3_detalle'
                                    , 'vCampo4_detalle'
                                    , 'vCampo5_detalle'
                                    , 'vCampo6_detalle'
                                    , 'vCampo7_detalle'
                                    , 'vCampo8_detalle'
                                    , 'vCampo9_detalle'
                                    , 'vCampo10_detalle'
                                    , 'vCampo11_detalle'
                                    , 'vCampo12_detalle'
                                    , 'vCampo13_detalle'
                                    , 'vCampo14_detalle'
                                    , 'vCampo15_detalle'
                                    , 'vCampo16_detalle'
                                    , 'vCampo17_detalle'
                                    , 'vCampo18_detalle'
                                    , 'vCampo19_detalle'
                                    , 'vCampo20_detalle'
                                    , 'vCampo21_detalle'
                                    , 'vCampo22_detalle'
                                    , 'vCampo23_detalle'
                                    , 'vCampo24_detalle'
                                    , 'vCampo25_detalle'
                                    , 'vCampo26_detalle'
                                    , 'vCampo27_detalle'
                                    , 'vCampo28_detalle'
                                    , 'vCampo29_detalle'
                                    , 'vCampo30_detalle'
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
    public function get_cat_detalle(Request $request)
    {
        $data= detalle::select(  'id'
                                    , 'vCampo1_detalle'
                                    , 'vCampo2_detalle'
                                    , 'vCampo3_detalle'
                                    , 'vCampo4_detalle'
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
    public function get_detalle_diez(Request $request)
    {
        if(!\Schema::hasTable('detalle')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("detalle")
        ->select("id"
            , "vCampo1_detalle"
            , "vCampo2_detalle"
            , "vCampo3_detalle"
            , "vCampo4_detalle"
            , "vCampo5_detalle"
            , "vCampo6_detalle"
            , "vCampo7_detalle"
        )
        ->where("detalle.b_status", ">", 0)
        ->limit(50)
        ->orderBy("detalle.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'vCampo1_detalle'=>$value->vCampo1_detalle
                                , 'vCampo2_detalle'=>$value->vCampo2_detalle
                                , 'vCampo3_detalle'=>$value->vCampo3_detalle
                                , 'vCampo4_detalle'=>$value->vCampo4_detalle
                                , 'vCampo5_detalle'=>$value->vCampo5_detalle
                                , 'vCampo6_detalle'=>$value->vCampo6_detalle
                                , 'vCampo7_detalle'=>$value->vCampo7_detalle
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
    public function get_detalle_by_list(Request $request)
    {
        if(!\Schema::hasTable('detalle')){
            return json_encode(array("data"=>"" ));
        }

        $data= detalle::select(  "id"
                                    , "vCampo1_detalle"
                                    , "vCampo2_detalle"
                                    , "vCampo3_detalle"
                                    , "vCampo4_detalle"
                                    , "vCampo5_detalle"
                                    , "vCampo6_detalle"
                                    , "vCampo7_detalle"
                                    , "vCampo8_detalle"
                                    , "vCampo9_detalle"
                                    , "vCampo10_detalle"
                                    , 'vCampo11_detalle'
                                    , 'vCampo12_detalle'
                                    , 'vCampo13_detalle'
                                    , 'vCampo14_detalle'
                                    , 'vCampo15_detalle'
                                    , 'vCampo16_detalle'
                                    , 'vCampo17_detalle'
                                    , 'vCampo18_detalle'
                                    , 'vCampo19_detalle'
                                    , 'vCampo20_detalle'
                                    , 'vCampo21_detalle'
                                    , 'vCampo22_detalle'
                                    , 'vCampo23_detalle'
                                    , 'vCampo24_detalle'
                                    , 'vCampo25_detalle'
                                    , 'vCampo26_detalle'
                                    , 'vCampo27_detalle'
                                    , 'vCampo28_detalle'
                                    , 'vCampo29_detalle'
                                    , 'vCampo30_detalle'
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->vCampo1_detalle
                                , $value->vCampo2_detalle
                                , $value->vCampo3_detalle
                                , $value->vCampo4_detalle
                                , $value->vCampo5_detalle
                                , $value->vCampo6_detalle
                                , $value->vCampo7_detalle
                                , $value->vCampo8_detalle
                                , $value->vCampo9_detalle
                                , $value->vCampo10_detalle
                                , $value->vCampo11_detalle
                                , $value->vCampo12_detalle
                                , $value->vCampo13_detalle
                                , $value->vCampo14_detalle
                                , $value->vCampo15_detalle
                                , $value->vCampo16_detalle
                                , $value->vCampo17_detalle
                                , $value->vCampo18_detalle
                                , $value->vCampo19_detalle
                                , $value->vCampo20_detalle
                                , $value->vCampo21_detalle
                                , $value->vCampo22_detalle
                                , $value->vCampo23_detalle
                                , $value->vCampo24_detalle
                                , $value->vCampo25_detalle
                                , $value->vCampo26_detalle
                                , $value->vCampo27_detalle
                                , $value->vCampo28_detalle
                                , $value->vCampo29_detalle
                                , $value->vCampo30_detalle
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
    public function export_excel_detalle(Request $request){

        if(!\Schema::hasTable('detalle')){
            return json_encode(array("data"=>"" ));
        }

        $data= detalle::select("id"
                                    , "vCampo1_detalle"
                                    , "vCampo2_detalle"
                                    , "vCampo3_detalle"
                                    , "vCampo4_detalle"
                                    , "vCampo5_detalle"
                                    , "vCampo6_detalle"
                                    , "vCampo7_detalle"
                                    , "vCampo8_detalle"
                                    , "vCampo9_detalle"
                                    , "vCampo10_detalle"
                                    , 'vCampo11_detalle'
                                    , 'vCampo12_detalle'
                                    , 'vCampo13_detalle'
                                    , 'vCampo14_detalle'
                                    , 'vCampo15_detalle'
                                    , 'vCampo16_detalle'
                                    , 'vCampo17_detalle'
                                    , 'vCampo18_detalle'
                                    , 'vCampo19_detalle'
                                    , 'vCampo20_detalle'
                                    , 'vCampo21_detalle'
                                    , 'vCampo22_detalle'
                                    , 'vCampo23_detalle'
                                    , 'vCampo24_detalle'
                                    , 'vCampo25_detalle'
                                    , 'vCampo26_detalle'
                                    , 'vCampo27_detalle'
                                    , 'vCampo28_detalle'
                                    , 'vCampo29_detalle'
                                    , 'vCampo30_detalle'
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->vCampo1_detalle
                                    , $value->vCampo2_detalle
                                    , $value->vCampo3_detalle
                                    , $value->vCampo4_detalle
                                    , $value->vCampo5_detalle
                                    , $value->vCampo6_detalle
                                    , $value->vCampo7_detalle
                                    , $value->vCampo8_detalle
                                    , $value->vCampo9_detalle
                                    , $value->vCampo10_detalle
                                    , $value->vCampo11_detalle
                                    , $value->vCampo12_detalle
                                    , $value->vCampo13_detalle
                                    , $value->vCampo14_detalle
                                    , $value->vCampo15_detalle
                                    , $value->vCampo16_detalle
                                    , $value->vCampo17_detalle
                                    , $value->vCampo18_detalle
                                    , $value->vCampo19_detalle
                                    , $value->vCampo20_detalle
                                    , $value->vCampo21_detalle
                                    , $value->vCampo22_detalle
                                    , $value->vCampo23_detalle
                                    , $value->vCampo24_detalle
                                    , $value->vCampo25_detalle
                                    , $value->vCampo26_detalle
                                    , $value->vCampo27_detalle
                                    , $value->vCampo28_detalle
                                    , $value->vCampo29_detalle
                                    , $value->vCampo30_detalle
                );
            }

            $nombre_archivo= 'Reporte_de_detalle.xlsx';

            $title[]= [  "id"
                        ,"vTema1_detalle"
                        ,"vTema2_detalle"
                        ,"vTema3_detalle"
                        ,"vTema4_detalle"
                        ,"vTema5_detalle"
                        ,"vTema6_detalle"
                        ,"vTema7_detalle"
                        ,"vTema8_detalle"
                        ,"vTema9_detalle"
                        ,"vTema10_detalle"
                        ,"vTema11_detalle"
                        ,"vTema12_detalle"
                        ,"vTema13_detalle"
                        ,"vTema14_detalle"
                        ,"vTema15_detalle"
                        ,"vTema16_detalle"
                        ,"vTema17_detalle"
                        ,"vTema18_detalle"
                        ,"vTema19_detalle"
                        ,"vTema20_detalle"
                        ,"vTema21_detalle"
                        ,"vTema22_detalle"
                        ,"vTema23_detalle"
                        ,"vTema24_detalle"
                        ,"vTema25_detalle"
                        ,"vTema26_detalle"
                        ,"vTema27_detalle"
                        ,"vTema28_detalle"
                        ,"vTema29_detalle"
                        ,"vTema30_detalle"
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
    public function delete_detalle(Request $request)
    {
        $id=$request->id;
        detalle::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_detalle(Request $request)
    {
        $id=$request->id;
        detalle::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_detalle()
    {
        detalle::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_detalle()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_detalle` ');
    }
}
