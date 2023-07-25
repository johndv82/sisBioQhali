<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/categorias/list', [CategoriaController::class, 'list'])->name('categorias.list');
Route::get('/productos/list', [ProductoController::class, 'list'])->name('productos.list');
Route::get('/membresias/list', [MembresiaController::class, 'list'])->name('membresias.list');
Route::get('/clientes/list', [ClienteController::class, 'list'])->name('clientes.list');
Route::post('/clientes/findbydocument', [ClienteController::class, 'findbydocument'])->name('clientes.findbydocument');
Route::get('/proveedores/list', [ProveedorController::class, 'list'])->name('proveedores.list');
Route::get('/ventas/list', [VentaController::class, 'list'])->name('ventas.list');
Route::get('/ventas/getnumerocomp', [VentaController::class, 'getNumeroComprobante'])->name('ventas.getnumerocomp');

Route::resources([
    'categorias' => CategoriaController::class,
    'productos' => ProductoController::class,
    'membresias' => MembresiaController::class,
    'clientes' => ClienteController::class,
    'proveedores' => ProveedorController::class,
    'ventas' => VentaController::class
]);






