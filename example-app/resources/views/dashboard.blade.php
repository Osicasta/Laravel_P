@extends('layouts.base')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="text-white">Comentarios de Clientes</h2>
        <a href="{{ route('exit') }}" class="btn btn-danger mb-3">Salir</a>
    </div>

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <thead>
                <tr class="text-secondary">
                    <th>Nombre</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                <tr>
                    <td class="fw-bold">{{ $comment->name }}</td>
                    <td>{{ $comment->message }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCommentModal-{{ $comment->id }}">
                            Editar
                        </button>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteCommentModal-{{ $comment->id }}">
                            Eliminar
                        </button>

                        <!-- Modal de confirmación para eliminar comentario -->
                        <div class="modal fade" id="confirmDeleteCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="confirmDeleteCommentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteCommentModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este comentario?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Modal para editar comentario -->
                <div class="modal fade" id="editCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCommentModalLabel">Editar Comentario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('comments.update', $comment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="text-dark">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ $comment->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="text-dark">Comentario</label>
                                        <textarea name="message" class="form-control" required>{{ $comment->message }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-warning mt-2">Actualizar Comentario</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Nueva Sección de Productos -->
    <div class="col-12 mt-5">
        <h2 class="text-white">Productos</h2>
        
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
            Crear Producto
        </button>
        <table class="table table-bordered text-white">
            <thead>
                <tr class="text-secondary">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td class="fw-bold">{{ $producto->name }}</td>
                    <td>{{ $producto->description }}</td>
                    <td>${{ number_format($producto->price, 2) }}</td>
                    <td>
                        <img src="{{ asset($producto->image) }}" alt="{{ $producto->name }}" style="width: 50px; height: 50px;">
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal-{{ $producto->id }}">
                            Editar
                        </button>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteProductModal-{{ $producto->id }}">
                            Eliminar
                        </button>

                        <!-- Modal de confirmación para eliminar producto -->
                        <div class="modal fade" id="confirmDeleteProductModal-{{ $producto->id }}" tabindex="-1" aria-labelledby="confirmDeleteProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteProductModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este producto?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form action="{{ route('productos.destroy', $producto) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Modal para editar producto -->
                <div class="modal fade" id="editProductModal-{{ $producto->id }}" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="text-dark">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ $producto->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="text-dark">Descripción</label>
                                        <textarea name="description" class="form-control" required>{{ $producto->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="text-dark">Precio</label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $producto->price }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="text-dark">Imagen</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-warning mt-2">Actualizar Producto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para crear producto -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Crear Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="text-dark">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text-dark">Descripción</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price" class="text-dark">Precio</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image" class="text-dark">Imagen</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Crear Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Nueva Sección de Usuarios -->
@if (strpos(Auth::user()->email, '@admin') !== false)
    <div class="col-12 mt-5">
        <h2 class="text-white">Usuarios</h2>

        <!-- Botón para abrir el modal de creación de usuario -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Crear Usuario
        </button>
        <table class="table table-bordered text-white">
            <thead>
                <tr class="text-secondary">
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th> <!-- Columna de acciones -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user) <!-- Cambiado $usuarios a $users -->
                <tr>
                    <td class="fw-bold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Botón para abrir el modal de edición de usuario -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                            Editar
                        </button>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteUserModal-{{ $user->id }}">
                            Eliminar
                        </button>

                        <!-- Modal de confirmación para eliminar usuario -->
                        <div class="modal fade" id="confirmDeleteUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="confirmDeleteUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteUserModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar a este usuario?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form action="{{ route('users.destroy', $user) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Modal para editar usuario -->
                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.update', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="text-dark">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="text-dark">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning mt-2">Actualizar Usuario</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para crear usuario -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="text-dark">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-dark">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Crear Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
