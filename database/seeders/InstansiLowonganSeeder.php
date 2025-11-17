<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instansi;
use App\Models\Lowongan;
use Carbon\Carbon;

class InstansiLowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some instansi
        $instansi1 = Instansi::create([
            'nama_instansi' => 'PT. Teknologi Nusantara',
            'alamat' => 'Jl. Merdeka No. 123',
            'kontak' => '021-123456',
            'status' => true,
        ]);

        $instansi2 = Instansi::create([
            'nama_instansi' => 'CV. Solusi Digital',
            'alamat' => 'Jl. Sudirman No. 45',
            'kontak' => '021-654321',
            'status' => true,
        ]);

        // Create some lowongan
        Lowongan::create([
            'instansi_id' => $instansi1->id,
            'judul_lowongan' => 'Programmer Magang',
            'deskripsi' => 'Membantu pengembangan aplikasi web dan mobile.',
            'kebutuhan_keahlian' => 'PHP, Laravel, JavaScript',
            'jumlah_kuota' => 3,
            'tanggal_mulai' => Carbon::now()->addDays(7),
            'tanggal_selesai' => Carbon::now()->addMonths(2),
            'status_aktif' => true,
        ]);

        Lowongan::create([
            'instansi_id' => $instansi2->id,
            'judul_lowongan' => 'Desainer Grafis Magang',
            'deskripsi' => 'Membantu pembuatan desain untuk media digital.',
            'kebutuhan_keahlian' => 'Adobe Photoshop, Illustrator',
            'jumlah_kuota' => 2,
            'tanggal_mulai' => Carbon::now()->addDays(10),
            'tanggal_selesai' => Carbon::now()->addMonths(3),
            'status_aktif' => true,
        ]);
    }
}
