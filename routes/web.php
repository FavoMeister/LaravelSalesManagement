<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('modules.users.login');
});

Route::get('/index', function () {
    return view('modules.index');
});

//Route::get('First-User', [UserController::class, 'FirstUser']);

Auth::routes();


Route::get('branches', [BranchController::class, "index"]);
Route::post('branches', [BranchController::class, 'store']);
Route::get('editar-sucursal/{id}', [BranchController::class, 'edit']);
Route::put('actualizar-sucursal', [BranchController::class, 'update']);
Route::get('cambiar-estado-sucursal/{branch_id}', [BranchController::class, 'changeStatus']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
