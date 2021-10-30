<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user_register',[UserController::class,'register']);
Route::post('/user_login',[UserController::class,'login']);
Route::post('/admin_register',[UserController::class,'admin_register']);
Route::post('/admin_login',[UserController::class,'admin_login']);
Route::post('/master_register',[UserController::class,'master_register']);
Route::post('/master_login',[UserController::class,'master_login']);
Route::get('liverate',[UserController::class,'liverate']);
Route::get('getcryptomarkets',[UserController::class,'getcryptomarkets']);
Route::get('javascript',[UserController::class,'javascript']);
Route::get('test',[UserController::class,'test']);
Route::middleware('auth:api')->group(function(){
    Route::prefix('user')->group(function(){
        Route::get('view_wallet',[UserController::class,'view_wallet']);
        Route::post('placebet',[UserController::class,'placebet']);
        Route::post('finalbet',[UserController::class,'finalbet']);
        Route::get('viewbetcategories',[UserController::class,'viewbetcategories']);
        Route::get('viewfinalwallet',[UserController::class,'view_final_wallet']);
        Route::get('viewfinalbets',[UserController::class,'viewfinalbets']);
        Route::get('viewtimers/{marketid}',[UserController::class,'viewtimers']);
        Route::get('singlepayout/{timer}',[UserController::class,'singlepayout']);
        Route::get('getmarketbytype',[UserController::class,'getmarketbytype']);
    });
});
Route::middleware('auth:admin-api')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::post('betcategory',[UserController::class,'betcategory']);
        Route::post('betcategoryprices',[UserController::class,'betcategoryprices']);
        Route::post('addmoneytowallet',[UserController::class,'addmoneytowallet']);
        Route::post('addtimer/{marketid}',[UserController::class,'addtimer']);
        Route::post('updatepayout/{timerid}',[UserController::class,'updatepayout']);
        Route::get('viewallfinalbets',[UserController::class,'viewallfinalbets']);
        Route::get('viewallwallets',[UserController::class,'viewallwallets']);
        Route::get('allusers',[UserController::class,'allusers']);
        Route::get('viewbetcategories',[UserController::class,'viewbetcategories']);
        Route::get('viewtimers/{marketid}',[UserController::class,'viewtimers_admin']);
        Route::get('markets_crypto',[UserController::class,'markets_crypto']);
        Route::post('markets_stocks',[UserController::class,'markets_stocks']);
        Route::get('selectedmarkets',[UserController::class,'selectedmarkets']);
        Route::get('getmarketbytype',[UserController::class,'getmarketbytype']);
        Route::get('searchmarket',[UserController::class,'searchmarket']);
    });
});

Route::middleware('auth:master-api')->group(function(){
    Route::prefix('master')->group(function(){
        Route::get('getmarketbytype',[UserController::class,'getmarketbytype']);
        Route::get('viewfinalwallet',[UserController::class,'view_final_wallet']);
        Route::get('getmarketbytype',[UserController::class,'getmarketbytype']);
        Route::get('searchmarket',[UserController::class,'searchmarket']);
        Route::post('placebet',[UserController::class,'master_placebet']);
        Route::post('finalbet',[UserController::class,'master_finalbet']);
    });
});