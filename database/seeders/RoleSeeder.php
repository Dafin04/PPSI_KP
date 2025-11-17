<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator sistem dengan akses penuh'
            ],
            [
                'name' => 'Dosen',
                'slug' => 'dosen',
                'description' => 'Dosen yang bertugas sebagai pembimbing KP'
            ],
            [
                'name' => 'Mahasiswa',
                'slug' => 'mahasiswa',
                'description' => 'Mahasiswa yang mengikuti program kerja praktek'
            ],
            [
                'name' => 'Pembimbing Lapangan',
                'slug' => 'pembimbing_lapangan',
                'description' => 'Pembimbing lapangan yang mengawasi mahasiswa KP di instansi'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
