<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update test users for each role

        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@univ.ac.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Dosen
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@univ.ac.id'],
            [
                'name' => 'Dr. Budi Santoso',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $dosen->assignRole('dosen-biasa');
        // Create related Dosen model
        \App\Models\Dosen::updateOrCreate(
            ['user_id' => $dosen->id],
            [
                'nip' => '198501011234567890',
                'jabatan' => 'Dosen Pembimbing',
            ]
        );

        // Mahasiswa
        $mahasiswa = User::updateOrCreate(
            ['email' => 'mahasiswa@univ.ac.id'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $mahasiswa->assignRole('mahasiswa');
        // Create related Mahasiswa model
        \App\Models\Mahasiswa::updateOrCreate(
            ['user_id' => $mahasiswa->id],
            [
                'nim' => '20210001',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2021',
            ]
        );

        // Mahasiswa 1
        $mahasiswa1 = User::updateOrCreate(
            ['email' => 'mahasiswa1@univ.ac.id'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $mahasiswa1->assignRole('mahasiswa');
        // Create related Mahasiswa model
        \App\Models\Mahasiswa::updateOrCreate(
            ['user_id' => $mahasiswa1->id],
            [
                'nim' => '20210002',
                'prodi' => 'Sistem Informasi',
                'angkatan' => '2021',
            ]
        );

        // Pembimbing Lapangan
        $pengawas = User::updateOrCreate(
            ['email' => 'pengawas@univ.ac.id'],
            [
                'name' => 'Pak Rahman',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $pengawas->assignRole('pembimbing_lapangan');
        // Create related PembimbingLapangan model (after migration)
        // \App\Models\PembimbingLapangan::updateOrCreate(
        //     ['user_id' => $pengawas->id],
        //     [
        //         'nip' => '197501011234567890',
        //         'jabatan' => 'Pembimbing Lapangan',
        //     ]
        // );

        $this->command->info('Test users updated/created successfully!');
        $this->command->info('Email: admin@univ.ac.id | Password: password123 | Role: Admin');
        $this->command->info('Email: dosen@univ.ac.id | Password: password123 | Role: Dosen');
        $this->command->info('Email: mahasiswa@univ.ac.id | Password: password123 | Role: Mahasiswa');
        $this->command->info('Email: mahasiswa1@univ.ac.id | Password: password123 | Role: Mahasiswa');
        $this->command->info('Email: pengawas@univ.ac.id | Password: password123 | Role: Pembimbing Lapangan');
    }
}
