<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            CategoriaProductoSeeder::class,
            ClienteSeeder::class,
            VehiculoSeeder::class,
            DistribuidorSeeder::class,
            ProductoSeeder::class,
            PedidoSeeder::class,
            HojaDespachoSeeder::class,
            BitacoraAccionSeeder::class,
        ]);
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'id_rol' => 1, // Admin
                'password_hash' => Hash::make('password'),
                'nombres' => 'Administrador',
                'apellidos' => 'del Sistema',
                'email' => 'admin@princesa.com',
                'estado' => 'Activo'
            ]
        );
    }
}

