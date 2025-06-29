<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model responsável por representar a entidade de tarefa (task).
 * Utiliza SoftDeletes para exclusão lógica (campo deleted_at).
 */
class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',         // Nome da tarefa
        'descricao',    // Descrição detalhada
        'finalizado',   // Status de conclusão (boolean)
        'data_limite',  // Data limite para execução
    ];

    /**
     * Conversões automáticas de tipos para atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'finalizado' => 'boolean',
        'data_limite' => 'datetime',
    ];
}
