<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Pagina de inicio
Route::get('/', function () {
    return view('welcome');
});
//Operaciones CRUD
Route::get('/index', function () {
    return view('/layouts/index');
});
//Pagina de acerca de nosotros
Route::get('/about', function () {
    return view('/pag/about');
});
//Pagina del libro
Route::get('/book', function () {
    return view('/pag/book');
});
//Pagina del menú
Route::get('/menu', function () {
    return view('/pag/menu');
});
//Pagina del dashboard exit
Route::get('/exit', function () {
    return view('/pag/exit');
});
//Ruta de tareas CRUD
Route::resource('tasks', TaskController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
