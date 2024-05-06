<?php

namespace App\Lib;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SkynetController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LibCore
{

    public $key='test_key';

    function getConfig()
    {
        return $this->key;
    }

    public function hasTable($table='')
    {
        if(!\Schema::hasTable($table))
            return json_encode(array("b_status"=> true, "vc_message" => "No se encontro la tabla %name_strtolower%"));
        
        return false;
    }

    public function setSkynet($params)
    {
        if ( !isset($params['vc_evento']) ){
            return 'vc_evento requerido';
        }

        if ( !isset($params['vc_info']) ){
            return 'vc_info requerido';
        }

        $skynet = new SkynetController();

        if( !empty($params['vc_info']) && is_array($params['vc_info'])) {
            $params['vc_info']= json_encode( $params['vc_info'], JSON_PRETTY_PRINT);
        }

        if ( isset($params['_truncate_']) && $params['_truncate_'] === true){
            $skynet->truncate_Skynet();
        }

        $id_user_o_id_cliente = Auth::id()!== null ? Auth::id() :  0 ;
        $skynet->set_skynet( [ 'vc_evento'=> $params['vc_evento'], 'vc_info' => $params['vc_info'], 'id_user_o_id_cliente' => $id_user_o_id_cliente ] );
    }

    public function date_format($dt)
    {
        $fecha= date('Y-m-d', strtotime('-1 days'));
        $dt= explode('a', $dt);
        $dt_ini= $dt[0];
        $dt_fin= count($dt) > 1 ? $dt[1]: $dt[0];

        return ! empty($dt[0]) && ! empty($dt[1]) 
        ? [ 'dt_ini' => trim($dt_ini), 'dt_fin' => trim($dt_fin)]
        : [ 'dt_ini' => trim($fecha), 'dt_fin' => trim($fecha)] ;
    }

    public function div_hora($hora, $divisor)
    {
        list($horas, $minutos, $segundos) = explode(":", $hora);
        $minutos += $horas * 60;
        $segundos += $minutos * 60;
        date_default_timezone_set("America/Mexico_City");
        return date("i:s", $segundos / $divisor);
    }

    public function sum_time($time1, $time2)
    {
          $times = array($time1, $time2);
          $seconds = 0;
          foreach ($times as $time)
          {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
          }
          $hours = floor($seconds/3600);
          $seconds -= $hours*3600;
          $minutes  = floor($seconds/60);
          $seconds -= $minutes*60;
          if($seconds < 9)
          {
          $seconds = "0".$seconds;
          }
          if($minutes < 9)
          {
          $minutes = "0".$minutes;
          }
          if($hours < 9)
          {
          $hours = "0".$hours;
          }
          return "{$hours}:{$minutes}:{$seconds}";
    }

    public function decimal($time)
    {
        $hms = explode(":", $time);
        return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
    }

    public function getLastNDays($days, $format = 'd/m')
    {
        $m = date("m"); $de= date("d"); $y= date("y");
        $dateArray = array();
        for($i=0; $i<=$days-1; $i++){
            $fecha= date($format, mktime(0,0,0,$m,($de-$i),$y));
            $begin = new \DateTime( $fecha );
            $formato_fecha = date_format($begin,"d M Y");
            $d= Carbon::parse($formato_fecha)->locale('es');
            $dateArray[$d->day ." ". Str::ucfirst($d->shortMonthName) ." ".$d->year] = $fecha;
        }
        return array_reverse($dateArray);
    }

    public function getSinDomingo($days, $format = 'd/m')
    {
        $m = date("m"); $de= date("d"); $y= date("y");
        $dateArray = array();
        for($i=0; $i<=$days-1; $i++){
            
            $fecha= date($format, mktime(0,0,0,$m,($de-$i),$y)); 
            $begin = new \DateTime( $fecha );
            $dia = date_format($begin,"D");

            if ($dia !== "Sun"){
                $formato_fecha = date_format($begin,"d M");
                $dateArray[$formato_fecha] = $fecha;
            }
        }
        return $dateArray;
    }

    public function f_rango_fechas( $dt_ini, $dt_fin)
    {
        $begin = new \DateTime( $dt_ini );
        $end   = new \DateTime( $dt_fin );

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $fecha= $i->format("Y-m-d");
            $begin = new \DateTime( $fecha );
            $formato_fecha = date_format($begin,"d M Y");
            $arr[$formato_fecha]= $fecha;
        }

        return $arr;
    }

    public function if_exists_sp($store_procedure, $rehacer)
    {
        // Si es false, simplemente no hacer ni el intento...
        if ($rehacer === false ) return;

        try {
            DB::select("show create procedure ".$store_procedure);

            $rehacer= empty($rehacer) ? false: $rehacer;
            if ($rehacer === true){
                try{
                    DB::select("drop procedure if exists ".$store_procedure);
                    DB::select("show create procedure ".$store_procedure);
                }catch(\Illuminate\Database\QueryException $ex){
                    DB::select("drop procedure ".$store_procedure);
                    $sp_sql= file_get_contents(public_path()."/".$store_procedure.".sql");
                    DB::statement($sp_sql);                    
                }
            }
        } catch(\Illuminate\Database\QueryException $ex){

            $sp_sql= file_get_contents(public_path()."/".$store_procedure.".sql");
            DB::statement($sp_sql);
        }
    }


    public function eliminar_archivo_ya_exportado(Request $request)
    {
        if ( isset($request->nombre_archivo) && Storage::exists( 'public/'.$request->nombre_archivo )){

            $status_delete= Storage::delete( 'public/'.$request->nombre_archivo );

            $this->LibCore->setSkynet( [  'vc_evento'=> 'eliminar_archivo_ya_exportado_1' 
                                        , 'vc_info'  => 'public/'.$request->nombre_archivo  ."\n<b>status_delete:</b>".$status_delete
            ] );

            return $request->nombre_archivo;

        }else{

            $this->LibCore->setSkynet( [ 'vc_evento'=> 'eliminar_archivo_ya_exportado_0' 
                                        ,'vc_info'  => '<b>No se encontro el Archivo</b> <br>' 
            ] );

        }
    }

    public function crear_archivos($arr)
    {
        // Archivo donde se guardan los datos para formar el Excel
        if (Storage::exists('public/json_data.json')){
            Storage::disk('public')->put('json_data.json', json_encode($arr));
        }else{
            Storage::disk('public')->put('json_data.json', json_encode($arr));
        }
    }

    public function crear_archivos_hoja2($arr)
    {
        // Archivo donde se guardan los datos para formar el Excel
        if (Storage::exists('public/json_data_hoja_2.json')){
            Storage::disk('public')->put('json_data_hoja_2.json', json_encode($arr));
        }else{
            Storage::disk('public')->put('json_data_hoja_2.json', json_encode($arr));
        }
    }

    public function hora_a_minutos($hora)
    {
        $hora= date_create($hora);
        return ((date_format($hora,"H") * 60 + (date_format($hora,"i") * 60 / 60) + date_format($hora,"s") / 60) / 60);        
    }

    public function promedio_horas($horas)
    {
        $horas= substr(trim($horas), 0, -1);

        $arreglo   = explode(",", $horas);
        $resultado = 0;

        foreach($arreglo AS $tiempo)
        {
            $resultado += strtotime($tiempo) - strtotime("TODAY");
        }

        $resultado = $resultado / count($arreglo) ;

        return gmdate("H:i:s", $resultado);
    }

    public function sumar_horas($horas)
    {
        $cadena    = $horas;
        $arreglo   = explode(",", $cadena);
        $resultado = 0;

        foreach($arreglo AS $tiempo)
        {
            $hora= date_create($tiempo);
            $r= ((date_format($hora,"H") * 60 + (date_format($hora,"i") * 60 / 60) + date_format($hora,"s") / 60) / 60);
            $hrs[]= number_format( (float) $r, 1, ".", "");
        }

        return array_sum($hrs) ;
    }

    public function sumar_tiempo($cadena)
    {

        $arreglo   = explode(",",$cadena);
        $resultado = 0;

        foreach($arreglo AS $tiempo)
        {
            $formato= explode(":", $tiempo);
            $r= (( $formato[0] * 60 + ($formato[1] * 60 / 60) + $formato[2] / 60) / 60);
            $hrs[]= number_format( (float) $r,1,".","");
        }

        return array_sum($hrs) ;
    }

    public function restar_dia($restar_dia)
    {
        $tomorrow = Carbon::now()->addDay($restar_dia) ;
        return $tomorrow->locale('es_MX')->isoFormat('dddd');        
    }


}