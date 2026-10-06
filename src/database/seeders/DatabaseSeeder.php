<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear roles y los 3 usuarios requeridos
        $this->call(UserSeeder::class);

        // 2. Crear clientes base
        Customer::factory(10)->create();

        // 3. Crear las 50 ordenes requeridas con Faker
        Order::factory(50)->create();
    }
}