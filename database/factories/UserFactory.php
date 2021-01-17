<?php

namespace Database\Factories;

use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'document' => "{$this->faker->unique()->numberBetween(111111, 999999)}{$this->faker->unique()->numberBetween(11111, 99999)}",
            'document_type' => User::DOC_TYPE_CPF,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function seller()
    {
        return $this->state(function (array $attributes) {
            return [
                'document' => "{$this->faker->unique()->numberBetween(1111111, 9999999)}{$this->faker->unique()->numberBetween(1111111, 9999999)}",
                'document_type' => User::DOC_TYPE_CNPJ,
            ];
        });
    }
}
