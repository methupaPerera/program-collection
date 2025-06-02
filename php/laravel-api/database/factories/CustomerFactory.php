<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(["B", "I"]);
        $name = $type === "B" ? $this->faker->company() : $this->faker->name();

        return [
            "name" => $name,
            "email" => $this->faker->email(),
            "type" => $type,
            "address" => $this->faker->address(),
            "city" => $this->faker->city(),
            "state" => $this->faker->state(),
            "postal_code" => $this->faker->postcode(),
        ];
    }
}
