<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Producto; // Asegúrate de que el modelo Producto esté correctamente importado
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Mostrar comentarios y productos en el dashboard
    public function index()
    {
        $comments = Comment::all(); // Obtener todos los comentarios
        $productos = Producto::all(); // Obtener todos los productos

        // Retornar la vista con ambas variables
        return view('dashboard', compact('comments', 'productos'));
    }
}
