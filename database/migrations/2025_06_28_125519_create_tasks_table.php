<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criação da tabela de tarefas (tasks).
     */
    public function up(): void {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // ID único da tarefa
            $table->string('nome'); // Nome da tarefa (obrigatório)
            $table->text('descricao')->nullable(); // Descrição detalhada (opcional)
            $table->boolean('finalizado')->default(false); // Status (false por padrão)
            $table->dateTime('data_limite')->nullable(); // Prazo da tarefa (opcional)
            $table->timestamps(); // Campos created_at e updated_at
            $table->softDeletes(); // Campo deleted_at (soft delete)
        });
    }

    /**
     * Reversão da migration: drop da tabela 'tasks'.
     */
    public function down(): void {
        Schema::dropIfExists('tasks');
    }
};
