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

        // Obtener el user_id del usuario autenticado
        $userId = Auth::user()->id;

        // Buscar la empresa por user_id
        $empresa = Empresa::where('user_id', $userId)->first();
        
        // Pasar los datos a la vista
        return view('empresa', ['empresa' => $empresa]);
    }


    /*
    |--------------------------------------------------------------------------
    | Mostrar ubicación mapa
    |--------------------------------------------------------------------------
    |
    */
    public function empresa_ubicacion(Request $request)
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'empresa_ubicacion' , 'vc_info' => "empresa_ubicacion" ] );
        
        // Obtener el user_id del usuario autenticado
        $userId = Auth::user()->id;

        // Buscar la empresa por user_id
        $empresa = Empresa::where('user_id', $userId)->first();
        
        $ubicacion = $empresa->ubicacion ?? null;
        $latitud = $empresa->latitud ?? null;
        $longitud = $empresa->longitud ?? null;

        return view('empresa.empresa_ubicacion', compact('ubicacion', 'latitud', 'longitud'));

    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar horario
    |--------------------------------------------------------------------------
    |
    */
    public function empresa_horario(Request $request)
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'empresa_horario' , 'vc_info' => "empresa_horario" ] );
        
        // Obtener el user_id del usuario autenticado
        $userId = Auth::user()->id;

        // Recuperar los horarios del usuario
        $horarios = DB::table('horarios')
            ->where('user_id', $userId)
            ->get()
            ->keyBy('dia');

        return view('empresa.empresa_horario', compact('horarios'));

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

        if (   ( isset($request->buscar_user_id) && !empty($request->buscar_user_id) )
            || ( isset($request->buscar_logo) && !empty($request->buscar_logo) )
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
        $buscar_user_id= isset($request->buscar_user_id) ? $request->buscar_user_id :'';
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
            , "'.$buscar_user_id.'"
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
        $data = [
            'user_id' => Auth::user()->id,
            'nombre' => $request->nombre ?? "",
            'descripcion' => $request->descripcion ?? "",
            'telefono' => $request->telefono ?? "",
            'whatsapp' => $request->whatsapp ?? "",
        ];

        $updateData = [
            'nombre' => $request->nombre ?? "",
            'descripcion' => $request->descripcion ?? "",
            'telefono' => $request->telefono ?? "",
            'whatsapp' => $request->whatsapp ?? "",
        ];

        // Usar updateOrInsert para realizar el upsert
        $result = DB::table('empresa')->updateOrInsert(
            ['user_id' => Auth::user()->id], // Condición para el upsert
            $updateData // Datos para insertar o actualizar
        );

        if ($result) {
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        } else {
            return json_encode(array("b_status"=> true, "vc_message" => "Error al realizar la operación..."));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Agrega o modificar ubicación
    |--------------------------------------------------------------------------
    | 
    | Modifica el registro solo si manda el parametro '$request->id'
    | @return json
    |
    */
    public function set_empresa_ubicacion(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'ubicacion' => $request->ubicacion ?? "",
            'longitud' => $request->longitud ?? "",
            'latitud' => $request->latitud ?? "",
        ];

        $updateData = [
            'ubicacion' => $request->ubicacion ?? "",
            'longitud' => $request->longitud ?? "",
            'latitud' => $request->latitud ?? "",
        ];

        // Usar updateOrInsert para realizar el upsert
        $result = DB::table('empresa')->updateOrInsert(
            ['user_id' => Auth::user()->id], // Condición para el upsert
            $updateData // Datos para insertar o actualizar
        );

        if ($result) {
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        } else {
            return json_encode(array("b_status"=> true, "vc_message" => "Error al realizar la operación..."));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Horarios
    |--------------------------------------------------------------------------
    | 
    | Modifica el registro solo si manda el parametro '$request->id'
    | @return json
    |
    */
    public function set_empresa_horarios(Request $request)
    {
        // dd($request->all());

        $userId = auth()->user()->id;

        // Actualiza los horarios aplico esto por efecto visual
        // aplico disabled
        DB::table('horarios')
            ->where('user_id', $userId)
            ->update([
                'cerrada' => 1,
            ]);

        // Iterar sobre los días para actualizar o insertar los horarios
            // dd($request->abre_a);
        foreach ($request->abre_a as $dia => $abre) {
            $cierra = $request->cierra_a[$dia];
            $cerrada = isset($request->cerrada[$dia]);

            // Verificar si ya existe un registro para este día y usuario
            $existingHorario = DB::table('horarios')
                ->where('dia', $dia)
                ->where('user_id', $userId)
                ->first();

            if ($existingHorario) {
                // Actualizar el horario existente
                DB::table('horarios')
                    ->where('id', $existingHorario->id)
                    ->update([
                        'abre_a' => $abre,
                        'cierra_a' => $cierra,
                        'cerrada' => $cerrada,
                    ]);
            } else {
                // Insertar un nuevo horario
                DB::table('horarios')->insert([
                    'dia' => $dia,
                    'user_id' => $userId,
                    'abre_a' => $abre,
                    'cierra_a' => $cierra,
                    'cerrada' => $cerrada,
                ]);
            }
        }

        return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
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
            $data= empresa::select('user_id')
            ->where('user_id' ,'=', trim($request->user_id))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= empresa::select('user_id')
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
                $data[]=  ['user_id'=> trim($line)] ;
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
            ->OrWhere('user_id', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", user_id, " ", logo ) as user_id')
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

                $data_insert[]=  array(  "user_id"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"logo"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"nombre"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"descripcion"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"telefono"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"whatsapp"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"ubicacion"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"longitud"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"latitud"  =>  isset($t[8]) ? $t[8] : ''
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

            $title[]= [  "User_Id"
                        ,"Logo"
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
        $data= empresa::select('user_id'
                                    , 'logo'
                                    , 'nombre'
                                    , 'descripcion'
                                    , 'telefono'
                                    , 'whatsapp'
                                    , 'ubicacion'
                                    , 'longitud'
                                    , 'latitud'
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
    public function get_cat_empresa(Request $request)
    {
        $data= empresa::select(  'id'
                                    , 'user_id'
                                    , 'logo'
                                    , 'nombre'
                                    , 'descripcion'
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
            , "user_id"
            , "logo"
            , "nombre"
            , "descripcion"
            , "telefono"
            , "whatsapp"
            , "ubicacion"
        )
        ->where("empresa.b_status", ">", 0)
        ->limit(50)
        ->orderBy("empresa.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'user_id'=>$value->user_id
                                , 'logo'=>$value->logo
                                , 'nombre'=>$value->nombre
                                , 'descripcion'=>$value->descripcion
                                , 'telefono'=>$value->telefono
                                , 'whatsapp'=>$value->whatsapp
                                , 'ubicacion'=>$value->ubicacion
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
                                    , "user_id"
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
                                , $value->user_id
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
                                    , "user_id"
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
                                    , $value->user_id
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
                        ,"User_Id"
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

    public function ajax_upload_file_empresa(Request $request)
    {
        // initialize FileUploader
        $FileUploader = new FileUploader('files', array(
            // options
            'limit' => 1,
            'uploadDir' => public_path('uploads/empresa/logos/'),
            'title' => 'auto'
        ));

        // Obtener el userId del usuario autenticado
        $userId = Auth::user()->id;

        // Obtener el logo actual del usuario
        $currentLogo = DB::table('empresa')->where('user_id', $userId)->value('logo');

        if ($currentLogo) {
            // Construir la ruta completa del archivo actual
            $currentLogoPath = public_path('uploads/empresa/logos/' . $currentLogo);

            // Verificar si el archivo existe y eliminarlo
            if (file_exists($currentLogoPath)) {
                unlink($currentLogoPath);
            }
        }

        // upload
        $upload = $FileUploader->upload();  

        $data = $upload;

        // Cambiar los datos públicos del archivo
        if (!empty($data['files'])) {
            $item = $data['files'][0];
            
            $data['files'][0] = [
                'title' => $item['title'],
                'name' => $item['name'],
                'size' => $item['size'],
                'size2' => $item['size2'],
                'file' => $item['file']
            ];

            $userId = Auth::user()->id;

            // Insertar o actualizar en la base de datos usando user_id
            DB::table('empresa')->updateOrInsert(
                ['user_id' => $userId], // Condición para encontrar el registro
                ['logo' => $item['name']] // Datos a insertar o actualizar
            );
        }

        // Exportar a JS
        return response()->json($data);

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
