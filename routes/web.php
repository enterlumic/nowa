<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\marcasController;
Route::get('marcas', [marcasController::class, 'index'])->middleware('auth') ;
Route::post('set_marcas', [marcasController::class, 'set_marcas']);
Route::post('set_import_marcas', [marcasController::class, 'set_import_marcas']);
Route::post('delete_marcas', [marcasController::class, 'delete_marcas']);
Route::post('undo_delete_marcas', [marcasController::class, 'undo_delete_marcas']);
Route::get('get_marcas_datatable', [marcasController::class, 'get_marcas_datatable']);
Route::post('truncate_marcas', [marcasController::class, 'truncate_marcas']);
Route::post('truncate_sps_marcas', [marcasController::class, 'truncate_sps_marcas']);
Route::post('form_importar_marcas', [marcasController::class, 'form_importar_marcas']);
Route::get('export_excel_marcas', [marcasController::class, 'export_excel_marcas']);
Route::post('get_cat_marcas', [marcasController::class, 'get_cat_marcas']);
Route::post('get_marcas_by_list', [marcasController::class, 'get_marcas_by_list']);
Route::get('get_marcas_diez', [marcasController::class, 'get_marcas_diez']);
Route::get('descargar_plantilla_marcas', [marcasController::class, 'descargar_plantilla_marcas']);
Route::get('validar_existencia_marcas', [marcasController::class, 'validar_existencia_marcas']);


use App\Http\Controllers\ClienteConektaController;
Route::get('cliente_conekta', [ClienteConektaController::class, 'index'])->middleware('auth') ;
Route::post('set_cliente_conekta', [ClienteConektaController::class, 'set_cliente_conekta']);
Route::post('set_import_cliente_conekta', [ClienteConektaController::class, 'set_import_cliente_conekta']);
Route::post('get_cliente_conekta_by_id', [ClienteConektaController::class, 'get_cliente_conekta_by_id']);
Route::post('delete_cliente_conekta', [ClienteConektaController::class, 'delete_cliente_conekta']);
Route::post('undo_delete_cliente_conekta', [ClienteConektaController::class, 'undo_delete_cliente_conekta']);
Route::get('get_cliente_conekta_datatable', [ClienteConektaController::class, 'get_cliente_conekta_datatable']);
Route::post('get_cat_cliente_conekta', [ClienteConektaController::class, 'get_cat_cliente_conekta']);
Route::get('validar_existencia_cliente_conekta', [ClienteConektaController::class, 'validar_existencia_cliente_conekta']);

Route::delete('cliente_conekta/{customerId}', [ClienteConektaController::class, 'deleteCustomer']);















use App\Http\Controllers\PromocionesController;
Route::get('promociones', [PromocionesController::class, 'index'])->middleware('auth') ;
Route::post('set_promociones', [PromocionesController::class, 'set_promociones']);
Route::post('set_import_promociones', [PromocionesController::class, 'set_import_promociones']);
Route::post('get_promociones_by_id', [PromocionesController::class, 'get_promociones_by_id']);
Route::post('delete_promociones', [PromocionesController::class, 'delete_promociones']);
Route::post('undo_delete_promociones', [PromocionesController::class, 'undo_delete_promociones']);
Route::get('get_promociones_datatable', [PromocionesController::class, 'get_promociones_datatable']);
Route::post('truncate_promociones', [PromocionesController::class, 'truncate_promociones']);
Route::post('truncate_sps_promociones', [PromocionesController::class, 'truncate_sps_promociones']);
Route::post('form_importar_promociones', [PromocionesController::class, 'form_importar_promociones']);
Route::get('export_excel_promociones', [PromocionesController::class, 'export_excel_promociones']);
Route::post('get_cat_promociones', [PromocionesController::class, 'get_cat_promociones']);
Route::post('get_promociones_by_list', [PromocionesController::class, 'get_promociones_by_list']);
Route::get('get_promociones_diez', [PromocionesController::class, 'get_promociones_diez']);
Route::get('descargar_plantilla_promociones', [PromocionesController::class, 'descargar_plantilla_promociones']);
Route::get('validar_existencia_promociones', [PromocionesController::class, 'validar_existencia_promociones']);

use App\Http\Controllers\DetalleController;
Route::get('detalle', [DetalleController::class, 'index'])->middleware('auth') ;
Route::post('set_detalle', [DetalleController::class, 'set_detalle']);
Route::post('set_import_detalle', [DetalleController::class, 'set_import_detalle']);
Route::post('get_detalle_by_id', [DetalleController::class, 'get_detalle_by_id']);
Route::post('delete_detalle', [DetalleController::class, 'delete_detalle']);
Route::post('undo_delete_detalle', [DetalleController::class, 'undo_delete_detalle']);
Route::get('get_detalle_datatable', [DetalleController::class, 'get_detalle_datatable']);
Route::post('truncate_detalle', [DetalleController::class, 'truncate_detalle']);
Route::post('truncate_sps_detalle', [DetalleController::class, 'truncate_sps_detalle']);
Route::post('form_importar_detalle', [DetalleController::class, 'form_importar_detalle']);
Route::get('export_excel_detalle', [DetalleController::class, 'export_excel_detalle']);
Route::post('get_cat_detalle', [DetalleController::class, 'get_cat_detalle']);
Route::post('get_detalle_by_list', [DetalleController::class, 'get_detalle_by_list']);
Route::get('get_detalle_diez', [DetalleController::class, 'get_detalle_diez']);
Route::get('descargar_plantilla_detalle', [DetalleController::class, 'descargar_plantilla_detalle']);
Route::get('validar_existencia_detalle', [DetalleController::class, 'validar_existencia_detalle']);

