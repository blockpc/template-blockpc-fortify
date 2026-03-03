<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class NoteFactory extends Factory
{
    protected $model = \App\Models\Note::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(),
            'content' => $this->faker->paragraph(),
            'author_id' => \App\Models\User::factory(),
        ];
    }
}
