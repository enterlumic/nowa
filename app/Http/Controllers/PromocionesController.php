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
use Spatie\Image\Image;

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

        $promociones = Promociones::where('b_status', '>', 0)->orderBy('id', 'desc')->get();

        return view('promociones', compact('promociones'));

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

        if (   ( isset($request->buscar_fotos) && !empty($request->buscar_fotos) )
            || ( isset($request->buscar_titulo) && !empty($request->buscar_titulo) )
            || ( isset($request->buscar_descripcion) && !empty($request->buscar_descripcion) )
            || ( isset($request->buscar_precio) && !empty($request->buscar_precio) )
            || ( isset($request->buscar_marca) && !empty($request->buscar_marca) )
            || ( isset($request->buscar_review) && !empty($request->buscar_review) )
            || ( isset($request->buscar_cantidad) && !empty($request->buscar_cantidad) )
            || ( isset($request->buscar_color) && !empty($request->buscar_color) )
            || ( isset($request->buscar_precio_anterior) && !empty($request->buscar_precio_anterior) )
            || ( isset($request->buscar_target) && !empty($request->buscar_target) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_fotos= isset($request->buscar_fotos) ? $request->buscar_fotos :'';
        $buscar_titulo= isset($request->buscar_titulo) ? $request->buscar_titulo :'';
        $buscar_descripcion= isset($request->buscar_descripcion) ? $request->buscar_descripcion :'';
        $buscar_precio= isset($request->buscar_precio) ? $request->buscar_precio :'';
        $buscar_marca= isset($request->buscar_marca) ? $request->buscar_marca :'';
        $buscar_review= isset($request->buscar_review) ? $request->buscar_review :'';
        $buscar_cantidad= isset($request->buscar_cantidad) ? $request->buscar_cantidad :'';
        $buscar_color= isset($request->buscar_color) ? $request->buscar_color :'';
        $buscar_precio_anterior= isset($request->buscar_precio_anterior) ? $request->buscar_precio_anterior :'';
        $buscar_target= isset($request->buscar_target) ? $request->buscar_target :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_promociones(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_fotos.'"
            , "'.$buscar_titulo.'"
            , "'.$buscar_descripcion.'"
            , "'.$buscar_precio.'"
            , "'.$buscar_marca.'"
            , "'.$buscar_review.'"
            , "'.$buscar_cantidad.'"
            , "'.$buscar_color.'"
            , "'.$buscar_precio_anterior.'"
            , "'.$buscar_target.'"
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
        if (!\Schema::hasTable('promociones')) {
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnpromocionesSendMail(
                    'Notificación no existe tabla promociones',
                    __DIR__ . "\n"
                )
            );
            return json_encode(array("b_status" => false, "vc_message" => "No se encontró la tabla promociones"));
        }

        // Guardar en la bd
        $data = [
            'fotos' => isset($request->fotos) ? $request->fotos : "",
            'titulo' => isset($request->titulo) ? $request->titulo : "",
            'descripcion' => isset($request->descripcion) ? $request->descripcion : "",
            'precio' => $request->precio,
            'marca' => isset($request->marca) ? $request->marca : "",
            'review' => isset($request->review) ? $request->review : "",
            'cantidad' => intval($request->cantidad),
            'color' => isset($request->color) ? $request->color : "",
            'precio_anterior' => isset($request->precio_anterior) ? $request->precio_anterior : "",
            'target' => isset($request->target) ? $request->target : "",
            'tiempo_trabajador' => isset($request->tiempo_trabajador) ? $request->tiempo_trabajador : 0,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)) {
            DB::table('promociones')->where('id', $request->id)->update($data);
            $this->fnFotosUpload($request, $request->id);
            return json_encode(array("b_status" => true, "vc_message" => "Actualizado correctamente..."));
        } else { // Nuevo registro
            $id = DB::table('promociones')->insertGetId($data);
            $this->fnFotosUpload($request, $id);
            return json_encode(array("b_status" => true, "vc_message" => "Agregado correctamente..."));
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
    public function fnFotosUpload(Request $request, $promocionId)
    {
        // Verificar si hay archivos en fotosUpload
        if ($request->hasFile('fotosUpload')) {
            $fotosUpload = $request->file('fotosUpload');
            $uploadDirectory = 'uploads/promociones/';

            // Crear el directorio si no existe
            if (!file_exists(public_path($uploadDirectory))) {
                mkdir(public_path($uploadDirectory), 0755, true);
            }

            // Guardar las imágenes en el directorio
            $storedFiles = [];
            foreach ($fotosUpload as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Redimensionar y optimizar la imagen
                $imagePath = public_path($uploadDirectory . $fileName);
                Image::load($file->getPathname())
                    ->width(600)
                    ->optimize()
                    ->save($imagePath);

                // Original
                $data = [
                    [
                        'promocion_id' => $promocionId,
                        'size' => 'original',
                        'foto_url' => $fileName,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ];

                DB::table('promocion_fotos')->insert($data);

                $storedFiles[] = $uploadDirectory . $fileName;

                // Crear diferentes tamaños
                $sizes = [
                    'small' => 100,
                    'medium' => 300,
                    'large' => 600
                ];

                foreach ($sizes as $sizeName => $size) {
                    $resizedFileName = $sizeName . '_' . $fileName;
                    $resizedImagePath = public_path($uploadDirectory . $resizedFileName);

                    Image::load($file->getPathname())
                        ->width($size)
                        ->optimize()
                        ->save($resizedImagePath);

                    $data = [
                        [
                            'promocion_id' => $promocionId,
                            'size' => $sizeName,
                            'foto_url' => $resizedFileName,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    ];

                    DB::table('promocion_fotos')->insert($data);

                    $storedFiles[] = $uploadDirectory . $resizedFileName;
                }
            }
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
            $data= promociones::select('fotos')
            ->where('fotos' ,'=', trim($request->fotos))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= promociones::select('fotos')
            ->where('fotos' ,'=', trim($request->fotos))
            ->where('b_status' ,'>', 0)
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
                $data[]=  ['fotos'=> trim($line)] ;
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
            ->OrWhere('fotos', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", fotos, " ", titulo ) as fotos')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'fotos' =>Str::headline($item->fotos) ];
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

                $data_insert[]=  array(  "fotos"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"titulo"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"descripcion"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"precio"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"marca"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"review"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"cantidad"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"color"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"precio_anterior"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"target"  =>  isset($t[9]) ? $t[9] : ''
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

            $title[]= [  "Fotos"
                        ,"Titulo"
                        ,"Descripcion"
                        ,"Precio"
                        ,"Marca"
                        ,"Review"
                        ,"Cantidad"
                        ,"Color"
                        ,"Precio_Anterior"
                        ,"Target"
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
    | fn_update_promociones
    |
    */
    public function get_promociones_by_id(Request $request)
    {
        $data= promociones::select('fotos'
                                    , 'titulo'
                                    , 'descripcion'
                                    , 'precio'
                                    , 'marca'
                                    , 'review'
                                    , 'cantidad'
                                    , 'color'
                                    , 'precio_anterior'
                                    , 'target'
        )->where('id', $request->id)->get();


        $promocionId = $request->id;


        $uploadDir = public_path('uploads/promociones/');
        $relativeUploadDir = 'uploads/promociones/'; // Ruta relativa para usar en la URL
        // Realizar la cosulta a la base de datos
        $fotos = DB::table('promocion_fotos')
            ->select('id', 'size', 'foto_url')
            ->where('size', 'small')
            ->where('promocion_id', $promocionId)
            ->get();

        // Construir el array de archivos pre-cargados
        $preloadedFiles = [];

        foreach ($fotos as $foto) {
            $file = $foto->foto_url;
            $filePath = $uploadDir . $foto->foto_url;

            $preloadedFiles[] = array(
                "name" => $file,
                "type" => File::mimeType($uploadDir . $file),
                "size" => filesize($uploadDir . $file),
                "file" => url($relativeUploadDir . $foto->foto_url), // Usar url() para obtener la URL completa
                "local" => url($relativeUploadDir . $foto->foto_url), // Mismo que en form_upload.php
                "data" => array(
                    "url" =>  url($relativeUploadDir . $foto->foto_url), // (opcional)
                    "thumbnail" => file_exists($uploadDir . $file) ? url($relativeUploadDir . $foto->foto_url) : null, // (opcional)
                    "readerForce" => true // (opcional) para prevenir caché del navegador
                ),
            );
        }

        // dd($preloadedFiles);
        // dd(json_encode($preloadedFiles));

        if ( $data->count() > 0 ){
            return json_encode(array("b_status"=> true, "data" => $data, "preloadedFiles" => json_encode($preloadedFiles)));
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
                                    , 'fotos'
                                    , 'titulo'
                                    , 'descripcion'
                                    , 'precio'
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

        $id_inicio= !is_numeric($request->id_promociones) ? 0 : $request->id_promociones;
        $id_fin= !is_numeric($request->id_promociones) ? 10 : $request->id_promociones +10;

        // dd($id_inicio, $id_fin);

        $count = DB::table('promociones')->where('b_status', '>', 0)->count();
        $count= ($count -1);
        if ($count == $request->id_promociones ){

             file_put_contents(storage_path('logs/laravel.log'), ">>>>>>>>".$request->id_promociones. "\n\n\n", FILE_APPEND);        

            return false;
        }

             file_put_contents(storage_path('logs/laravel.log'), $request->id_promociones. "\n\n\n", FILE_APPEND);        

        if (isset($request->id_promociones) && $request->id_promociones > 0){
            $id_promociones= $request->id_promociones;
        }else{
            $id_promociones= 10;
        }

        DB::enableQueryLog();

        $data= DB::table("promociones")
        ->select("id"
            , "fotos"
            , "titulo"
            , "descripcion"
            , "precio"
            , "marca"
            , "review"
            , "cantidad"
        )
        ->where("promociones.b_status", ">", 0)
        ->whereBetween("promociones.id", [$id_inicio, $id_fin]) // Cambia $id_inicio y $id_fin por los valores deseados
         ->where('b_status', '>', 0)
        ->limit(10)
        ->orderBy("promociones.id","desc")
        ->get();


// file_put_contents(storage_path('logs/laravel.log'), json_encode(DB::getQueryLog()) . "\n\n\n", FILE_APPEND);        

// dd(DB::getQueryLog());

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'fotos'=>$value->fotos
                                , 'titulo'=>$value->titulo
                                , 'descripcion'=>$value->descripcion
                                , 'precio'=>$value->precio
                                , 'marca'=>$value->marca
                                , 'review'=>$value->review
                                , 'cantidad'=>$value->cantidad
                );
            }

             // file_put_contents(storage_path('logs/laravel.log'), json_encode($arr) . "\n\n\n", FILE_APPEND);        

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
                                    , "fotos"
                                    , "titulo"
                                    , "descripcion"
                                    , "precio"
                                    , "marca"
                                    , "review"
                                    , "cantidad"
                                    , "color"
                                    , "precio_anterior"
                                    , "target"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->fotos
                                , $value->titulo
                                , $value->descripcion
                                , $value->precio
                                , $value->marca
                                , $value->review
                                , $value->cantidad
                                , $value->color
                                , $value->precio_anterior
                                , $value->target
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
                                    , "fotos"
                                    , "titulo"
                                    , "descripcion"
                                    , "precio"
                                    , "marca"
                                    , "review"
                                    , "cantidad"
                                    , "color"
                                    , "precio_anterior"
                                    , "target"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->fotos
                                    , $value->titulo
                                    , $value->descripcion
                                    , $value->precio
                                    , $value->marca
                                    , $value->review
                                    , $value->cantidad
                                    , $value->color
                                    , $value->precio_anterior
                                    , $value->target
                );
            }

            $nombre_archivo= 'Reporte_de_promociones.xlsx';

            $title[]= [  "id"
                        ,"Fotos"
                        ,"Titulo"
                        ,"Descripcion"
                        ,"Precio"
                        ,"Marca"
                        ,"Review"
                        ,"Cantidad"
                        ,"Color"
                        ,"Precio_Anterior"
                        ,"Target"
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

        $promocionFotos = DB::table('promocion_fotos')
                           ->select('foto_url')
                           ->where('promocion_id', $id)
                           ->get();

        if (!$promocionFotos->isEmpty()){
            foreach ($promocionFotos as $key => $value) {
                $filePath = public_path('uploads/promociones/'.$value->foto_url);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Actualizo status
        promociones::where('id', $id)->update(['b_status' => 0]);

        // Borro registros no tiene caso (borro imagenes para liberar espacio)
        DB::table('promocion_fotos')
            ->where('promocion_id', $id)
            ->delete();

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

    public function runPythonScript(Request $request)
    {

        $url = $request->input('url');

        // Path to your Python script
        $pythonScriptPath = base_path('combined_script.py');

        // Create the process to run the Python script
        $process = new Process(['python3', $pythonScriptPath, $url]);
        $process->run();

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output of the script
        $output = $process->getOutput();


    }
}
