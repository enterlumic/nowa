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

