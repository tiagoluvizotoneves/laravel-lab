<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Jobs\DeleteCompletedTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Controller responsável pelo gerenciamento das tarefas.
 * Inclui cache, soft delete, toggle e job assíncrono.
 */
class TaskController extends Controller
{
    /**
     * Lista todas as tarefas ativas com cache simples.
     */
    public function index()
    {
        $tasks = Cache::remember('tasks.all', 60, function () {
            return Task::latest()->get();
        });

        return response()->json($tasks);
    }

    /**
     * Cria uma nova tarefa com validação.
     * Se estiver finalizada, agenda exclusão em 10 minutos via queue.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'finalizado' => 'boolean',
            'data_limite' => 'nullable|date',
        ]);

        $task = Task::create($validated);

        // Limpa cache relacionado
        Cache::forget('tasks.all');
        Cache::forget("task.{$task->id}");

        // Dispara job se tarefa já estiver finalizada
        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        return response()->json([
            'message' => 'Tarefa criada com sucesso.',
            'data' => $task
        ], 201);
    }

    /**
     * Exibe os dados de uma tarefa específica com cache individual.
     */
    public function show(Task $task)
    {
        $cacheKey = "task.{$task->id}";

        $cachedTask = Cache::remember($cacheKey, 60, fn () => $task);

        return response()->json($cachedTask);
    }

    /**
     * Atualiza os dados da tarefa.
     * Se marcada como finalizada, agenda exclusão.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'finalizado' => 'boolean',
            'data_limite' => 'nullable|date',
        ]);

        $task->update($validated);

        // Invalida caches relacionados
        Cache::forget('tasks.all');
        Cache::forget("task.{$task->id}");

        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        return response()->json([
            'message' => 'Tarefa atualizada com sucesso.',
            'data' => $task
        ]);
    }

    /**
     * Deleta logicamente a tarefa (soft delete).
     */
    public function destroy(Task $task)
    {
        $task->delete();

        Cache::forget('tasks.all');
        Cache::forget("task.{$task->id}");

        return response()->json([
            'message' => 'Tarefa excluída com sucesso.'
        ]);
    }

    /**
     * Alterna o status de finalização da tarefa (toggle).
     * Se marcada como finalizada, agenda exclusão.
     */
    public function toggle(Task $task)
    {
        $task->finalizado = !$task->finalizado;
        $task->save();

        Cache::forget('tasks.all');
        Cache::forget("task.{$task->id}");

        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        return response()->json([
            'message' => 'Status da tarefa atualizado.',
            'data' => $task
        ]);
    }
}
