<?php

namespace Database\Factories;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Peserta>
 */
class PesertaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_hp' => $this->faker->phoneNumber(),
        ];
    }

}
