<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name("admin.")->prefix("admin")->group(function (){
    Route::resource("posts", PostController::class)->except(["show"]);
    Route::resource("categories", CategoryController::class)->except(["show"]);

    Route::resource("users", UserController::class)->except(["show"]);
    Route::post("users/block/{id}", [UserController::class, "blockUser"])->name("users.block");
});
