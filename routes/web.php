<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PembimbingLapanganController;
use App\Http\Controllers\KerjaPraktekController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        $redirectRoutes = [
            'admin' => 'admin.dashboard',
            'mahasiswa' => 'mahasiswa.dashboard',
            'dosen' => 'dosen.dashboard',
            'pembimbing_lapangan' => 'lapangan.dashboard',
        ];

        foreach ($redirectRoutes as $role => $route) {
            if ($user->role === $role) {
                return redirect()->route($route);
            }
        }

        // Default fallback
        return redirect()->route('mahasiswa.dashboard');
    }
    return view('welcome');
});

// Auth routes (jangan dibungkus guest, file sudah mengatur middleware sendiri)
require __DIR__.'/auth.php';

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User management
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('users.assign-role');

    // Instansi management
    Route::get('/instansi', [AdminController::class, 'indexInstansi'])->name('instansi.index');
    Route::get('/instansi/create', [AdminController::class, 'createInstansi'])->name('instansi.create');
    Route::post('/instansi', [AdminController::class, 'storeInstansi'])->name('instansi.store');
    Route::get('/instansi/{instansi}/edit', [AdminController::class, 'editInstansi'])->name('instansi.edit');
    Route::put('/instansi/{instansi}', [AdminController::class, 'updateInstansi'])->name('instansi.update');
    Route::delete('/instansi/{instansi}', [AdminController::class, 'destroyInstansi'])->name('instansi.destroy');

    // Lowongan management
    Route::get('/lowongan', [AdminController::class, 'indexLowongan'])->name('lowongan.index');
    Route::get('/lowongan/create', [AdminController::class, 'createLowongan'])->name('lowongan.create');
    Route::post('/lowongan', [AdminController::class, 'storeLowongan'])->name('lowongan.store');
    Route::get('/lowongan/{lowongan}/edit', [AdminController::class, 'editLowongan'])->name('lowongan.edit');
    Route::put('/lowongan/{lowongan}', [AdminController::class, 'updateLowongan'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}', [AdminController::class, 'destroyLowongan'])->name('lowongan.destroy');

    // Kuota management
    Route::get('/kuota', [AdminController::class, 'indexKuota'])->name('kuota.index');
    Route::get('/kuota/create', [AdminController::class, 'createKuota'])->name('kuota.create');
    Route::post('/kuota', [AdminController::class, 'storeKuota'])->name('kuota.store');
    Route::get('/kuota/{kuota}/edit', [AdminController::class, 'editKuota'])->name('kuota.edit');
    Route::put('/kuota/{kuota}', [AdminController::class, 'updateKuota'])->name('kuota.update');
    Route::delete('/kuota/{kuota}', [AdminController::class, 'destroyKuota'])->name('kuota.destroy');

    // Alokasi Dosen Pembimbing & Penguji
    Route::get('/alokasi/pembimbing', [AdminController::class, 'alokasiPembimbing'])->name('alokasi.pembimbing');
    Route::post('/alokasi/pembimbing/{kerjaPraktek}', [AdminController::class, 'setPembimbing'])->name('alokasi.pembimbing.set');
    Route::get('/alokasi/penguji', [AdminController::class, 'alokasiPenguji'])->name('alokasi.penguji');
    Route::post('/alokasi/penguji/{seminar}', [AdminController::class, 'setPenguji'])->name('alokasi.penguji.set');

    // Monitoring & laporan
    Route::get('/monitoring', [AdminController::class, 'monitoring'])->name('monitoring');
});

// Mahasiswa routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');

    // KP management
    Route::get('/kp', [MahasiswaController::class, 'indexKP'])->name('kp.index');
    Route::get('/kp/create', [MahasiswaController::class, 'createKP'])->name('kp.create');
    Route::post('/kp', [MahasiswaController::class, 'storeKP'])->name('kp.store');

    // Proposal management
    Route::get('/proposal', [MahasiswaController::class, 'indexProposal'])->name('proposal.index');
    Route::get('/proposal/create', [MahasiswaController::class, 'createProposal'])->name('proposal.create');
    Route::post('/proposal', [MahasiswaController::class, 'storeProposal'])->name('proposal.store');
    Route::get('/proposal/{proposal}/edit', [MahasiswaController::class, 'editProposal'])->name('proposal.edit');
    Route::put('/proposal/{proposal}', [MahasiswaController::class, 'updateProposal'])->name('proposal.update');
    Route::delete('/proposal/{proposal}', [MahasiswaController::class, 'destroyProposal'])->name('proposal.destroy');

    // Bimbingan management
    Route::get('/bimbingan', [MahasiswaController::class, 'indexBimbingan'])->name('bimbingan.index');
    Route::get('/bimbingan/create', [MahasiswaController::class, 'createBimbingan'])->name('bimbingan.create');
    Route::post('/bimbingan', [MahasiswaController::class, 'storeBimbingan'])->name('bimbingan.store');
    Route::get('/bimbingan/{bimbingan}/edit', [MahasiswaController::class, 'editBimbingan'])->name('bimbingan.edit');
    Route::put('/bimbingan/{bimbingan}', [MahasiswaController::class, 'updateBimbingan'])->name('bimbingan.update');
    Route::delete('/bimbingan/{bimbingan}', [MahasiswaController::class, 'destroyBimbingan'])->name('bimbingan.destroy');

    // Laporan management
    Route::get('/laporan', [MahasiswaController::class, 'indexLaporan'])->name('laporan.index');
    Route::get('/laporan/create', [MahasiswaController::class, 'createLaporan'])->name('laporan.create');
    Route::post('/laporan', [MahasiswaController::class, 'storeLaporan'])->name('laporan.store');
    Route::get('/laporan/{laporan}/edit', [MahasiswaController::class, 'editLaporan'])->name('laporan.edit');
    Route::put('/laporan/{laporan}', [MahasiswaController::class, 'updateLaporan'])->name('laporan.update');
    Route::delete('/laporan/{laporan}', [MahasiswaController::class, 'destroyLaporan'])->name('laporan.destroy');

    // Nilai view
    Route::get('/nilai', [MahasiswaController::class, 'nilai'])->name('nilai');

    // Kuesioner management
    Route::get('/kuesioner', [MahasiswaController::class, 'indexKuesioner'])->name('kuesioner.index');
    Route::get('/kuesioner/create', [MahasiswaController::class, 'createKuesioner'])->name('kuesioner.create');
    Route::post('/kuesioner', [MahasiswaController::class, 'storeKuesioner'])->name('kuesioner.store');
    Route::get('/kuesioner/{kuesioner}/edit', [MahasiswaController::class, 'editKuesioner'])->name('kuesioner.edit');
    Route::put('/kuesioner/{kuesioner}', [MahasiswaController::class, 'updateKuesioner'])->name('kuesioner.update');
    Route::delete('/kuesioner/{kuesioner}', [MahasiswaController::class, 'destroyKuesioner'])->name('kuesioner.destroy');

    // Seminar (mahasiswa mengajukan jadwal)
    Route::get('/seminar', [MahasiswaController::class, 'indexSeminar'])->name('seminar.index');
    Route::get('/seminar/create', [MahasiswaController::class, 'createSeminar'])->name('seminar.create');
    Route::post('/seminar', [MahasiswaController::class, 'storeSeminar'])->name('seminar.store');
});

// Dosen routes
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');

    // Proposal management
    Route::get('/proposal', [DosenController::class, 'indexProposal'])->name('proposal.index');
    Route::get('/proposal/{proposal}', [DosenController::class, 'showProposal'])->name('proposal.show');
    Route::post('/proposal/{proposal}/approve', [DosenController::class, 'approveProposal'])->name('proposal.approve');
    Route::post('/proposal/{proposal}/reject', [DosenController::class, 'rejectProposal'])->name('proposal.reject');

    // Bimbingan management
    Route::get('/bimbingan', [DosenController::class, 'indexBimbingan'])->name('bimbingan.index');
    Route::get('/bimbingan/{bimbingan}', [DosenController::class, 'showBimbingan'])->name('bimbingan.show');
    Route::put('/bimbingan/{bimbingan}', [DosenController::class, 'updateBimbingan'])->name('bimbingan.update');

    // Nilai management
    Route::get('/nilai', [DosenController::class, 'indexNilai'])->name('nilai.index');
    Route::get('/nilai/create', [DosenController::class, 'createNilai'])->name('nilai.create');
    Route::post('/nilai', [DosenController::class, 'storeNilai'])->name('nilai.store');
    Route::get('/nilai/{nilai}/edit', [DosenController::class, 'editNilai'])->name('nilai.edit');
    Route::put('/nilai/{nilai}', [DosenController::class, 'updateNilai'])->name('nilai.update');
    Route::delete('/nilai/{nilai}', [DosenController::class, 'destroyNilai'])->name('nilai.destroy');

    // Penguji Seminar
    Route::get('/seminar', [DosenController::class, 'indexSeminar'])->name('seminar.index');
    Route::post('/seminar/{seminar}', [DosenController::class, 'updateSeminar'])->name('seminar.update');
});

// Pembimbing Lapangan routes
Route::middleware(['auth', 'role:pembimbing_lapangan'])->prefix('lapangan')->name('lapangan.')->group(function () {
    Route::get('/dashboard', [PembimbingLapanganController::class, 'dashboard'])->name('dashboard');

    // Nilai management
    Route::get('/nilai', [PembimbingLapanganController::class, 'indexNilai'])->name('nilai.index');
    Route::get('/nilai/create', [PembimbingLapanganController::class, 'createNilai'])->name('nilai.create');
    Route::post('/nilai', [PembimbingLapanganController::class, 'storeNilai'])->name('nilai.store');
    Route::get('/nilai/{nilai}/edit', [PembimbingLapanganController::class, 'editNilai'])->name('nilai.edit');
    Route::put('/nilai/{nilai}', [PembimbingLapanganController::class, 'updateNilai'])->name('nilai.update');
    Route::get('/kuesioner', [PembimbingLapanganController::class, 'indexKuesioner'])->name('kuesioner.index');
    Route::get('/kuesioner/create', [PembimbingLapanganController::class, 'createKuesioner'])->name('kuesioner.create');
    Route::post('/kuesioner', [PembimbingLapanganController::class, 'storeKuesioner'])->name('kuesioner.store');
    Route::get('/kuesioner/{kuesioner}', [PembimbingLapanganController::class, 'showKuesioner'])->name('kuesioner.show');
    Route::get('/kuesioner/{kuesioner}/edit', [PembimbingLapanganController::class, 'editKuesioner'])->name('kuesioner.edit');
    Route::put('/kuesioner/{kuesioner}', [PembimbingLapanganController::class, 'updateKuesioner'])->name('kuesioner.update');

    // Kuota tahun depan
    Route::get('/kuota', [PembimbingLapanganController::class, 'indexKuota'])->name('kuota.index');
    Route::get('/kuota/create', [PembimbingLapanganController::class, 'createKuota'])->name('kuota.create');
    Route::post('/kuota', [PembimbingLapanganController::class, 'storeKuota'])->name('kuota.store');
    Route::get('/kuota/{kuota}/edit', [PembimbingLapanganController::class, 'editKuota'])->name('kuota.edit');
    Route::put('/kuota/{kuota}', [PembimbingLapanganController::class, 'updateKuota'])->name('kuota.update');
    Route::get('/kuesioner/{kuesioner}', [PembimbingLapanganController::class, 'showKuesioner'])->name('kuesioner.show');
});

// Kerja Praktek routes (shared across roles; controller enforces access)
Route::middleware(['auth'])->prefix('kerja-praktek')->name('kerja-praktek.')->group(function () {
    // Basic CRUD-ish routes
    Route::get('/', [KerjaPraktekController::class, 'index'])->name('index');
    Route::get('/create', [KerjaPraktekController::class, 'create'])->name('create');
    Route::post('/', [KerjaPraktekController::class, 'store'])->name('store');
    Route::get('/{kerjaPraktek}', [KerjaPraktekController::class, 'show'])->name('show');
    Route::get('/{kerjaPraktek}/edit', [KerjaPraktekController::class, 'edit'])->name('edit');
    Route::put('/{kerjaPraktek}', [KerjaPraktekController::class, 'update'])->name('update');

    // Actions
    Route::post('/{kerjaPraktek}/submit', [KerjaPraktekController::class, 'submit'])->name('submit');
    Route::post('/{kerjaPraktek}/approve', [KerjaPraktekController::class, 'approve'])->name('approve');
    Route::post('/{kerjaPraktek}/reject', [KerjaPraktekController::class, 'reject'])->name('reject');
    Route::post('/{kerjaPraktek}/start', [KerjaPraktekController::class, 'start'])->name('start');
    Route::post('/{kerjaPraktek}/complete', [KerjaPraktekController::class, 'complete'])->name('complete');
    Route::post('/{kerjaPraktek}/upload-laporan', [KerjaPraktekController::class, 'uploadLaporan'])->name('upload-laporan');
    Route::get('/{kerjaPraktek}/download/{type}', [KerjaPraktekController::class, 'downloadFile'])->name('download');
});

// Dev helper: create admin quickly in local env
if (app()->environment(['local', 'development'])) {
    Route::get('/__dev/create-admin', function () {
        $email = 'admin@univ.ac.id';
        $user = \App\Models\User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Administrator']
        );

        // Set password plain; User model will hash automatically via casts
        $user->password = 'password123';
        $user->email_verified_at = now();
        $user->save();

        // Ensure admin role exists and assign
        \App\Models\Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        if (!$user->roles()->where('slug', 'admin')->exists()) {
            $user->assignRole('admin');
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Admin created/updated',
            'login' => ['email' => $email, 'password' => 'password123']
        ]);
    })->name('dev.create-admin');
}

// Tambahan routes: Usulan Instansi (Mahasiswa) & Verifikasi (Admin)
Route::middleware(['auth','role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function(){
    Route::get('/instansi/create', [MahasiswaController::class, 'createInstansi'])->name('instansi.create');
    Route::post('/instansi', [MahasiswaController::class, 'storeInstansi'])->name('instansi.store');
});

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::post('/instansi/{instansi}/verify', [AdminController::class, 'verifyInstansi'])->name('instansi.verify');
    Route::post('/instansi/{instansi}/reject', [AdminController::class, 'rejectInstansi'])->name('instansi.reject');
});
