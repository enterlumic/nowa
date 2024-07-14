<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\carritoSendMail as FncarritoSendMail;
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
use App\Models\carrito;
use App\Lib\LibCore;
use Session;

class CarritoController extends Controller
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
    | Todo es controlado por JS carrito.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_carrito' , 'vc_info' => "index - carrito" ] );
        return view('carrito');
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS carrito.js
    |
    */
    public function carrito_agregado(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $idProducto = Crypt::decrypt($request->product_id); // Asegúrate que el nombre del campo sea el correcto

            $cantidadRequest = $request->input('quantity', 1); // Obtiene la cantidad del request, con un valor predeterminado de 1

            $carritoBD = DB::table('carrito')
                ->where('user_id', $userId)
                ->where('producto_id', $idProducto)
                ->first();

            if ($carritoBD) {
                // Si el producto ya existe en el carrito, incrementar la cantidad
                DB::table('carrito')
                    ->where('user_id', $userId)
                    ->where('producto_id', $idProducto)
                    ->update([
                        'cantidad' => $carritoBD->cantidad + $cantidadRequest,
                        'agregado_en' => now(),
                    ]);
            } else {
                // Si el producto no existe en el carrito, insertar un nuevo registro
                DB::table('carrito')->insert([
                    'user_id' => $userId,
                    'producto_id' => $idProducto,
                    'cantidad' => $cantidadRequest,
                    'agregado_en' => now(),
                ]);
            }

            // Calcular el nuevo total del carrito
            $nuevoTotalCarrito = DB::table('carrito as c')
                ->join('productos as p', function($join) {
                    $join->on('p.id', '=', 'c.producto_id')
                         ->where('p.b_status', '>', 0);
                })
                ->where('c.user_id', $userId)
                ->count();

            return response()->json([
                'b_status' => true, 
                'message' => 'Producto añadido al carrito', 
                'cartTotal' => $nuevoTotalCarrito  // Envía el total actualizado del carrito
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'b_status' => false, 
                'message' => 'Error al añadir producto al carrito', 
                'error' => $e->getMessage()
            ]);
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_carrito_datatable(Request $request)
    {
        if(!\Schema::hasTable('carrito')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_user_id) && !empty($request->buscar_user_id) )
            || ( isset($request->buscar_producto_id) && !empty($request->buscar_producto_id) )
            || ( isset($request->buscar_cantidad) && !empty($request->buscar_cantidad) )
            || ( isset($request->buscar_agregado_en) && !empty($request->buscar_agregado_en) )
            || ( isset($request->buscar_estado) && !empty($request->buscar_estado) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_user_id= isset($request->buscar_user_id) ? $request->buscar_user_id :'';
        $buscar_producto_id= isset($request->buscar_producto_id) ? $request->buscar_producto_id :'';
        $buscar_cantidad= isset($request->buscar_cantidad) ? $request->buscar_cantidad :'';
        $buscar_agregado_en= isset($request->buscar_agregado_en) ? $request->buscar_agregado_en :'';
        $buscar_estado= isset($request->buscar_estado) ? $request->buscar_estado :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_carrito(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_user_id.'"
            , "'.$buscar_producto_id.'"
            , "'.$buscar_cantidad.'"
            , "'.$buscar_agregado_en.'"
            , "'.$buscar_estado.'"
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
    public function set_carrito(Request $request)
    {
        $userId = $request->user()->id;
        $idProducto = Crypt::decrypt($request->id);
        $cantidad = $request->cantidad ?? 1;  // Usar la cantidad del request o 1 si no se proporciona

        // Buscar en la base de datos si ya existe un registro para este usuario y producto
        $carrito = DB::table('carrito')
                     ->where('user_id', $userId)
                     ->where('producto_id', $idProducto)
                     ->first();

        if ($carrito) {
            // Si el producto ya existe en el carrito, incrementar la cantidad
            DB::table('carrito')
              ->where('user_id', $userId)
              ->where('producto_id', $idProducto)
              ->update([
                  'cantidad' => $carrito->cantidad + $cantidad,  // Incrementar la cantidad existente
                  'agregado_en' => now(),  // Opcional: actualizar la fecha de 'agregado_en'
              ]);
        } else {
            // Si el producto no existe en el carrito, insertar un nuevo registro
            DB::table('carrito')->insert([
                'user_id' => $userId,
                'producto_id' => $idProducto,
                'cantidad' => $cantidad,
                'agregado_en' => now(),
            ]);
        }

        $token = Str::random(40);
        session(['add_to_cart_token' => $token]);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito correctamente.',
            'token' => $token
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Validar existencia antes de crear un nuevo registro
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function validar_existencia_carrito(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= carrito::select('user_id')
            ->where('user_id' ,'=', trim($request->user_id))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= carrito::select('user_id')
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
    public function set_import_carrito(Request $request)
    {
        if(!\Schema::hasTable('carrito')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_carrito' , 'vc_info' => "set_import_carrito" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['user_id'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            carrito::truncate();
            carrito::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSidecarrito(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('carrito')
            ->Where('id', ' > ', 0)
            ->OrWhere('user_id', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", user_id, " ", producto_id ) as user_id')
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
    public function form_importar_carrito(Request $request)
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
                                        ,"producto_id"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"cantidad"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"agregado_en"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"estado"  =>  isset($t[4]) ? $t[4] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('carrito')->insert( $temp );
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
    public function descargar_plantilla_carrito(Request $request)
    {
            $nombre_archivo= 'plantilla_carrito.xlsx';

            $title[]= [  "User_Id"
                        ,"Producto_Id"
                        ,"Cantidad"
                        ,"Agregado_En"
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
    public function get_carrito_by_id(Request $request)
    {
        $data= carrito::select('user_id'
                                    , 'producto_id'
                                    , 'cantidad'
                                    , 'agregado_en'
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
    public function get_cat_carrito(Request $request)
    {
        $data= carrito::select(  'id'
                                    , 'user_id'
                                    , 'producto_id'
                                    , 'cantidad'
                                    , 'agregado_en'
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
    public function get_carrito_diez(Request $request)
    {
        if(!\Schema::hasTable('carrito')){
            return json_encode(array("data"=>"" ));
        }

        $data= DB::table("carrito")
        ->select("id"
            , "user_id"
            , "producto_id"
            , "cantidad"
            , "agregado_en"
            , "estado"
        )
        ->where("carrito.b_status", ">", 0)
        ->limit(50)
        ->orderBy("carrito.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
                                , 'user_id'=>$value->user_id
                                , 'producto_id'=>$value->producto_id
                                , 'cantidad'=>$value->cantidad
                                , 'agregado_en'=>$value->agregado_en
                                , 'estado'=>$value->estado
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
    public function get_carrito_by_list(Request $request)
    {
        if(!\Schema::hasTable('carrito')){
            return json_encode(array("data"=>"" ));
        }

        $data= carrito::select(  "id"
                                    , "user_id"
                                    , "producto_id"
                                    , "cantidad"
                                    , "agregado_en"
                                    , "estado"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->user_id
                                , $value->producto_id
                                , $value->cantidad
                                , $value->agregado_en
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
    public function export_excel_carrito(Request $request){

        if(!\Schema::hasTable('carrito')){
            return json_encode(array("data"=>"" ));
        }

        $data= carrito::select("id"
                                    , "user_id"
                                    , "producto_id"
                                    , "cantidad"
                                    , "agregado_en"
                                    , "estado"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->user_id
                                    , $value->producto_id
                                    , $value->cantidad
                                    , $value->agregado_en
                                    , $value->estado
                );
            }

            $nombre_archivo= 'Reporte_de_carrito.xlsx';

            $title[]= [  "id"
                        ,"User_Id"
                        ,"Producto_Id"
                        ,"Cantidad"
                        ,"Agregado_En"
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
    public function delete_carrito(Request $request)
    {
        $id=$request->id;
        carrito::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_carrito(Request $request)
    {
        $id=$request->id;
        carrito::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_carrito()
    {
        carrito::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar Store procedures
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_sps_carrito()
    {
        // Eliminar el SP
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_carrito` ');
    }
}
