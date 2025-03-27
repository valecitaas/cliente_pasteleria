<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Models\product;
use GuzzleHttp\Psr7\Request;
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

//Clients --------------------------------------------------------------------------------------------------------
Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('login', [UserController::class, 'login']);
Route::get('/products', [productsController::class, 'index_products'])->name('index_products');
Route::put('/products/actualizar/{id}',[productsController::class,'update']);//proceso
Route::get('/products/mostrar/{id}',[productsController::class,'show']);
Route::delete('/products/borrar/{id}',[productsController::class,'destroy']);//proceso
Route::get('/products/create', function () {
    return view('products.create');
});

Route::post('/products/save',[productsController::class,'store']);

//Rutas protegidas
Route::group( ['middleware' => ["auth:sanctum"]], function(){

Route::get('user-profile', [UserController::class, 'userProfile']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('/client/show/{id}',[clientController::class,'show']);
Route::put('/clients/update/{id}',[clientController::class,'update']);
Route::delete('/clients/delete/{id}',[clientController::class,'destroy']); 
});




