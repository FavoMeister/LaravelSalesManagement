<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('modules.users.login');
})->name('Ingresar');

Route::get('/index', function () {
    return view('modules.index');
});

//Route::get('First-User', [UserController::class, 'FirstUser']);

Auth::routes();

// Branches
Route::get('branches', [BranchController::class, "index"]);
Route::post('branches', [BranchController::class, 'store']);
Route::get('editar-sucursal/{id}', [BranchController::class, 'edit']);
Route::put('actualizar-sucursal', [BranchController::class, 'update']);
Route::get('cambiar-estado-sucursal/{branch_id}', [BranchController::class, 'changeStatus']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Users
Route::get('mis-datos', function(){
    return view('modules.users.profile');
});
Route::post('mis-datos', [UserController::class, 'updateData']);
Route::get('usuarios', [UserController::class, 'index']);
Route::post('usuarios', [UserController::class, 'store']);
Route::get('cambiar-estado/{user_id}', [UserController::class, 'changeStatus']);
Route::get('editar-usuario/{user_id}', [UserController::class, 'edit']);
Route::post('verificar-email', [UserController::class, 'verifyUser']);
Route::put('actualizar-usuario', [UserController::class, 'update']);
Route::get('eliminar-usuario/{user_id}', [UserController::class, 'destroy']);

// Categories
Route::get('categorias', [CategoryController::class, 'index'])->name('categorias');
Route::post('categorias', [CategoryController::class, 'store']);
Route::get('editar-categoria/{category_id}', [CategoryController::class, 'edit']);
Route::put('actualizar-categoria', [CategoryController::class, 'update']);
Route::get('eliminar-categoria/{category_id}', [CategoryController::class, 'destroy']);