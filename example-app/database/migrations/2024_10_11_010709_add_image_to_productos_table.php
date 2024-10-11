<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Intentar agregar la columna 'image' a la tabla 'productos'
        try {
            Schema::table('productos', function (Blueprint $table) {
                $table->string('image')->nullable(); // O no nullable si deseas que sea obligatoria
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Si se lanza una excepción, significa que la columna ya existe, puedes manejar el error aquí si es necesario
            if ($e->getCode() !== '42S21') { // 42S21 es el código de error para "Column already exists"
                throw $e; // Re-lanzar la excepción si es otro tipo de error
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar la columna 'image' de la tabla 'productos'
            $table->dropColumn('image');
        });
    }
};
