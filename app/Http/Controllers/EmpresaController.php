<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\empresaSendMail as FnempresaSendMail;
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
use Illuminate\Support\Facades\Validator;
use App\Models\empresa;
use App\Lib\LibCore;
use \FileUploader;

use Session;

class EmpresaController extends Controller
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
    | Todo es controlado por JS empresa.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_empresa' , 'vc_info' => "index - empresa" ] );
        return view('empresa');
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_empresa_datatable(Request $request)
    {
        if(!\Schema::hasTable('empresa')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_logo) && !empty($request->buscar_logo) )
            || ( isset($request->buscar_nombre) && !empty($request->buscar_nombre) )
            || ( isset($request->buscar_descripcion) && !empty($request->buscar_descripcion) )
            || ( isset($request->buscar_telefono) && !empty($request->buscar_telefono) )
            || ( isset($request->buscar_whatsapp) && !empty($request->buscar_whatsapp) )
            || ( isset($request->buscar_ubicacion) && !empty($request->buscar_ubicacion) )
            || ( isset($request->buscar_longitud) && !empty($request->buscar_longitud) )
            || ( isset($request->buscar_latitud) && !empty($request->buscar_latitud) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_logo= isset($request->buscar_logo) ? $request->buscar_logo :'';
        $buscar_nombre= isset($request->buscar_nombre) ? $request->buscar_nombre :'';
        $buscar_descripcion= isset($request->buscar_descripcion) ? $request->buscar_descripcion :'';
        $buscar_telefono= isset($request->buscar_telefono) ? $request->buscar_telefono :'';
        $buscar_whatsapp= isset($request->buscar_whatsapp) ? $request->buscar_whatsapp :'';
        $buscar_ubicacion= isset($request->buscar_ubicacion) ? $request->buscar_ubicacion :'';
        $buscar_longitud= isset($request->buscar_longitud) ? $request->buscar_longitud :'';
        $buscar_latitud= isset($request->buscar_latitud) ? $request->buscar_latitud :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_empresa(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_logo.'"
            , "'.$buscar_nombre.'"
            , "'.$buscar_descripcion.'"
            , "'.$buscar_telefono.'"
            , "'.$buscar_whatsapp.'"
            , "'.$buscar_ubicacion.'"
            , "'.$buscar_longitud.'"
            , "'.$buscar_latitud.'"
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
    public function set_empresa(Request $request)
    {
        if(!\Schema::hasTable('empresa')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnempresaSendMail(
                    'Notificación no existe tabla empresa'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla empresa"));
        }

        // Procesar el archivo de logo
        if ($request->has('fileuploader-list-logoUpload')) {
            $fileUploaderList = json_decode($request->input('fileuploader-list-logoUpload'), true);

            foreach ($fileUploaderList as $fileInfo) {
                if (isset($fileInfo['editor']['crop'])) {
                    $fileName = $fileInfo['file'];
                    $cropData = $fileInfo['editor']['crop'];

                    // Obtener el archivo del almacenamiento temporal
                    $path = storage_path('app/public/uploads/temp/' . $fileName);

                    if (file_exists($path)) {
                        // Recortar y guardar la imagen
                        $img = \Image::make($path);
                        $img->crop(
                            intval($cropData['width']),
                            intval($cropData['height']),
                            intval($cropData['left']),
                            intval($cropData['top'])
                        );

                        $finalPath = 'public/uploads/empresa/logos/' . $fileName;
                        try {
                            Storage::put($finalPath, (string) $img->encode());
                        } catch (\Exception $e) {
                            return response()->json(['error' => $e->getMessage()]);
                        }

                        $request->logo = $finalPath;
                    }
                }
            }
        }

        $data=[ 'logo' => isset($request->logo)? $request->logo:"",
                'nombre' => isset($request->nombre)? $request->nombre: "",
                'descripcion' => isset($request->descripcion)? $request->descripcion: "",
                'telefono' => isset($request->telefono)? $request->telefono: "",
                'whatsapp' => isset($request->whatsapp)? $request->whatsapp: "",
                'ubicacion' => isset($request->ubicacion)? $request->ubicacion: "",
                'longitud' => isset($request->longitud)? $request->longitud: "",
                'latitud' => isset($request->latitud)? $request->latitud: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('empresa')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('empresa')->insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Simular upload foto
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function ajax_upload_file(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'name' => 'required|string',
            'logoUpload' => 'required|array',
            'logoUpload.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:10240' // Validación básica de archivos
        ]);

        // Obtener información del archivo
        $file = $request->file('logoUpload')[0];

        // Generar un nombre único para el archivo
        $filename = time() . '_' . $file->getClientOriginalName();

        // Guardar el archivo en el almacenamiento público
        $path = $file->storeAs('public/uploads/temp', $filename);

        // Datos de la respuesta JSON
        $data = [
            'files' => [
                [
                    'title' => $file->getClientOriginalName(),
                    'name' => $filename,
                    'size' => $file->getSize(),
                    'size2' => $this->formatSizeUnits($file->getSize()),
                    'type' => $file->getMimeType(),
                    'url' => Storage::url($path)
                ]
            ],
            'isSuccess' => true
        ];

        return response()->json($data);

    }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /*
    |--------------------------------------------------------------------------
    | Validar existencia antes de crear un nuevo registro
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function validar_existencia_empresa(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= empresa::select('logo')
            ->where('logo' ,'=', trim($request->logo))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= empresa::select('logo')
            ->where('logo' ,'=', trim($request->logo))
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
    public function set_import_empresa(Request $request)
    {
        if(!\Schema::hasTable('empresa')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_empresa' , 'vc_info' => "set_import_empresa" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['logo'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            empresa::truncate();
            empresa::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSideempresa(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('empresa')
            ->Where('id', ' > ', 0)
            ->OrWhere('logo', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", logo, " ", nombre ) as logo')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'logo' =>Str::headline($item->logo) ];
        });

        return response()->json($options);
    } 

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_empresa(Request $request)
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

                $data_insert[]=  array(  "logo"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"nombre"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"descripcion"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"telefono"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"whatsapp"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"ubicacion"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"longitud"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"latitud"  =>  isset($t[7]) ? $t[7] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('empresa')->insert( $temp );
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
    public function descargar_plantilla_empresa(Request $request)
    {
            $nombre_archivo= 'plantilla_empresa.xlsx';

            $title[]= [  "Logo"
                        ,"Nombre"
                        ,"Descripcion"
                        ,"Telefono"
                        ,"Whatsapp"
                        ,"Ubicacion"
                        ,"Longitud"
                        ,"Latitud"
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
    public function get_empresa_by_id(Request $request)
    {
        $data = Empresa::select(
            'logo',
            'nombre',
            'descripcion',
            'telefono',
            'whatsapp',
            'ubicacion',
            'longitud',
            'latitud'
        )->where('id', $request->id)->get();

        if ($data->count() > 0) {
            // Agregar la URL completa del logo a cada empresa
            foreach ($data as $empresa) {
                $empresa->logo_url =  url(Storage::url($empresa->logo));
            }
            return json_encode(array("b_status" => true, "data" => $data));
        } else {
            return json_encode(array("b_status" => false, "data" => 'sin resultados'));
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
    public function get_cat_empresa(Request $request)
    {
        $data= empresa::select(  'id'
                                    , 'logo'
                                    , 'nombre'
                                    , 'descripcion'
                                    , 'telefono'
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
    public function get_empresa_diez(Request $request)
    {
        if(!\Schema::hasTable('empresa')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("empresa")
        ->select("id"
            , "logo"
            , "nombre"
            , "descripcion"
            , "telefono"
            , "whatsapp"
            , "ubicacion"
            , "longitud"
        )
        ->where("empresa.b_status", ">", 0)
        ->limit(50)
        ->orderBy("empresa.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'logo'=>$value->logo
                                , 'nombre'=>$value->nombre
                                , 'descripcion'=>$value->descripcion
                                , 'telefono'=>$value->telefono
                                , 'whatsapp'=>$value->whatsapp
                                , 'ubicacion'=>$value->ubicacion
                                , 'longitud'=>$value->longitud
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
    public function get_empresa_by_list(Request $request)
    {
        if(!\Schema::hasTable('empresa')){
            return json_encode(array("data"=>"" ));
        }

        $data= empresa::select(  "id"
                                    , "logo"
                                    , "nombre"
                                    , "descripcion"
                                    , "telefono"
                                    , "whatsapp"
                                    , "ubicacion"
                                    , "longitud"
                                    , "latitud"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->logo
                                , $value->nombre
                                , $value->descripcion
                                , $value->telefono
                                , $value->whatsapp
                                , $value->ubicacion
                                , $value->longitud
                                , $value->latitud
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
    public function export_excel_empresa(Request $request){

        if(!\Schema::hasTable('empresa')){
            return json_encode(array("data"=>"" ));
        }

        $data= empresa::select("id"
                                    , "logo"
                                    , "nombre"
                                    , "descripcion"
                                    , "telefono"
                                    , "whatsapp"
                                    , "ubicacion"
                                    , "longitud"
                                    , "latitud"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->logo
                                    , $value->nombre
                                    , $value->descripcion
                                    , $value->telefono
                                    , $value->whatsapp
                                    , $value->ubicacion
                                    , $value->longitud
                                    , $value->latitud
                );
            }

            $nombre_archivo= 'Reporte_de_empresa.xlsx';

            $title[]= [  "id"
                        ,"Logo"
                        ,"Nombre"
                        ,"Descripcion"
                        ,"Telefono"
                        ,"Whatsapp"
                        ,"Ubicacion"
                        ,"Longitud"
                        ,"Latitud"
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
    public function delete_empresa(Request $request)
    {
        $id=$request->id;
        empresa::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_empresa(Request $request)
    {
        $id=$request->id;
        empresa::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_empresa()
    {
        empresa::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_empresa()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_empresa` ');
    }
}
