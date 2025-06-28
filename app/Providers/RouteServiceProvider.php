<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Responsável por registrar as rotas da aplicação (web e api).
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Caminho padrão pós-login, se aplicável.
     */
    public const HOME = '/';

    /**
     * Registra as rotas da aplicação.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
