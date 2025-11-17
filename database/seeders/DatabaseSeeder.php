<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Jalankan RoleSeeder untuk membuat role-role
        $this->call(RoleSeeder::class);

        // Jalankan TestUserSeeder untuk membuat user test
        $this->call(TestUserSeeder::class);

        // Seed contoh Instansi dan Lowongan
        $this->call(InstansiLowonganSeeder::class);
    }
}
