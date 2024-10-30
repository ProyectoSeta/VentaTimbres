<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(TiposSeeder::class);
        $this->call(ClasificacionSeeder::class);
        $this->call(FuncionarioSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EntesSeeder::class);
        $this->call(TramitesSeeder::class);
        $this->call(UcdSeeder::class);
        $this->call(SedesSeeder::class);
        $this->call(TaquillasSedeer::class);
        $this->call(DenominacionsSedeer::class);
        $this->call(VariablesSeeder::class);
        $this->call(FormasSeeder::class);
        $this->call(InventarioEstampillasSedeer::class);
        $this->call(InventarioTaquillasSedeer::class);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
