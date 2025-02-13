<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [EmployeesController::class, 'login']);
Route::post('/logout', [EmployeesController::class, 'logout'])->middleware('auth:sanctum');