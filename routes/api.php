<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("list-students", [ApiController::class, "getAllStudents"]);
Route::post("/signup", [ApiController::class, "createStudent"]);
Route::post('login',[AuthController::class, "login"]);

//productlist
Route::get("productlist", [ProductController::class, "product"]);
Route::get("products/{id}", [ProductController::class, "getproduct"]);
Route::get("recentproducts", [ProductController::class, "recentproducts"]);


//aad to cart
Route::post("addtocart", [ProductController::class, "cart"]);

//order
Route::post("order", [ProductController::class, "order"]);

//checkout
Route::post("checkout", [ProductController::class, "checkout"]);

