<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::group(['prefix'=>'auth','middleware'=>'auth:api'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
});
