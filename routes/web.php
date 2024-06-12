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
Route::post('createCustomer', [ClienteConektaController::class, 'createCustomer']);
Route::post('get_cliente_conekta_by_id', [ClienteConektaController::class, 'get_cliente_conekta_by_id']);
Route::post('delete_cliente_conekta', [ClienteConektaController::class, 'delete_cliente_conekta']);
Route::post('undo_delete_cliente_conekta', [ClienteConektaController::class, 'undo_delete_cliente_conekta']);
Route::get('get_cliente_conekta_datatable', [ClienteConektaController::class, 'get_cliente_conekta_datatable']);
Route::delete('cliente_conekta/{customerId}', [ClienteConektaController::class, 'deleteCustomer']);
Route::get('/conekta-key', [ClienteConektaController::class, 'getConektaKey']);
Route::get('fnGetCustomerPaymentSources', [ClienteConektaController::class, 'fnGetCustomerPaymentSources'])->middleware('auth') ;


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
Route::post('/set_python', [PromocionesController::class, 'runPythonScript'])->name('set_python');

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
Route::post('get_detalle_by_list', [DetalleController::class, 'get_detalle_by_list']);
Route::get('get_detalle_diez', [DetalleController::class, 'get_detalle_diez']);
Route::get('descargar_plantilla_detalle', [DetalleController::class, 'descargar_plantilla_detalle']);
Route::get('validar_existencia_detalle', [DetalleController::class, 'validar_existencia_detalle']);
Route::get('/producto/{id}', [DetalleController::class, 'get_data_by_id']);

use App\Http\Controllers\CheckOutController;
Route::get('check_out', [CheckOutController::class, 'index'])->middleware('auth') ;
Route::post('fnCreateOrder', [CheckOutController::class, 'fnCreateOrder']);
Route::post('get_check_out_by_id', [CheckOutController::class, 'get_check_out_by_id']);
Route::post('process-payment', [CheckOutController::class, 'processPayment'])->name('process.payment');
Route::post('fn_getCustomerConekta', [CheckOutController::class, 'fn_getCustomerConekta'])->name('fn_getCustomerConekta');
Route::get('completado', [CheckOutController::class, 'completado'])->middleware('auth') ;


use App\Http\Controllers\SandboxTypesController;
Route::get('sandbox_types', [SandboxTypesController::class, 'index'])->middleware('auth') ;
Route::post('set_sandbox_types', [SandboxTypesController::class, 'set_sandbox_types']);
Route::post('set_import_sandbox_types', [SandboxTypesController::class, 'set_import_sandbox_types']);
Route::post('get_sandbox_types_by_id', [SandboxTypesController::class, 'get_sandbox_types_by_id']);
Route::post('delete_sandbox_types', [SandboxTypesController::class, 'delete_sandbox_types']);
Route::post('undo_delete_sandbox_types', [SandboxTypesController::class, 'undo_delete_sandbox_types']);
Route::get('get_sandbox_types_datatable', [SandboxTypesController::class, 'get_sandbox_types_datatable']);
Route::post('truncate_sandbox_types', [SandboxTypesController::class, 'truncate_sandbox_types']);
Route::post('truncate_sps_sandbox_types', [SandboxTypesController::class, 'truncate_sps_sandbox_types']);
Route::post('form_importar_sandbox_types', [SandboxTypesController::class, 'form_importar_sandbox_types']);
Route::get('export_excel_sandbox_types', [SandboxTypesController::class, 'export_excel_sandbox_types']);
Route::post('get_cat_sandbox_types', [SandboxTypesController::class, 'get_cat_sandbox_types']);
Route::post('get_sandbox_types_by_list', [SandboxTypesController::class, 'get_sandbox_types_by_list']);
Route::get('get_sandbox_types_diez', [SandboxTypesController::class, 'get_sandbox_types_diez']);
Route::get('descargar_plantilla_sandbox_types', [SandboxTypesController::class, 'descargar_plantilla_sandbox_types']);
Route::get('validar_existencia_sandbox_types', [SandboxTypesController::class, 'validar_existencia_sandbox_types']);
Route::post('/sandboxSwitch', [SandboxTypesController::class, 'sandboxSwitch']);

use App\Http\Controllers\LogssController;
Route::get('logss', [LogssController::class, 'index'])->middleware('auth') ;
Route::post('set_logss', [LogssController::class, 'set_logss']);
Route::post('set_import_logss', [LogssController::class, 'set_import_logss']);
Route::post('get_logss_by_id', [LogssController::class, 'get_logss_by_id']);
Route::post('delete_logss', [LogssController::class, 'delete_logss']);
Route::post('undo_delete_logss', [LogssController::class, 'undo_delete_logss']);
Route::get('get_logss_datatable', [LogssController::class, 'get_logss_datatable']);
Route::post('truncate_logss', [LogssController::class, 'truncate_logss']);
Route::post('truncate_sps_logss', [LogssController::class, 'truncate_sps_logss']);
Route::post('form_importar_logss', [LogssController::class, 'form_importar_logss']);
Route::get('export_excel_logss', [LogssController::class, 'export_excel_logss']);
Route::post('get_cat_logss', [LogssController::class, 'get_cat_logss']);
Route::post('get_logss_by_list', [LogssController::class, 'get_logss_by_list']);
Route::get('get_logss_diez', [LogssController::class, 'get_logss_diez']);
Route::get('descargar_plantilla_logss', [LogssController::class, 'descargar_plantilla_logss']);
Route::get('validar_existencia_logss', [LogssController::class, 'validar_existencia_logss']);

