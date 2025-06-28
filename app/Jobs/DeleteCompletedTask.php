<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Job responsável por excluir definitivamente uma tarefa finalizada após delay.
 */
class DeleteCompletedTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Task $task;

    /**
     * Cria uma nova instância do job.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Executa o job: remove do banco se ainda estiver finalizada.
     */
    public function handle(): void
    {
        $task = Task::withTrashed()->find($this->task->id);

        if ($task && $task->finalizado) {
            $task->forceDelete();
        }
    }
}
