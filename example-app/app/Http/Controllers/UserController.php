<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar todos los usuarios en el dashboard
    public function index()
    {
        $this->authorize('viewAny', User::class); // Verificar si el usuario puede ver la lista

        $usuarios = User::all(); // Obtiene todos los usuarios
        return view('dashboard', compact('usuarios')); // Pasar solo los usuarios a la vista
    }

    // Mostrar el formulario para crear un nuevo usuario
    public function create()
    {
        $this->authorize('create', User::class); // Verificar si el usuario puede crear

        return view('usuarios.create'); // Vista para crear un usuario
    }

    // Almacenar un nuevo usuario
    public function store(Request $request)
    {
        $this->authorize('create', User::class); // Verificar si el usuario puede crear

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el nuevo usuario en la base de datos
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Cifrar la contraseña
        ]);

        // Redirigir al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')
            ->with('success', 'Usuario creado con éxito.');
    }

    // Mostrar el formulario de edición de un usuario
    public function edit(User $usuario)
    {
        $this->authorize('update', $usuario); // Verificar si el usuario puede editar

        return view('usuarios.edit', compact('usuario')); // Vista de edición
    }

    // Actualizar un usuario
    public function update(Request $request, User $usuario)
    {
        $this->authorize('update', $usuario); // Verificar si el usuario puede editar

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id, // Ignorar el correo del usuario actual
            'password' => 'nullable|string|min:8|confirmed', // Contraseña opcional
        ]);

        // Actualizar datos del usuario
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        // Actualizar la contraseña si se proporciona
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password); // Cifrar la nueva contraseña
        }

        // Guardar los cambios
        $usuario->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('dashboard')
            ->with('success', 'Usuario actualizado con éxito.');
    }

    // Eliminar un usuario
    public function destroy(User $usuario)
    {
        $this->authorize('delete', $usuario); // Verificar si el usuario puede eliminar

        // Eliminar usuario
        $usuario->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('dashboard')
            ->with('success', 'Usuario eliminado con éxito.');
    }
}
