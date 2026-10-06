<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => fake()->unique()->numberBetween(100000, 999999),
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'status' => fake()->randomElement(['Ordered', 'In process', 'In route', 'Delivered']),
            'delivery_address' => fake()->address(),
            'notes' => fake()->optional()->sentence(),
            'load_photo_path' => null,
            'delivery_photo_path' => null,
            'is_deleted' => false,
        ];
    }
}