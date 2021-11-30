<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;



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
Route::post('register',[AuthController::class,'register']);

Route::post('login',[AuthController::class,'login']);

Route::get('users',[AuthController::class,'user']);



Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function(){

    Route::get('/checkingAuthenticated',function(){
        return response()->json(['messeage'=>"You are in",'status'=>200],200);
    });

    //category
    Route::post('store-category',[CategoryController::class,'store']);
    Route::get('view-category',[CategoryController::class,'index']);
    Route::get('edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('update-category/{id}',[CategoryController::class,'update']);
    Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);
    Route::get('all-category',[CategoryController::class,'allcategory']);

 //Products
    Route::post('store-product',[ProductController::class,'store']);
    Route::get('view-product',[ProductController::class,'index']);
    Route::get('edit-product/{id}',[ProductController::class,'edit']);
    Route::post('update-product/{id}',[ProductController::class,'update']);

    // Route::post('store-users',[CategoryController::class,'store']);
    // Route::get('view-usesr',[CategoryController::class,'index']);
    // Route::get('edit-usesr/{id}',[CategoryController::class,'edit']);
    // Route::put('update-category/{id}',[CategoryController::class,'update']);
    // Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);  
});
  Route::get('view-product',[ProductController::class,'index']);
Route::get('view-category',[CategoryController::class,'index']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});