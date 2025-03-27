<?php


namespace Database\Factories;

use App\Models\Intern;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternFactory extends Factory
{
    protected $model = Intern::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'dni' => $this->faker->unique()->numerify('########'),
            'phone' => $this->faker->numerify('#########'),  // Limitar a 9 dígitos
            'arrival_time' => $this->faker->time('H:i', '09:00'),  // Hora de llegada aleatoria
            'departure_time' => $this->faker->time('H:i', '17:00'), // Hora de salida aleatoria
            'start_date' => $this->faker->date('Y-m-d', '2025-01-01'),
            'end_date' => $this->faker->date('Y-m-d', '2025-12-31'),
            'institution' => $this->faker->company(),
        ];
    }
}
