<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('tareas', TareaController::class);
    Route::apiResource('tareas.campos', TareaCampoController::class)->shallow();
    Route::apiResource('tareas-clientes', TareaClienteController::class);
    Route::apiResource('tareas-instancias', TareaInstanciaController::class);
    Route::post('tareas-instancias/{instancia}/valores', [TareaInstanciaController::class, 'storeValores']);

    // Hacienda
    Route::post('iva-declaraciones', [IvaDeclaracionController::class, 'store']);
    Route::get('iva-declaraciones', [IvaDeclaracionController::class, 'index']);
    Route::post('hacienda-presentaciones', [HaciendaPresentacionController::class, 'store']);

    // MT
    Route::post('mt/contratos', [MtContratoController::class, 'store']);

    // UIF
    Route::post('uif/registros', [UifRegistroController::class, 'store']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::put('notifications/{notification}/sent', [NotificationController::class, 'markAsSent']);

    // Reports
    Route::get('reports/tasks-due', [ReportController::class, 'tasksDue']);
    Route::get('reports/tasks-by-status', [ReportController::class, 'tasksByStatus']);
});

