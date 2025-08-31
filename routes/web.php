<?php

// routes/web.php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\TareaClienteController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');

         Route::get('clientes/{cliente}', [ClienteController::class, 'show'])
     ->name('clientes.show');


         Route::get('clientes/{cliente}/asignar-representante', [ClienteController::class, 'formAsignarRepresentante'])
    ->name('clientes.asignarRepresentante');

Route::post('clientes/{cliente}/asignar-representante', [ClienteController::class, 'guardarAsignacionRepresentante'])
    ->name('clientes.guardarAsignacionRepresentante');

// Endpoints para búsqueda y modal de creación de representantes
Route::get('representantes/search', [RepresentanteController::class, 'search'])->name('representantes.search');
Route::post('representantes/modal-store', [RepresentanteController::class, 'modalStore'])->name('representantes.modalStore');


    Route::resource('representantes', RepresentanteController::class);
    Route::resource('clientes', ClienteController::class);

    // Endpoint de búsqueda para autocompletar
Route::get('auditores/search', [AuditorController::class, 'search'])
    ->name('auditores.search');


// Guardar auditor desde modal
Route::post('auditores/modal-store', [AuditorController::class, 'modalStore'])
    ->name('auditores.modalStore');

    Route::resource('auditores', AuditorController::class);
    
// Formulario de asignación
Route::get('clientes/{cliente}/asignar-auditor', [ClienteController::class, 'formAsignarAuditor'])
    ->name('clientes.asignarAuditor');

// Guardar asignación
Route::post('clientes/{cliente}/asignar-auditor', [ClienteController::class, 'guardarAsignacionAuditor'])
    ->name('clientes.guardarAsignacionAuditor');



// Formulario de asignación de representante
Route::get('clientes/{cliente}/asignar-representante', [ClienteController::class, 'formAsignarRepresentante'])
    ->name('clientes.asignarRepresentante');

// Guardar asignación de representante
Route::post('clientes/{cliente}/asignar-representante', [ClienteController::class, 'guardarAsignacionRepresentante'])
    ->name('clientes.guardarAsignacionRepresentante');

// Asignaciones de tarea por cliente
Route::prefix('clientes/{cliente}')
     ->name('clientes.tareas.')
     ->middleware(['auth', 'verified'])
     ->group(function () {
    
    Route::get('tareas',        [TareaClienteController::class, 'index'])
         ->name('index');
    
    Route::get('tareas/create', [TareaClienteController::class, 'create'])
         ->name('create');
    
    Route::post('tareas',       [TareaClienteController::class, 'store'])
         ->name('store');
    
    // Opcional: edit/update/delete más adelante
    // Route::get('tareas/{tareaCliente}/edit',  ...)->name('edit');
    // Route::put('tareas/{tareaCliente}',       ...)->name('update');
    // Route::delete('tareas/{tareaCliente}',    ...)->name('destroy');
});




    // CRUD Usuarios (sólo administradores pasan la UserPolicy)
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';