<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(["B", "P", "V"]);

        return [
            "customer_id" => Customer::factory(),
            "amount" => $this->faker->randomFloat(2, 100, 10000),
            "status" => $status,
            "billed_date" => $this->faker->dateTimeBetween("-1 year", "now"),
            "paid_date" => $status == "P" ? $this->faker->dateTimeBetween("-1 year", "now") : null,
        ];
    }
}
