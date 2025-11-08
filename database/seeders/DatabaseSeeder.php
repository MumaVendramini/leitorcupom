<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Criar usuários admin
        $this->call(SuperAdminSeeder::class);
        
        // Seed de demonstração principal
        $this->call(DemoSeeder::class);
    }
}
