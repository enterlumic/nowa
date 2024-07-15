<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\empleadosSendMail as FnempleadosSendMail;
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
use App\Models\empleados;
use App\Lib\LibCore;
use Session;

class EmpleadosController extends Controller
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
    | Todo es controlado por JS empleados.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_empleados' , 'vc_info' => "index - empleados" ] );
        return view('empleados');
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_empleados_datatable(Request $request)
    {
        if(!\Schema::hasTable('empleados')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_nombre) && !empty($request->buscar_nombre) )
            || ( isset($request->buscar_direccion) && !empty($request->buscar_direccion) )
            || ( isset($request->buscar_telefono) && !empty($request->buscar_telefono) )
            || ( isset($request->buscar_email) && !empty($request->buscar_email) )
            || ( isset($request->buscar_fecha_ingreso) && !empty($request->buscar_fecha_ingreso) )
            || ( isset($request->buscar_puesto) && !empty($request->buscar_puesto) )
            || ( isset($request->buscar_salario) && !empty($request->buscar_salario) )
            || ( isset($request->buscar_jornada) && !empty($request->buscar_jornada) )
            || ( isset($request->buscar_especialidades) && !empty($request->buscar_especialidades) )
            || ( isset($request->buscar_certificaciones) && !empty($request->buscar_certificaciones) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_nombre= isset($request->buscar_nombre) ? $request->buscar_nombre :'';
        $buscar_direccion= isset($request->buscar_direccion) ? $request->buscar_direccion :'';
        $buscar_telefono= isset($request->buscar_telefono) ? $request->buscar_telefono :'';
        $buscar_email= isset($request->buscar_email) ? $request->buscar_email :'';
        $buscar_fecha_ingreso= isset($request->buscar_fecha_ingreso) ? $request->buscar_fecha_ingreso :'';
        $buscar_puesto= isset($request->buscar_puesto) ? $request->buscar_puesto :'';
        $buscar_salario= isset($request->buscar_salario) ? $request->buscar_salario :'';
        $buscar_jornada= isset($request->buscar_jornada) ? $request->buscar_jornada :'';
        $buscar_especialidades= isset($request->buscar_especialidades) ? $request->buscar_especialidades :'';
        $buscar_certificaciones= isset($request->buscar_certificaciones) ? $request->buscar_certificaciones :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_empleados(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_nombre.'"
            , "'.$buscar_direccion.'"
            , "'.$buscar_telefono.'"
            , "'.$buscar_email.'"
            , "'.$buscar_fecha_ingreso.'"
            , "'.$buscar_puesto.'"
            , "'.$buscar_salario.'"
            , "'.$buscar_jornada.'"
            , "'.$buscar_especialidades.'"
            , "'.$buscar_certificaciones.'"
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
    public function set_empleados(Request $request)
    {
        if(!\Schema::hasTable('empleados')){
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnempleadosSendMail(
                    'Notificación no existe tabla empleados'
                    , __DIR__ ." \ n"
                )
            );
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla empleados"));
        }

        $data=[ 'nombre' => isset($request->nombre)? $request->nombre:"",
                'direccion' => isset($request->direccion)? $request->direccion: "",
                'telefono' => isset($request->telefono)? $request->telefono: "",
                'email' => isset($request->email)? $request->email: "",
                'fecha_ingreso' => isset($request->fecha_ingreso)? $request->fecha_ingreso: "",
                'puesto' => isset($request->puesto)? $request->puesto: "",
                'salario' => isset($request->salario)? $request->salario: "",
                'jornada' => isset($request->jornada)? $request->jornada: "",
                'especialidades' => isset($request->especialidades)? $request->especialidades: "",
                'certificaciones' => isset($request->certificaciones)? $request->certificaciones: "",
                'usuario' => isset($request->usuario)? $request->usuario: "",
                'contrasenia' => isset($request->contrasenia)? $request->contrasenia: "",
                'estado' => isset($request->estado)? $request->estado: "",
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            DB::table('empleados')->where('id', $request->id)->update($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            DB::table('empleados')->insert($data);
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
    public function validar_existencia_empleados(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= empleados::select('nombre')
            ->where('nombre' ,'=', trim($request->nombre))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= empleados::select('nombre')
            ->where('nombre' ,'=', trim($request->nombre))
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
    public function set_import_empleados(Request $request)
    {
        if(!\Schema::hasTable('empleados')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_empleados' , 'vc_info' => "set_import_empleados" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['nombre'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            empleados::truncate();
            empleados::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSideempleados(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('empleados')
            ->Where('id', ' > ', 0)
            ->OrWhere('nombre', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", nombre, " ", direccion ) as nombre')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'nombre' =>Str::headline($item->nombre) ];
        });

        return response()->json($options);
    } 

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_empleados(Request $request)
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

                $data_insert[]=  array(  "nombre"  =>  isset($t[0]) ? $t[0] : ''
                                        ,"direccion"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"telefono"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"email"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"fecha_ingreso"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"puesto"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"salario"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"jornada"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"especialidades"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"certificaciones"  =>  isset($t[9]) ? $t[9] : ''
                                        ,"usuario"  =>  isset($t[10]) ? $t[10] : ''
                                        ,"contrasenia"  =>  isset($t[11]) ? $t[11] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('empleados')->insert( $temp );
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
    public function descargar_plantilla_empleados(Request $request)
    {
            $nombre_archivo= 'plantilla_empleados.xlsx';

            $title[]= [  "Nombre"
                        ,"Direccion"
                        ,"Telefono"
                        ,"Email"
                        ,"Fecha_Ingreso"
                        ,"Puesto"
                        ,"Salario"
                        ,"Jornada"
                        ,"Especialidades"
                        ,"Certificaciones"
                        ,"Usuario"
                        ,"Contrasenia"
                        ,"Estado"
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
    public function get_empleados_by_id(Request $request)
    {
        $data= empleados::select('nombre'
                                    , 'direccion'
                                    , 'telefono'
                                    , 'email'
                                    , 'fecha_ingreso'
                                    , 'puesto'
                                    , 'salario'
                                    , 'jornada'
                                    , 'especialidades'
                                    , 'certificaciones'
                                    , 'usuario'
                                    , 'contrasenia'
                                    , 'estado'
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
    public function get_cat_empleados(Request $request)
    {
        $data= empleados::select(  'id'
                                    , 'nombre'
                                    , 'direccion'
                                    , 'telefono'
                                    , 'email'
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
    public function get_empleados_diez(Request $request)
    {
        if(!\Schema::hasTable('empleados')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("empleados")
        ->select("id"
            , "nombre"
            , "direccion"
            , "telefono"
            , "email"
            , "fecha_ingreso"
            , "puesto"
            , "salario"
        )
        ->where("empleados.b_status", ">", 0)
        ->limit(50)
        ->orderBy("empleados.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'nombre'=>$value->nombre
                                , 'direccion'=>$value->direccion
                                , 'telefono'=>$value->telefono
                                , 'email'=>$value->email
                                , 'fecha_ingreso'=>$value->fecha_ingreso
                                , 'puesto'=>$value->puesto
                                , 'salario'=>$value->salario
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
    public function get_empleados_by_list(Request $request)
    {
        if(!\Schema::hasTable('empleados')){
            return json_encode(array("data"=>"" ));
        }

        $data= empleados::select(  "id"
                                    , "nombre"
                                    , "direccion"
                                    , "telefono"
                                    , "email"
                                    , "fecha_ingreso"
                                    , "puesto"
                                    , "salario"
                                    , "jornada"
                                    , "especialidades"
                                    , "certificaciones"
                                    , 'usuario'
                                    , 'contrasenia'
                                    , 'estado'
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->nombre
                                , $value->direccion
                                , $value->telefono
                                , $value->email
                                , $value->fecha_ingreso
                                , $value->puesto
                                , $value->salario
                                , $value->jornada
                                , $value->especialidades
                                , $value->certificaciones
                                , $value->usuario
                                , $value->contrasenia
                                , $value->estado
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
    public function export_excel_empleados(Request $request){

        if(!\Schema::hasTable('empleados')){
            return json_encode(array("data"=>"" ));
        }

        $data= empleados::select("id"
                                    , "nombre"
                                    , "direccion"
                                    , "telefono"
                                    , "email"
                                    , "fecha_ingreso"
                                    , "puesto"
                                    , "salario"
                                    , "jornada"
                                    , "especialidades"
                                    , "certificaciones"
                                    , 'usuario'
                                    , 'contrasenia'
                                    , 'estado'
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->nombre
                                    , $value->direccion
                                    , $value->telefono
                                    , $value->email
                                    , $value->fecha_ingreso
                                    , $value->puesto
                                    , $value->salario
                                    , $value->jornada
                                    , $value->especialidades
                                    , $value->certificaciones
                                    , $value->usuario
                                    , $value->contrasenia
                                    , $value->estado
                );
            }

            $nombre_archivo= 'Reporte_de_empleados.xlsx';

            $title[]= [  "id"
                        ,"Nombre"
                        ,"Direccion"
                        ,"Telefono"
                        ,"Email"
                        ,"Fecha_Ingreso"
                        ,"Puesto"
                        ,"Salario"
                        ,"Jornada"
                        ,"Especialidades"
                        ,"Certificaciones"
                        ,"Usuario"
                        ,"Contrasenia"
                        ,"Estado"
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
    public function delete_empleados(Request $request)
    {
        $id=$request->id;
        empleados::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_empleados(Request $request)
    {
        $id=$request->id;
        empleados::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_empleados()
    {
        empleados::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_empleados()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_empleados` ');
    }
}
