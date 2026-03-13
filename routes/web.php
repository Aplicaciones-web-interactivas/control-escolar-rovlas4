<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showLogin'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'indexAdmin'])->name('admin.dashboard');
    
    Route::get('/admin/materias', [AdminController::class, 'indexMaterias'])->name('admin.materias');
    Route::post('/admin/materias', [AdminController::class, 'saveMateria'])->name('admin.materias.save');
    Route::get('/admin/materias/{id}/edit', [AdminController::class, 'editMateria'])->name('admin.materias.edit');
    Route::put('/admin/materias/{id}', [AdminController::class, 'updateMateria'])->name('admin.materias.update');
    
    Route::get('/admin/horarios', [AdminController::class, 'indexHorarios'])->name('admin.horarios');
    Route::post('/admin/horarios', [AdminController::class, 'saveHorario'])->name('admin.horarios.save');
    Route::get('/admin/horarios/{id}/edit', [AdminController::class, 'editHorario'])->name('admin.horarios.edit');
    Route::put('/admin/horarios/{id}', [AdminController::class, 'updateHorario'])->name('admin.horarios.update');
    
    Route::get('/admin/grupos', [AdminController::class, 'indexGrupos'])->name('admin.grupos');
    Route::post('/admin/grupos', [AdminController::class, 'saveGrupo'])->name('admin.grupos.save');
    Route::get('/admin/grupos/{id}/edit', [AdminController::class, 'editGrupo'])->name('admin.grupos.edit');
    Route::put('/admin/grupos/{id}', [AdminController::class, 'updateGrupo'])->name('admin.grupos.update');
});