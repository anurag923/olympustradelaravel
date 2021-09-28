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
Route::get('liverate',[UserController::class,'liverate']);
Route::middleware('auth:api')->group(function(){
    Route::prefix('user')->group(function(){
        Route::get('view_wallet',[UserController::class,'view_wallet']);
        Route::post('placebet',[UserController::class,'placebet']);
        Route::post('finalbet',[UserController::class,'finalbet']);
        Route::get('viewbetcategories',[UserController::class,'viewbetcategories']);
        Route::get('viewfinalwallet',[UserController::class,'view_final_wallet']);
        Route::get('viewfinalbets',[UserController::class,'viewfinalbets']);
        Route::get('viewtimers',[UserController::class,'viewtimers']);
        Route::get('singlepayout/{timer}',[UserController::class,'singlepayout']);
    });
});
Route::middleware('auth:admin-api')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::post('betcategory',[UserController::class,'betcategory']);
        Route::post('betcategoryprices',[UserController::class,'betcategoryprices']);
        Route::post('addmoneytowallet',[UserController::class,'addmoneytowallet']);
        Route::post('addtimer',[UserController::class,'addtimer']);
        Route::post('updatepayout/{timerid}',[UserController::class,'updatepayout']);
        Route::get('viewallfinalbets',[UserController::class,'viewallfinalbets']);
        Route::get('viewallwallets',[UserController::class,'viewallwallets']);
        Route::get('allusers',[UserController::class,'allusers']);
        Route::get('viewbetcategories',[UserController::class,'viewbetcategories']);
        Route::get('viewtimers',[UserController::class,'viewtimers']);
    });
});