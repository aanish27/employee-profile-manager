<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth' , 'auth:sanctum'])->group(function () {
    Route::get('/', [EmployeeController::class , 'index'])->name('employee');
    Route::get('/employee/draw', [EmployeeController::class , 'draw'])->name('employee.draw');
    Route::get('/employee/create', [EmployeeController::class , 'create'])->name('employee.create');
    Route::get('/employee/{id}', [EmployeeController::class , 'edit'])->name('employee.create');
    Route::post('/employee', [EmployeeController::class , 'store'])->name('employee.store');
    Route::patch('/employee/{id}', [EmployeeController::class , 'update'])->name('employee.update');
    Route::delete('/employee/{id}', [EmployeeController::class , 'destroy'])->name('employee.destroy');
});


Route::middleware(['auth', 'auth:sanctum'])->group(function () {
    Route::get('user/draw', [UserController::class, 'draw'])->name('user.draw');
    Route::get('user/createPDF', [UserController::class, 'createPDF'])->name('user.createPDF');
    Route::resource('user', UserController::class);
});


