<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductoController; // Importar el controlador de productos
use App\Http\Controllers\DashboardController; // Importar el controlador del dashboard
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------- 
| Web Routes
|---------------------------------------------------------------------- 
| 
| Aquí puedes registrar las rutas web para tu aplicación.
| 
*/

// Página de inicio (Welcome)
Route::get('/', [ProductoController::class, 'index'])->name('welcome'); // Mostrar la vista 'welcome' en la URL raíz

// Dashboard, accesible solo después de iniciar sesión
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Página de acerca de nosotros
Route::get('/about', function () {
    return view('pag.about'); // Asegúrate de que este archivo exista
})->name('about');

// Página del libro
Route::get('/book', function () {
    return view('pag.book'); // Asegúrate de que este archivo exista
})->name('book');

// Página del menú
Route::get('/menu', [ProductoController::class, 'showMenu'])->name('menu'); // Cambiado para usar el método showMenu

// Rutas CRUD de tareas
Route::resource('tasks', TaskController::class);

// Rutas CRUD de comentarios
Route::resource('comments', CommentController::class);

// Rutas CRUD de productos, protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::resource('productos', ProductoController::class); // Rutas CRUD de productos
});
Route::get('/exit', function () {
    return view('pag.exit'); // Ruta a la vista exit
})->name('exit');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


// Rutas relacionadas con el perfil, protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación
require __DIR__.'/auth.php';
