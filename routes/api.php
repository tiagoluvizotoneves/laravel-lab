<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui ficam as rotas da API do sistema de tarefas.
| Todas são prefixadas com /api automaticamente pelo RouteServiceProvider.
|
*/

Route::apiResource('tasks', TaskController::class);

// Rota extra para alternar status finalizado/não finalizado
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle']);
