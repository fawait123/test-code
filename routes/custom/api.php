<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
});

Route::group(['prefix'=>'user','middleware'=>'auth:api'],function(){
    Route::get('userlist',[UserController::class,'list']);
});


Route::get('unauthorized',[AuthController::class,'unauthorized'])->name('login');
