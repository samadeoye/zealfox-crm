<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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


Route::get('/', [MainController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/companies', [MainController::class, 'companiesIndex'])->middleware(['auth'])->name('companies.index');

Route::post('/companies/save', [MainController::class, 'companiesSave'])->middleware(['auth'])->name('companies.save');

Route::post('/companies/update', [MainController::class, 'companiesUpdate'])->middleware(['auth'])->name('companies.update');

Route::post('/companies/delete', [MainController::class, 'companiesDelete'])->middleware(['auth'])->name('companies.delete');

Route::get('/employees', [MainController::class, 'employeesIndex'])->middleware(['auth'])->name('employees.index');

Route::post('/employees/save', [MainController::class, 'employeesSave'])->middleware(['auth'])->name('employees.save');

Route::post('/employees/update', [MainController::class, 'employeesUpdate'])->middleware(['auth'])->name('employees.update');

Route::post('/employees/delete', [MainController::class, 'employeesDelete'])->middleware(['auth'])->name('employees.delete');


require __DIR__.'/auth.php';
