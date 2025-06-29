<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define os atributos padrão para a model Task.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Gera um nome de tarefa fictício com 3 palavras
            'nome' => $this->faker->sentence(3),

            // Define uma data limite entre hoje e os próximos 10 dias
            'data_limite' => $this->faker->dateTimeBetween('now', '+10 days')->format('Y-m-d'),

            // Tarefa começa como não finalizada
            'finalizado' => false,
        ];
    }
}
