# TODO List for Sistem Informasi Kerja Praktek Multi-Role

## 1. Migration
- [ ] Buat migration untuk tabel users dengan kolom role atau pivot user_roles
- [ ] Buat migration untuk tabel mahasiswa
- [ ] Buat migration untuk tabel dosen
- [ ] Buat migration untuk tabel instansi
- [ ] Buat migration untuk tabel lowongan_kp
- [ ] Buat migration untuk tabel proposal
- [ ] Buat migration untuk tabel bimbingan
- [ ] Buat migration untuk tabel laporan
- [ ] Buat migration untuk tabel nilai
- [ ] Buat migration untuk tabel kuesioner
- [ ] Buat migration untuk tabel kuota

## 2. Model
- [ ] Buat model User dengan relasi hasOne Mahasiswa/Dosen
- [ ] Buat model Mahasiswa dengan relasi belongsTo User, hasMany Proposal, Bimbingan, Laporan, Nilai
- [ ] Buat model Dosen dengan relasi belongsTo User, hasMany Bimbingan, Nilai
- [ ] Buat model Instansi dengan relasi hasMany LowonganKP, Kuota
- [ ] Buat model LowonganKP dengan relasi belongsTo Instansi
- [ ] Buat model Proposal dengan relasi belongsTo Mahasiswa, Dosen
- [ ] Buat model Bimbingan dengan relasi belongsTo Mahasiswa, Dosen
- [ ] Buat model Laporan dengan relasi belongsTo Mahasiswa
- [ ] Buat model Nilai dengan relasi belongsTo Mahasiswa, Dosen, PembimbingLapangan
- [ ] Buat model Kuesioner dengan relasi belongsTo Mahasiswa, PembimbingLapangan
- [ ] Buat model Kuota dengan relasi belongsTo Instansi

## 3. Middleware
- [ ] Pastikan RoleMiddleware membatasi akses route sesuai role

## 4. Controller
- [ ] Buat AdminController dengan fungsi CRUD User, Instansi, LowonganKP, Kuota, Alokasi Dosen, Monitoring laporan
- [ ] Buat MahasiswaController dengan fungsi CRUD Pendaftaran KP, Proposal, Bimbingan, Laporan, Nilai, Kuesioner
- [ ] Buat DosenController dengan fungsi Validasi Proposal, CRUD Riwayat Bimbingan, Input Nilai Pembimbing dan Seminar
- [ ] Buat PembimbingLapanganController dengan fungsi Input Nilai Lapangan, CRUD Kuesioner, CRUD Kuota

## 5. Routing
- [ ] Update routes/web.php dengan prefix dan middleware role sesuai kebutuhan

## 6. View
- [ ] Buat dashboard sederhana untuk tiap role menggunakan Blade + Bootstrap

## 7. Testing
- [ ] Uji multi-role login dan redirect sesuai role
- [ ] Uji akses route dengan RoleMiddleware
