<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/chirps', function () {
    return view('chirps.index');
}) -> name('chirps.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/agendacita', [AgendaController::class, 'index'])->name('agendacita.index');
    Route::post('/agendacita', [AgendaController::class,'store'])->name('agendacita.store');
    Route::get('/agendacita', [AgendaController::class,'show'])->name('agendacita.index');
    Route::post('/agendacita/ocupadas', [AgendaController::class, 'getOccupiedDates'])->name('agendacita.ocupadas');
    Route::get('/citasagendadas', function(){
        return view('citasagendadas.index');
    })->name('citasagendadas.index');
    //rutas para listar las citas
    Route::get('/citasagendadas',[AgendaController::class,'mostrarLista'])->name('citasagendadas.index');
    // editar citas agendadas
    Route::post('/agendacita/ocupadas', [AgendaController::class, 'getCitasOcupadas'])->name('agendacita.ocupadas');
    //ruta para editar los datos
    Route::get('/editcita/{id}',[AgendaController::class,'mostrarEditCita'])->name('editcita.index');
    //ruta para actualizar los datos
    Route::put('/updatecita/{id}',[AgendaController::class,'update'])->name('updatecita.update');
    Route::get('/deletecita/{id}', [AgendaController::class,'destroy'])->name('deletecita.destroy');
    Route::get('/listaempleado', function(){
        return view('listaempleado.index');
    })->name('listaempleado.index');
    //Empleado
    Route::get('/empleado',[EmpleadoController::class,'index'])->name('empleado.index');
    Route::post('/empleado', [EmpleadoController::class,'store'])->name('empleado.store');
    Route::get('/listaempleado',[EmpleadoController::class,'show'])->name('listaempleado.index');
    Route::get('/editempleado/{id}',[EmpleadoController::class,'mostrarEdit'])->name('editempleado.index');
    Route::put('/updatempleado/{id}',[EmpleadoController::class,'update'])->name('updatempleado.update');
    Route::get('/deletempleado/{id}', [EmpleadoController::class,'destroy'])->name('deletempleado.destroy');
    //Roles
    Route::get('/roles', function(){
        return view('listaroles.index');
    })->name('listaroles.index');
    // Mostrar la lista de roles
    Route::get('/roles', [RoleController::class, 'index'])->name('listaroles.index');

    // Crear un nuevo rols
    Route::post('/permisos', [RoleController::class, 'store'])->name('roles.store');
    // Ruta para mostrar el formulario de edición
    Route::get('usuarios/{user}/roles/edit', [RoleController::class, 'editUserRoles'])->name('usuarios.roles.edit');

    // Ruta para actualizar los roles
    Route::put('usuarios/{user}/roles', [RoleController::class, 'updateUserRoles'])->name('usuarios.roles.update');

    //Eliminar usuario
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    Route::get('/roles', [RoleController::class, 'listarUsuariosConRoles'])->name('listaroles.index');
    
    Route::get('/permisos', function(){
        return view('permisos.index');
    })->name('permisos.index');
    
    Route::get('/permisos', [RoleController::class, 'mostrarRoles'])->name('permisos.index');

    Route::delete('/permisos/{id}', [RoleController::class, 'eliminarRol'])->name('permisos.eliminarRol');
});

require __DIR__.'/auth.php';
