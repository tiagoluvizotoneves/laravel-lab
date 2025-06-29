<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se é possível criar uma tarefa com sucesso
     */
    public function test_can_create_a_task(): void
    {
        $payload = [
            'nome' => 'Nova tarefa teste',
            'data_limite' => now()->addDays(2)->toDateString(),
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertCreated()
            ->assertJsonFragment(['nome' => 'Nova tarefa teste']);

        $this->assertDatabaseHas('tasks', [
            'nome' => 'Nova tarefa teste',
            'finalizado' => false,
        ]);
    }

    /**
     * Testa se o endpoint de listagem retorna todas as tarefas
     */
    public function test_can_list_tasks(): void
    {
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertOk()
            ->assertJsonCount(5);
    }

    /**
     * Testa se é possível atualizar os dados de uma tarefa
     */
    public function test_can_update_a_task(): void
    {
        $task = Task::factory()->create([
            'nome' => 'Original',
        ]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'nome' => 'Atualizado',
            'data_limite' => $task->data_limite->format('Y-m-d'), // Corrigido o formato
        ]);

        $response->assertOk()
            ->assertJsonFragment(['nome' => 'Atualizado']);

        $this->assertDatabaseHas('tasks', ['nome' => 'Atualizado']);
    }

    /**
     * Testa se é possível alternar o status de finalização de uma tarefa
     */
    public function test_can_toggle_a_task(): void
{
    Queue::fake(); // <-- Impede que o job rode e exclua a task

    $task = Task::factory()->create(['finalizado' => false]);

    $response = $this->patchJson("/api/tasks/{$task->id}/toggle");

    $response->assertOk()
        ->assertJsonFragment(['finalizado' => true]);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'finalizado' => true,
    ]);
}

    /**
     * Testa se a exclusão lógica (soft delete) está funcionando
     */
    public function test_can_soft_delete_a_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertOk()
            ->assertJsonFragment(['message' => 'Tarefa excluída com sucesso.']);
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
