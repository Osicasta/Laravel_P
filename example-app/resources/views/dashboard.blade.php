@extends('layouts.base')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="text-white">Comentarios de Clientes</h2>
        <!-- Botón para salir -->
        <a href="{{ route('exit') }}" class="btn btn-danger mb-3">Salir</a>
    </div>

    <!-- Tabla de comentarios -->
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

                        <form action="{{ route('comments.destroy', $comment) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
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
        
        <!-- Botón para abrir el modal de creación de producto -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
            Crear Producto
        </button>

        <!-- Tabla de productos -->
        <table class="table table-bordered text-white">
            <thead>
                <tr class="text-secondary">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th> <!-- Agregada columna para imagen -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $product)
                <tr>
                    <td class="fw-bold">{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;"> <!-- Mostrar imagen -->
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal-{{ $product->id }}">
                            Editar
                        </button>

                        <form action="{{ route('productos.destroy', $product) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal para editar producto -->
                <div class="modal fade" id="editProductModal-{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('productos.update', $product) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="text-dark">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="text-dark">Descripción</label>
                                        <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="text-dark">Precio</label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="text-dark">Imagen</label>
                                        <input type="file" name="image" class="form-control" accept="image/*"> <!-- Campo para subir una nueva imagen (opcional) -->
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

@endsection
