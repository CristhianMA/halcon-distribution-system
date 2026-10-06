<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles base del negocio
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $salesRole = Role::firstOrCreate(['name' => 'Ventas']);
        $warehouseRole = Role::firstOrCreate(['name' => 'Almacén']);
        Role::firstOrCreate(['name' => 'Compras']);
        Role::firstOrCreate(['name' => 'Ruta']);

        // Registrar 3 usuarios con roles distintos
        User::create([
            'name' => 'Carlos Administrador',
            'email' => 'admin@halcon.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Laura Ventas',
            'email' => 'ventas@halcon.com',
            'password' => Hash::make('password123'),
            'role_id' => $salesRole->id,
        ]);

        User::create([
            'name' => 'Roberto Almacen',
            'email' => 'almacen@halcon.com',
            'password' => Hash::make('password123'),
            'role_id' => $warehouseRole->id,
        ]);
    }
}