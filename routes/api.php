<?php

use App\Http\Controllers\Api\ActivoController;
use App\Http\Controllers\Api\BajaController;
use App\Http\Controllers\Api\FacturaController;
use App\Http\Controllers\Api\SolicitudController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BitacoraApiController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\ActivofijoApiController;
use App\Http\Controllers\Api\NotaApiController;
use App\Http\Controllers\Api\RevalorizacionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UbicacionApiController;
use App\Http\Controllers\Api\DepartamentoApiController;
use App\Http\Controllers\Api\FacturaApiController;
use App\Http\Controllers\Api\MantenimientoApiController;
use App\Http\Controllers\Api\DepreciacionApiController;
use App\Http\Controllers\Api\SolicitudApiController;
use App\Http\Controllers\Api\SoliActivoApiController;
use App\Http\Controllers\Api\TraspasoApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::get('obtenerUser', [UserController::class, 'obtenerUser']);
    Route::get('obtenerUsuarios', [UserController::class, 'obtenerUsuarios']);
    Route::get('obtenerCategorias', [CategoriaApiController::class, 'index']);
    Route::get('obtenerActivosfijo', [ActivofijoApiController::class, 'index']);
    Route::get('obtenerNota', [NotaApiController::class, 'index']);
    // Obtener todas las revalorizaciones
    Route::get('obtenerRevalorizacion', [RevalorizacionApiController::class, 'index']);
    // OBtener ubicacion
    Route::get('ubicaciones', [UbicacionApiController::class, 'index']); // Obtener todas las ubicaciones
    Route::get('ubicaciones/{id}', [UbicacionApiController::class, 'show']); // Obtener una ubicación específica
    Route::post('ubicaciones', [UbicacionApiController::class, 'store']); // Crear una nueva ubicación
    Route::put('ubicaciones/{id}', [UbicacionApiController::class, 'update']); // Actualizar una ubicación
    Route::delete('ubicaciones/{id}', [UbicacionApiController::class, 'destroy']); // Eliminar una ubicación

    Route::get('/departamentos', [DepartamentoApiController::class, 'index']);

// Crear una nueva revalorización

    Route::post('crearRevalorizacion', [RevalorizacionApiController::class, 'crearRevalorizacion']);

// Editar una revalorización existente (se pasa el id en la URL)
    Route::put('editarRevalorizacion/{id}', [RevalorizacionApiController::class, 'editarRevalorizacion']);

// Eliminar una revalorización existente (se pasa el id en la URL)
    Route::delete('eliminarRevalorizacion/{id}', [RevalorizacionApiController::class, 'eliminarRevalorizacion']);
    Route::get('obtenerActivos', [ActivoController::class, 'obtenerActivos']);
    Route::get('obtenerActivosA', [ActivoController::class, 'obtenerActivosA']);
    Route::get('obtenerActivo', [ActivoController::class, 'obtenerActivo']);
    Route::post('actualizarFoto', [UserController::class, 'actualizarFoto']);
    Route::get('obtenerFacturas', [FacturaController::class, 'obtenerFacturas']);
    Route::get('obtenerSolicitudes', [SolicitudController::class, 'obtenerSolicitudes']);
    Route::post('crearSolicitud', [SolicitudController::class, 'crearSolicitud']);
    Route::post('eliminarSolicitud', [SolicitudController::class, 'eliminarSolicitud']);
    Route::get('obtenerBajas', [BajaController::class, 'obtenerBajas']);
    Route::post('bajas', [BajaController::class, 'crearBaja']); // Crear una nueva baja
    Route::put('bajas/{id}', [BajaController::class, 'editarBaja']); // Editar una baja existente
    Route::delete('bajas/{id}', [BajaController::class, 'eliminarBaja']);
    Route::get('obtenerBitacora', [BitacoraApiController::class, 'index']);


    Route::prefix('facturas')->group(function () {
        Route::get('/', [FacturaApiController::class, 'index']);
        Route::get('/{id}', [FacturaApiController::class, 'show']);
        Route::post('/', [FacturaApiController::class, 'store']);
        Route::put('/{id}', [FacturaApiController::class, 'update']);
        Route::delete('/{id}', [FacturaApiController::class, 'destroy']);
    });


    Route::prefix('mantenimientos')->group(function () {
        Route::get('/', [MantenimientoApiController::class, 'index']); // Listar todos los mantenimientos
        Route::get('/{id}', [MantenimientoApiController::class, 'show']); // Obtener un mantenimiento por ID
        Route::post('/', [MantenimientoApiController::class, 'store']); // Crear un nuevo mantenimiento
        Route::put('/{id}', [MantenimientoApiController::class, 'update']); // Actualizar un mantenimiento por ID
        Route::delete('/{id}', [MantenimientoApiController::class, 'destroy']); // Eliminar un mantenimiento por ID
    });


    Route::prefix('depreciaciones')->group(function () {
        Route::get('/', [DepreciacionApiController::class, 'index']); // Listar todas las depreciaciones
        Route::get('/{id}', [DepreciacionApiController::class, 'show']); // Obtener una depreciación por ID
        Route::post('/', [DepreciacionApiController::class, 'store']); // Crear una nueva depreciación
        Route::put('/{id}', [DepreciacionApiController::class, 'update']); // Actualizar una depreciación por ID
        Route::delete('/{id}', [DepreciacionApiController::class, 'destroy']); // Eliminar una depreciación por ID
    });

    Route::prefix('solicitudes')->group(function () {
        Route::get('/', [SolicitudApiController::class, 'index']); // Listar todas las solicitudes
        Route::get('/{id}', [SolicitudApiController::class, 'show']); // Obtener una solicitud por ID
        Route::post('/', [SolicitudApiController::class, 'store']); // Crear una nueva solicitud
        Route::put('/{id}', [SolicitudApiController::class, 'update']); // Actualizar una solicitud por ID
        Route::delete('/{id}', [SolicitudApiController::class, 'destroy']); // Eliminar una solicitud por ID
    });
    Route::prefix('soli-activos')->group(function () {
        Route::get('/', [SoliActivoApiController::class, 'index']); // Listar todos los activos
        Route::get('/{id}', [SoliActivoApiController::class, 'show']); // Obtener un activo por ID
        Route::post('/', [SoliActivoApiController::class, 'store']); // Crear un nuevo activo
        Route::put('/{id}', [SoliActivoApiController::class, 'update']); // Actualizar un activo por ID
        Route::delete('/{id}', [SoliActivoApiController::class, 'destroy']); // Eliminar un activo por ID
        Route::get('/solicitud/{id_sol}', [SoliActivoApiController::class, 'getBySolicitudId']);
    });


    Route::prefix('notas')->group(function () {
        Route::get('/', [NotaApiController::class, 'index']); // Listar todas las notas
        Route::get('/{id}', [NotaApiController::class, 'show']); // Obtener una nota por ID
        Route::post('/', [NotaApiController::class, 'store']); // Crear una nueva nota
        Route::put('/{id}', [NotaApiController::class, 'update']); // Actualizar una nota existente
        Route::delete('/{id}', [NotaApiController::class, 'destroy']); // Eliminar una nota por ID
    });

    Route::prefix('traspasos')->group(function () {
        Route::get('/', [TraspasoApiController::class, 'index']); // Listar todos los traspasos
        Route::get('/{id}', [TraspasoApiController::class, 'show']); // Obtener un traspaso por ID
        Route::post('/', [TraspasoApiController::class, 'store']); // Crear un nuevo traspaso
        Route::put('/{id}', [TraspasoApiController::class, 'update']); // Actualizar un traspaso existente
        Route::delete('/{id}', [TraspasoApiController::class, 'destroy']); // Eliminar un traspaso por ID
    });


});


