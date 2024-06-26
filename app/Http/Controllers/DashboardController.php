<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Notifications\dashboardSendMail as FndashboardSendMail;
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
use App\Models\dashboard;
use App\Models\promociones;
use App\Lib\LibCore;
use Session;

class DashboardController extends Controller
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
    | Todo es controlado por JS dashboard.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_dashboard' , 'vc_info' => "index - dashboard" ] );

        $promociones = DB::select("
            SELECT p.id, titulo, foto_url AS foto, descripcion, precio, marca, review, cantidad, color, precio_anterior, target
            FROM promociones p
            JOIN promocion_fotos pf ON pf.promocion_id = p.id AND pf.size = 'medium' AND pf.`order` = 0
            WHERE p.b_status > 0
            LIMIT 0, 10
        ");

        return view('dashboard', compact('promociones'));
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $perPage = 10;
            $offset = ($page - 1) * $perPage;
            $layout = $request->input('layout', 'grid');

            $promociones = DB::select("
                SELECT p.id, titulo, foto_url AS foto, descripcion, precio, marca, review, cantidad, color, precio_anterior, target
                FROM promociones p
                JOIN promocion_fotos pf ON pf.promocion_id = p.id AND pf.size = 'small' AND pf.`order` = 0
                WHERE p.b_status > 0
                LIMIT $offset, $perPage
            ");

            $view = $layout == 'list' ? 'promociones.partials.promociones-list' : 'promociones.partials.promociones-grid';

            return view($view, compact('promociones'))->render();
        }
    }

}