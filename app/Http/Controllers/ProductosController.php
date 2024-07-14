<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\productosSendMail as FnproductosSendMail;
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
use App\Models\productos;
use App\Lib\LibCore;
use Session;
use Spatie\Image\Image;

class ProductosController extends Controller
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
    | Todo es controlado por JS productos.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_productos' , 'vc_info' => "index - productos" ] );

        $productos = Productos::where('b_status', '>', 0)->orderBy('id', 'desc')->get();

        return view('productos', compact('productos'));

    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_productos_datatable(Request $request)
    {
        if(!\Schema::hasTable('productos')){
            return json_encode(array("data"=>"" ));
        }

        if (   ( isset($request->buscar_titulo) && !empty($request->buscar_titulo) )
            || ( isset($request->buscar_descripcion) && !empty($request->buscar_descripcion) )
            || ( isset($request->buscar_precio) && !empty($request->buscar_precio) )
            || ( isset($request->buscar_marca) && !empty($request->buscar_marca) )
            || ( isset($request->buscar_review) && !empty($request->buscar_review) )
            || ( isset($request->buscar_cantidad) && !empty($request->buscar_cantidad) )
            || ( isset($request->buscar_color) && !empty($request->buscar_color) )
            || ( isset($request->buscar_precio_refaccion) && !empty($request->buscar_precio_refaccion) )
            || ( isset($request->buscar_target) && !empty($request->buscar_target) )
        ){
            $buscar= 0;
        }else{
            $buscar= 1;
        }

        $request->search= isset($request->search["value"]) ? $request->search["value"] : '';
        $buscar_titulo= isset($request->buscar_titulo) ? $request->buscar_titulo :'';
        $buscar_descripcion= isset($request->buscar_descripcion) ? $request->buscar_descripcion :'';
        $buscar_precio= isset($request->buscar_precio) ? $request->buscar_precio :'';
        $buscar_marca= isset($request->buscar_marca) ? $request->buscar_marca :'';
        $buscar_review= isset($request->buscar_review) ? $request->buscar_review :'';
        $buscar_cantidad= isset($request->buscar_cantidad) ? $request->buscar_cantidad :'';
        $buscar_color= isset($request->buscar_color) ? $request->buscar_color :'';
        $buscar_precio_refaccion= isset($request->buscar_precio_refaccion) ? $request->buscar_precio_refaccion :'';
        $buscar_target= isset($request->buscar_target) ? $request->buscar_target :'';
        $request->start = isset($request->start) ? $request->start : intval(0);
        $request->length= isset( $request->length) ? $request->length : intval(10);
        $request->column= isset( $request->order[0]['column']) ? $request->order[0]['column'] : intval(0);
        $request->order= isset( $request->order[0]['dir']) ? $request->order[0]['dir'] : 'DESC';

        // Lógica para invocar el procedimiento almacenado
        $sql= 'CALL sp_get_productos(
               '.$buscar.'
            , "'.$request->search.'"
            , "'.$buscar_titulo.'"
            , "'.$buscar_descripcion.'"
            , "'.$buscar_precio.'"
            , "'.$buscar_marca.'"
            , "'.$buscar_review.'"
            , "'.$buscar_cantidad.'"
            , "'.$buscar_color.'"
            , "'.$buscar_precio_refaccion.'"
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
    public function set_productos(Request $request)
    {
        if (!\Schema::hasTable('productos')) {
            Notification::route('mail', ['odin0464@gmail.com'])->notify(
                new FnproductosSendMail(
                    'Notificación no existe tabla productos',
                    __DIR__ . "\n"
                )
            );
            return json_encode(array("b_status" => false, "vc_message" => "No se encontró la tabla productos"));
        }

        // Guardar en la bd
        $data = [
            'titulo' => isset($request->titulo) ? $request->titulo : "",
            'descripcion' => isset($request->descripcion) ? $request->descripcion : "",
            'precio' => $request->precio,
            'marca' => isset($request->marca) ? $request->marca : "",
            'review' => isset($request->review) ? $request->review : "",
            'cantidad' => intval($request->cantidad),
            'color' => isset($request->color) ? $request->color : "",
            'precio_refaccion' => isset($request->precio_refaccion) ? $request->precio_refaccion : "",
            'target' => isset($request->target) ? $request->target : "",
            'tiempo_trabajador' => isset($request->tiempo_trabajador) ? $request->tiempo_trabajador : 0,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)) {
            DB::table('productos')->where('id', $request->id)->update($data);
            $this->fnFotosUpload($request, $request->id);
            return json_encode(array("b_status" => true, "vc_message" => "Actualizado correctamente..."));
        } else { // Nuevo registro
            $id = DB::table('productos')->insertGetId($data);
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
            $uploadDirectory = 'uploads/productos/';

            // Crear el directorio si no existe
            if (!file_exists(public_path($uploadDirectory))) {
                mkdir(public_path($uploadDirectory), 0755, true);
            }

            // Guardar las imágenes en el directorio
            $storedFiles = [];
            $_index= 0;
            foreach ($fotosUpload as $fotoInicial => $file) {
                $conjunto = time() .'_'.$_index ;
                $fileName = $conjunto . '_' . $file->getClientOriginalName();

                // Redimensionar y optimizar la imagen
                $imagePath = public_path($uploadDirectory . $fileName);
                Image::load($file->getPathname())
                    ->width(600)
                    ->optimize()
                    ->save($imagePath);

                // Original
                $data = [
                    [
                        'producto_id' => $promocionId,
                        'conjunto' => $conjunto,
                        'order' => $_index,
                        'size' => 'original',
                        'foto_url' => $fileName,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ];

                DB::table('productos_fotos')->insert($data);

                $storedFiles[] = $uploadDirectory . $fileName;

                // Crear diferentes tamaños
                $sizes = [
                    'small' => 100,
                    'medium' => 300,
                    'large' => 600
                ];

                $order_n = 1;
                foreach ($sizes as $sizeName => $size) {
                    $resizedFileName = $sizeName . '_' . $fileName;
                    $resizedImagePath = public_path($uploadDirectory . $resizedFileName);

                    Image::load($file->getPathname())
                        ->width($size)
                        ->optimize()
                        ->save($resizedImagePath);

                    $data = [
                        [
                            'producto_id' => $promocionId,
                            'conjunto' => $conjunto,
                            'order' => $_index,
                            'size' => $sizeName,
                            'foto_url' => $resizedFileName,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    ];

                    $order_n ++ ;

                    DB::table('productos_fotos')->insert($data);

                    $storedFiles[] = $uploadDirectory . $resizedFileName;
                }
                $_index ++;
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
    public function validar_existencia_productos(Request $request)
    {
        if ( isset($request->id) && $request->id > 0){
            $data= productos::select('titulo')
            ->where('titulo' ,'=', trim($request->titulo))
            ->where('id' ,'<>', $request->id)
            ->where('b_status' ,'>', 0)
            ->get();
        }else{
            $data= productos::select('titulo')
            ->where('titulo' ,'=', trim($request->titulo))
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
    | Validar existencia antes de crear un nuevo registro
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function productCart(Request $request)
    {
        
        $baseURL = url('/uploads/productos'); // Asegúrate de que esta URL coincida con tu configuración

        // Realiza la consulta utilizando Query Builder
        $productos = DB::table('carrito as c')
            ->join('productos as p', 'c.producto_id', '=', 'p.id')
            ->join('productos_fotos as pf', function($join) {
                $join->on('pf.producto_id', '=', 'p.id')
                     ->where('pf.order', '=', 0)
                     ->where('pf.size', '=', 'small');
            })
            ->select(
                'p.titulo', 
                'c.cantidad', 
                DB::raw("CAST(REPLACE(p.precio, ',', '') AS UNSIGNED) as precio"), 
                DB::raw("CONCAT('$baseURL/', pf.foto_url) as foto_url")
            )
            ->where('p.b_status', '>', 0)
            ->orderBy('p.id', 'desc')
            ->get();

        $carrito =  Crypt::encrypt('carrito');

        // Retorna la vista con los productos obtenidos
        return view('productos.partials.product-cart', compact('productos', 'carrito'));

    }


    public function joder(Request $request)
    {
        $baseURL = url('/uploads/productos');

        $productos = DB::table('carrito as c')
            ->leftJoin('productos as p', 'c.producto_id', '=', 'p.id')
            ->leftJoin('productos_fotos as pf', function($join) {
                $join->on('pf.producto_id', '=', 'p.id')
                     ->where('pf.order', '=', 0)
                     ->where('pf.size', '=', 'small');
            })
            ->select('c.id', 'p.titulo', 'c.cantidad', DB::raw("CAST(REPLACE(p.precio, ',', '') AS UNSIGNED) as precio"), DB::raw("CONCAT('$baseURL/', pf.foto_url) as foto_url"))
            ->where('p.b_status', '>', 0)
            ->orderBy('p.id', 'desc')
            ->get();

        return response()->json($productos);
    }

    public function updateQuantity(Request $request)
    {
        DB::table('carrito')
            ->where('id', $request->id)
            ->update([
                'cantidad' => $request->cantidad
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_productos(Request $request)
    {
        if(!\Schema::hasTable('productos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_productos' , 'vc_info' => "set_import_productos" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
        $arr = array_reverse($arr);
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            if (!empty($line)){
                $data[]=  ['titulo'=> trim($line)] ;
            }
        }

        if (isset($data) && !empty($data)){
            productos::truncate();
            productos::insert($data);
            return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
        }
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros..."));
    }

      public function getServerSideproductos(Request $request)
    {
        $buscarPor = $request->input('search', ''); 

        $results = DB::table('productos')
            ->Where('id', ' > ', 0)
            ->OrWhere('descripcion', 'LIKE', '%' . $buscarPor . '%')
            ->select('id'
                , DB::raw('CONCAT(id, " ", descripcion, " ", titulo ) as titulo')
            )
            ->limit(10)
            ->get();

        // Formatea los resultados para el selectpicker
        $options = $results->map(function ($item) {
            return ['id' => $item->id, 'titulo' =>Str::headline($item->titulo) ];
        });

        return response()->json($options);
    } 

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function form_importar_productos(Request $request)
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

                $data_insert[]=  array(  "titulo"  =>  isset($t[1]) ? $t[1] : ''
                                        ,"descripcion"  =>  isset($t[2]) ? $t[2] : ''
                                        ,"precio"  =>  isset($t[3]) ? $t[3] : ''
                                        ,"marca"  =>  isset($t[4]) ? $t[4] : ''
                                        ,"review"  =>  isset($t[5]) ? $t[5] : ''
                                        ,"cantidad"  =>  isset($t[6]) ? $t[6] : ''
                                        ,"color"  =>  isset($t[7]) ? $t[7] : ''
                                        ,"precio_refaccion"  =>  isset($t[8]) ? $t[8] : ''
                                        ,"target"  =>  isset($t[9]) ? $t[9] : ''
                );
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('productos')->insert( $temp );
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
    public function descargar_plantilla_productos(Request $request)
    {
            $nombre_archivo= 'plantilla_productos.xlsx';

            $title[]= [  "Titulo"
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
    | fn_update_productos
    |
    */
    public function get_productos_by_id(Request $request)
    {
        $data= productos::select(   'titulo'
                                    , 'descripcion'
                                    , 'precio'
                                    , 'marca'
                                    , 'review'
                                    , 'cantidad'
                                    , 'color'
                                    , 'precio_refaccion'
                                    , 'tiempo_trabajador'
                                    , 'target'
        )->where('id', $request->id)->get();


        $promocionId = $request->id;


        $uploadDir = public_path('uploads/productos/');
        $relativeUploadDir = 'uploads/productos/'; // Ruta relativa para usar en la URL
        // Realizar la cosulta a la base de datos
        $fotos = DB::table('productos_fotos')
            ->select('id', 'size', 'foto_url')
            ->where('size', 'original')
            ->where('producto_id', $promocionId)
            ->orderBy('order', 'ASC')
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
    public function get_cat_productos(Request $request)
    {
        $data= productos::select(  'id'
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
    public function get_productos_diez(Request $request)
    {
        if(!\Schema::hasTable('productos')){
            return json_encode(array("data"=>"" ));
        }

        $id_inicio= !is_numeric($request->id_productos) ? 0 : $request->id_productos;
        $id_fin= !is_numeric($request->id_productos) ? 10 : $request->id_productos +10;

        // dd($id_inicio, $id_fin);

        $count = DB::table('productos')->where('b_status', '>', 0)->count();
        $count= ($count -1);
        if ($count == $request->id_productos ){

             file_put_contents(storage_path('logs/laravel.log'), ">>>>>>>>".$request->id_productos. "\n\n\n", FILE_APPEND);        

            return false;
        }

             file_put_contents(storage_path('logs/laravel.log'), $request->id_productos. "\n\n\n", FILE_APPEND);        

        if (isset($request->id_productos) && $request->id_productos > 0){
            $id_productos= $request->id_productos;
        }else{
            $id_productos= 10;
        }

        DB::enableQueryLog();

        $data= DB::table("productos")
        ->select("id"
            , "titulo"
            , "descripcion"
            , "precio"
            , "marca"
            , "review"
            , "cantidad"
        )
        ->where("productos.b_status", ">", 0)
        ->whereBetween("productos.id", [$id_inicio, $id_fin]) // Cambia $id_inicio y $id_fin por los valores deseados
         ->where('b_status', '>', 0)
        ->limit(10)
        ->orderBy("productos.id","desc")
        ->get();

        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    'id'=> $value->id
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
    public function get_productos_by_list(Request $request)
    {
        if(!\Schema::hasTable('productos')){
            return json_encode(array("data"=>"" ));
        }

        $data= productos::select(  "id"
                                    , "titulo"
                                    , "descripcion"
                                    , "precio"
                                    , "marca"
                                    , "review"
                                    , "cantidad"
                                    , "color"
                                    , "precio_refaccion"
                                    , "target"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->titulo
                                , $value->descripcion
                                , $value->precio
                                , $value->marca
                                , $value->review
                                , $value->cantidad
                                , $value->color
                                , $value->precio_refaccion
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
    public function export_excel_productos(Request $request){

        if(!\Schema::hasTable('productos')){
            return json_encode(array("data"=>"" ));
        }

        $data= productos::select(   "id"
                                    , "titulo"
                                    , "descripcion"
                                    , "precio"
                                    , "marca"
                                    , "review"
                                    , "cantidad"
                                    , "color"
                                    , "precio_refaccion"
                                    , "target"
        )->where('b_status', 1)->orderBy('id', 'desc')->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr_data[]= array(   $value->id
                                    , $value->titulo
                                    , $value->descripcion
                                    , $value->precio
                                    , $value->marca
                                    , $value->review
                                    , $value->cantidad
                                    , $value->color
                                    , $value->precio_refaccion
                                    , $value->target
                );
            }

            $nombre_archivo= 'Reporte_de_productos.xlsx';

            $title[]= [  "id"
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
    public function delete_productos(Request $request)
    {
        $id=$request->id;

        $promocionFotos = DB::table('productos_fotos')
                           ->select('foto_url')
                           ->where('producto_id', $id)
                           ->get();

        if (!$promocionFotos->isEmpty()){
            foreach ($promocionFotos as $key => $value) {
                $filePath = public_path('uploads/productos/'.$value->foto_url);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Actualizo status
        productos::where('id', $id)->update(['b_status' => 0]);

        // Borro registros no tiene caso (borro imagenes para liberar espacio)
        DB::table('productos_fotos')
            ->where('producto_id', $id)
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
    public function undo_delete_productos(Request $request)
    {
        $id=$request->id;

        productos::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_productos()
    {
        productos::where('b_status', 1)->update(['b_status' => 0]);        
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


    /*
    |--------------------------------------------------------------------------
    | Eliminar Foto
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function ajax_remove_file(Request $request){
      
        // Ejecutar la consulta
        $resultados = DB::table('productos_fotos as pf')
            ->leftJoin('productos_fotos as pf2', 'pf2.conjunto', '=', 'pf.conjunto')
            ->where('pf.foto_url', $request->file)
            ->select('pf2.conjunto', 'pf2.foto_url')
            ->get();

        // Validar si la consulta devolvió filas
        if ($resultados->isNotEmpty()) {

            $uploadDirectory = 'uploads/productos/';

            // Iterar sobre los resultados
            foreach ($resultados as $resultado) {
                // Eliminar fotos
                unlink( public_path($uploadDirectory . $resultado->foto_url) );

                // Eliminar registro
                DB::table('productos_fotos')
                ->where('conjunto', $resultado->conjunto)
                ->delete();

            }
            return 'Eliminado';
        } else {
            return 'No se encontraron resultados.';
        }      
    }

    /*
    |--------------------------------------------------------------------------
    | Ordenar Foto
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function ajax_sort_files(Request $request){

        $imgs= json_decode($request->_list, true);

        foreach ($imgs as $key => $value) {

            $imagen= $value['name'];
            $index= $value['index'];

            $resultados = DB::table('productos_fotos as pf')
                ->leftJoin('productos_fotos as pf2', 'pf2.conjunto', '=', 'pf.conjunto')
                ->where('pf.foto_url', $imagen)
                ->select('pf2.conjunto', 'pf2.foto_url')
                ->get();

            // Validar si la consulta devolvió filas
            if ($resultados->isNotEmpty()) {

                // Iterar sobre los resultados
                foreach ($resultados as $resultado) {

                    $updated = DB::table('productos_fotos')
                        ->where('conjunto', $resultado->conjunto)
                        ->update(['order' => $index]);

                }

            } else {
                return 'No se encontraron resultados.';
            } 
        }

    }
}
