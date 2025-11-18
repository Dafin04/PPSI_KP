<?php

namespace App\Services;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatKpGenerator
{
    public function __construct(
        protected ViewFactory $viewFactory
    ) {
    }

    /**
     * Generate sederhana sertifikat dalam bentuk HTML yang dapat diunduh pihak instansi.
     */
    public function generate(array $payload): string
    {
        $fileName = 'sertifikat_kp/' . Str::slug(
            $payload['nama_pembimbing'] . '-' . ($payload['tahun'] ?? now()->year)
        ) . '-' . time() . '.html';

        $html = $this->viewFactory->make('templates.sertifikat-kp', [
            'nama_pembimbing' => $payload['nama_pembimbing'],
            'nik' => $payload['nik'] ?? $payload['nip'] ?? '-',
            'semester' => $payload['semester'] ?? 'Genap',
            'tahun' => $payload['tahun'] ?? now()->year,
            'nama_kaprodi' => $payload['nama_kaprodi'] ?? 'Kaprodi Sistem Informasi',
            'ttd_digital' => $payload['ttd_digital'] ?? null,
            'tanggal' => now()->translatedFormat('d F Y'),
            'instansi' => $payload['instansi'] ?? '-',
        ])->render();

        Storage::disk('public')->put($fileName, $html);

        return $fileName;
    }
}
