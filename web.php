<?php

use App\Controllers\Authcontroller;
use App\Controllers\CategoryController;
use App\Routes\Route;

Route::get("/", [CategoryController::class, "index"]);
Route::get("/test", [CategoryController::class, "test"]);
Route::get("/about", [CategoryController::class, "about"]);

Route::post("/product", [Authcontroller::class, "product"]);
Route::get("/product", [Authcontroller::class, "product"]);
Route::post("/edit", [CategoryController::class, "edit"]);

Route::get('/login', [Authcontroller::class, "login"]);
Route::post('/login', [Authcontroller::class, 'login']);
Route::get('/register', [Authcontroller::class, 'registerPage']);
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/admin', [Authcontroller::class, 'admin']);
Route::get('/admin', [Authcontroller::class, 'admin']);
Route::get('/user', [Authcontroller::class, 'userpage']);
Route::post('/user', [Authcontroller::class, 'userpage']);
Route::get('/logout', [CategoryController::class, 'logout']);
