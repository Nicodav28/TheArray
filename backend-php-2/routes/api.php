<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/get', [EmployeesController::class, 'index']);
Route::post('/create', [EmployeesController::class, 'store']);
Route::put('/update/{id}', [EmployeesController::class, 'update']);
Route::delete('/delete/{id}', [EmployeesController::class, 'delete']);
Route::get('/get/{id}', [EmployeesController::class, 'show']);
