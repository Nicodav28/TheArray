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

Route::post('/employees', [EmployeesController::class, 'createEmployee']);
Route::put('/employees/{id}', [EmployeesController::class, 'updateEmployee']);
Route::delete('/employees/{id}', [EmployeesController::class, 'deleteEmployee']);
Route::get('/employees', [EmployeesController::class, 'getEmployees']);
Route::get('/employees/{id}', [EmployeesController::class, 'getEmployee']);
