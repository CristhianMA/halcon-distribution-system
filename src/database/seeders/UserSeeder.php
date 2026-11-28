<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asegurar los 5 roles requeridos por la Actividad 13
        $adminRole = Role::firstOrCreate(['name' => 'Administrator']);
        $salesRole = Role::firstOrCreate(['name' => 'Sales']);
        $purchasingRole = Role::firstOrCreate(['name' => 'Purchasing']);
        $warehouseRole = Role::firstOrCreate(['name' => 'Warehouse']);
        $routeRole = Role::firstOrCreate(['name' => 'Route']);

        $defaultPassword = Hash::make(env('DEFAULT_USER_PASSWORD', Str::random(16)));

        // 2. Usuarios base de empleados (si no existen)
        User::firstOrCreate(
            ['email' => 'admin@halcon.com'],
            [
                'name' => 'Carlos Administrador',
                'password' => $defaultPassword,
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'ventas@halcon.com'],
            [
                'name' => 'Laura Ventas',
                'password' => $defaultPassword,
                'role_id' => $salesRole->id,
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'almacen@halcon.com'],
            [
                'name' => 'Roberto Almacen',
                'password' => $defaultPassword,
                'role_id' => $warehouseRole->id,
                'is_active' => true,
            ]
        );
    }
}