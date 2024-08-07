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

use App\Http\Controllers\PromocionesController;
Route::get('promociones', [PromocionesController::class, 'index'])->middleware('auth') ;

use App\Http\Controllers\DashboardController;
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth') ;
Route::post('/productos/fetch', [DashboardController::class, 'fetch']);

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


use App\Http\Controllers\ProductosController;
Route::get('productos', [ProductosController::class, 'index'])->middleware('auth') ;
Route::post('set_productos', [ProductosController::class, 'set_productos']);
Route::post('set_import_productos', [ProductosController::class, 'set_import_productos']);
Route::post('updateQuantity', [ProductosController::class, 'updateQuantity']);
Route::post('deleteProductoCarrito', [ProductosController::class, 'deleteProductoCarrito']);
Route::post('get_productos_by_id', [ProductosController::class, 'get_productos_by_id']);
Route::post('delete_productos', [ProductosController::class, 'delete_productos']);
Route::post('undo_delete_productos', [ProductosController::class, 'undo_delete_productos']);
Route::get('get_productos_datatable', [ProductosController::class, 'get_productos_datatable']);
Route::post('truncate_productos', [ProductosController::class, 'truncate_productos']);
Route::post('form_importar_productos', [ProductosController::class, 'form_importar_productos']);
Route::get('export_excel_productos', [ProductosController::class, 'export_excel_productos']);
Route::post('get_cat_productos', [ProductosController::class, 'get_cat_productos']);
Route::post('get_productos_by_list', [ProductosController::class, 'get_productos_by_list']);
Route::get('get_productos_diez', [ProductosController::class, 'get_productos_diez']);
Route::get('descargar_plantilla_productos', [ProductosController::class, 'descargar_plantilla_productos']);
Route::get('validar_existencia_productos', [ProductosController::class, 'validar_existencia_productos']);
Route::get('carritoProdutos', [ProductosController::class, 'productCart']);
Route::get('getCarritoProductos', [ProductosController::class, 'getCarritoProductos']);
Route::post('/set_python', [ProductosController::class, 'runPythonScript'])->name('set_python');
Route::post('ajax_remove_file', [ProductosController::class, 'ajax_remove_file']);
Route::post('ajax_sort_files', [ProductosController::class, 'ajax_sort_files']);

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



use App\Http\Controllers\EmpresaController;
Route::get('empresa', [EmpresaController::class, 'index'])->middleware('auth') ;
Route::get('empresa_ubicacion', [EmpresaController::class, 'empresa_ubicacion'])->middleware('auth') ;
Route::get('empresa_horario', [EmpresaController::class, 'empresa_horario'])->middleware('auth') ;
Route::get('empresa_empleados', [EmpresaController::class, 'empresa_empleados'])->middleware('auth') ;
Route::post('set_empresa', [EmpresaController::class, 'set_empresa']);
Route::post('set_empresa_ubicacion', [EmpresaController::class, 'set_empresa_ubicacion']);
Route::post('set_empresa_horarios', [EmpresaController::class, 'set_empresa_horarios']);
Route::post('set_import_empresa', [EmpresaController::class, 'set_import_empresa']);
Route::post('get_empresa_by_id', [EmpresaController::class, 'get_empresa_by_id']);
Route::post('delete_empresa', [EmpresaController::class, 'delete_empresa']);
Route::post('ajax_upload_file_empresa', [EmpresaController::class, 'ajax_upload_file_empresa']);
Route::post('undo_delete_empresa', [EmpresaController::class, 'undo_delete_empresa']);
Route::get('get_empresa_datatable', [EmpresaController::class, 'get_empresa_datatable']);
Route::post('truncate_empresa', [EmpresaController::class, 'truncate_empresa']);
Route::post('truncate_sps_empresa', [EmpresaController::class, 'truncate_sps_empresa']);
Route::post('form_importar_empresa', [EmpresaController::class, 'form_importar_empresa']);
Route::get('export_excel_empresa', [EmpresaController::class, 'export_excel_empresa']);
Route::post('get_cat_empresa', [EmpresaController::class, 'get_cat_empresa']);
Route::post('get_empresa_by_list', [EmpresaController::class, 'get_empresa_by_list']);
Route::get('get_empresa_diez', [EmpresaController::class, 'get_empresa_diez']);
Route::get('descargar_plantilla_empresa', [EmpresaController::class, 'descargar_plantilla_empresa']);
Route::get('validar_existencia_empresa', [EmpresaController::class, 'validar_existencia_empresa']);

use App\Http\Controllers\HorarioController;

Route::post('/empresa/horarios', [HorarioController::class, 'store'])->name('horarios.store');

use App\Http\Controllers\CarritoController;
Route::get('carrito', [CarritoController::class, 'index'])->middleware('auth') ;
Route::post('carrito_agregado', [CarritoController::class, 'carrito_agregado']) ;
Route::post('set_carrito', [CarritoController::class, 'set_carrito']);
Route::post('set_import_carrito', [CarritoController::class, 'set_import_carrito']);
Route::post('get_carrito_by_id', [CarritoController::class, 'get_carrito_by_id']);
Route::post('delete_carrito', [CarritoController::class, 'delete_carrito']);
Route::post('undo_delete_carrito', [CarritoController::class, 'undo_delete_carrito']);
Route::get('get_carrito_datatable', [CarritoController::class, 'get_carrito_datatable']);
Route::post('truncate_carrito', [CarritoController::class, 'truncate_carrito']);
Route::post('truncate_sps_carrito', [CarritoController::class, 'truncate_sps_carrito']);
Route::post('form_importar_carrito', [CarritoController::class, 'form_importar_carrito']);
Route::get('export_excel_carrito', [CarritoController::class, 'export_excel_carrito']);
Route::post('get_cat_carrito', [CarritoController::class, 'get_cat_carrito']);
Route::post('get_carrito_by_list', [CarritoController::class, 'get_carrito_by_list']);
Route::get('get_carrito_diez', [CarritoController::class, 'get_carrito_diez']);
Route::get('descargar_plantilla_carrito', [CarritoController::class, 'descargar_plantilla_carrito']);
Route::get('validar_existencia_carrito', [CarritoController::class, 'validar_existencia_carrito']);

use App\Http\Controllers\EmpleadosController;
Route::get('empleados', [EmpleadosController::class, 'index'])->middleware('auth') ;
Route::post('set_empleados', [EmpleadosController::class, 'set_empleados']);
Route::post('set_import_empleados', [EmpleadosController::class, 'set_import_empleados']);
Route::post('get_empleados_by_id', [EmpleadosController::class, 'get_empleados_by_id']);
Route::post('delete_empleados', [EmpleadosController::class, 'delete_empleados']);
Route::post('undo_delete_empleados', [EmpleadosController::class, 'undo_delete_empleados']);
Route::get('get_empleados_datatable', [EmpleadosController::class, 'get_empleados_datatable']);
Route::post('truncate_empleados', [EmpleadosController::class, 'truncate_empleados']);
Route::post('truncate_sps_empleados', [EmpleadosController::class, 'truncate_sps_empleados']);
Route::post('form_importar_empleados', [EmpleadosController::class, 'form_importar_empleados']);
Route::get('export_excel_empleados', [EmpleadosController::class, 'export_excel_empleados']);
Route::post('get_cat_empleados', [EmpleadosController::class, 'get_cat_empleados']);
Route::post('get_empleados_by_list', [EmpleadosController::class, 'get_empleados_by_list']);
Route::get('get_empleados_diez', [EmpleadosController::class, 'get_empleados_diez']);
Route::get('descargar_plantilla_empleados', [EmpleadosController::class, 'descargar_plantilla_empleados']);
Route::get('validar_existencia_empleados', [EmpleadosController::class, 'validar_existencia_empleados']);

