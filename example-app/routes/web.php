<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductoController; // Controlador de productos
use App\Http\Controllers\DashboardController; // Controlador del dashboard
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Controlador de sesiones autenticadas
use App\Http\Controllers\UserController; // Controlador de usuarios
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|-------------------------------------------------------------------------- 
| Web Routes 
|-------------------------------------------------------------------------- 
| Aquí puedes registrar las rutas web para tu aplicación. 
|
*/

// Página de inicio (Welcome) mostrando los productos
Route::get('/', [ProductoController::class, 'index'])->name('welcome');

// Dashboard accesible solo para usuarios autenticados y verificados
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Página de "Acerca de Nosotros"
Route::get('/about', function () {
    return view('pag.about'); // Verifica que esta vista exista en 'resources/views/pag'
})->name('about');

// Página del libro
Route::get('/book', function () {
    return view('pag.book'); // Verifica que esta vista exista
})->name('book');

// Página del menú, mostrando los productos del menú
Route::get('/menu', [ProductoController::class, 'showMenu'])->name('menu');

// Rutas CRUD para tareas, solo accesibles para usuarios autenticados
Route::resource('tasks', TaskController::class)->middleware('auth');

// Rutas CRUD para comentarios, solo accesibles para usuarios autenticados
Route::resource('comments', CommentController::class)->middleware('auth');

// Agrupación de rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas CRUD para productos
    Route::resource('productos', ProductoController::class);

    // Rutas CRUD para usuarios
    Route::resource('users', UserController::class);

    // Rutas relacionadas con el perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para cerrar sesión
Route::get('/exit', function (Request $request) {
    // Cerrar la sesión
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    Auth::guard('web')->logout();
    
    // Redirigir al login
    return redirect()->route('login');
})->name('exit');

// Ruta para cerrar sesión explícitamente con método POST
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Incluir las rutas de autenticación predeterminadas de Laravel
require __DIR__.'/auth.php';
