<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIKP UNIB - Sistem Informasi Kerja Praktek</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary-blue: #1a246a;
      --accent-orange: #f97316;
      --light-bg: #f9fafb;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--light-bg);
    }

    /* Animasi mengambang */
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }
    .float { animation: float 3s ease-in-out infinite; }

    /* Smooth fade-in */
    .fade-in {
      animation: fadeIn 1.5s ease-in-out;
    }
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    html { scroll-behavior: smooth; }

    /* === NAVBAR UNDERLINE DARI TENGAH === */
    .nav-link {
      position: relative;
      transition: color 0.3s ease;
      padding-bottom: 2px;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%);
      width: 0%;
      height: 2px;
      background-color: var(--primary-blue);
      transition: width 0.3s ease;
    }
    .nav-link:hover::after { width: 100%; }
  </style>
</head>
<body class="text-gray-800">

  <!-- ===== NAVBAR ===== -->
  <header class="bg-white/90 backdrop-blur-md fixed w-full top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SIKP" class="w-9 h-9 object-contain" />
        <span class="font-bold text-xl text-gray-800">
          <span class="text-[var(--primary-blue)]">SIKP</span> <span class="text-[var(--accent-orange)]">UNIB</span>
        </span>
      </div>
      <nav class="hidden md:flex space-x-8 text-gray-700">
        <a href="#tentang" class="nav-link hover:text-[var(--primary-blue)]">Tentang</a>
        <a href="#fitur" class="nav-link hover:text-[var(--primary-blue)]">Fitur</a>
        <a href="#kontak" class="nav-link hover:text-[var(--primary-blue)]">Kontak</a>
      </nav>
      <a href="/login" class="bg-[var(--accent-orange)] hover:bg-orange-600 text-white px-5 py-2 rounded-lg shadow-md">Masuk</a>
    </div>
  </header>

  <!-- ===== HERO SECTION ===== -->
  <section class="pt-32 pb-16 bg-gradient-to-br from-blue-50 via-white to-orange-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 flex flex-col-reverse md:flex-row items-center gap-10 fade-in">
      <div class="md:w-1/2 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-snug">
          Sistem Informasi <br>
          <span class="text-[var(--primary-blue)]">Kerja Praktek</span> Online
        </h1>
        <p class="mt-4 text-gray-600 text-lg">
          Mudahkan proses pengajuan, bimbingan, dan laporan Kerja Praktek di Universitas Bengkulu dengan sistem digital yang cepat dan transparan.
        </p>
        <div class="mt-8 flex justify-center md:justify-start gap-4">
          <a href="/register" class="bg-[var(--primary-blue)] hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition transform hover:scale-105">Daftar Sekarang</a>
          <a href="#fitur" class="border-2 border-[var(--primary-blue)] text-[var(--primary-blue)] hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105">Lihat Fitur</a>
        </div>
      </div>

      <div class="md:w-1/2 flex justify-center">
        <img src="{{ asset('images/gambarlanding.png') }}" alt="Ilustrasi Landing" class="w-full max-w-md float" />
      </div>
    </div>

    <div class="absolute -bottom-1 left-0 right-0 overflow-hidden leading-[0]">
      <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
        <path fill="#1a246a" fill-opacity="1" d="M0,64L48,53.3C96,43,192,21,288,26.7C384,32,480,64,576,80C672,96,768,96,864,80C960,64,1056,32,1152,21.3C1248,11,1344,21,1392,26.7L1440,32L1440,120L0,120Z"></path>
      </svg>
    </div>
  </section>
  <!-- ===== TENTANG ===== -->
  <section id="tentang" class="bg-[#1a246a] text-white py-16 relative">
    <div class="max-w-6xl mx-auto px-6">
      <div class="flex flex-col md:flex-row items-center gap-10">
        <!-- Gambar kiri (tanpa frame + animasi floating) -->
        <div class="md:w-1/2 flex justify-center md:-mt-10">
          <img src="{{ asset('images/tentang.png') }}"
               alt="Tentang SIKP"
             />
        </div>

        <!-- Teks kanan -->
        <div class="md:w-1/2 mt-6 md:mt-0">
          <h2 class="text-3xl font-bold mb-4 text-white">Tentang SIKP UNIB</h2>
          <p class="text-gray-200 leading-relaxed mb-3">
            SIKP UNIB adalah sistem informasi terpadu yang dirancang untuk mempermudah mahasiswa Universitas Bengkulu dalam mengajukan, melaksanakan, serta melaporkan kegiatan Kerja Praktek secara daring.
          </p>
          <p class="text-gray-200 leading-relaxed">
            Dengan SIKP, seluruh proses mulai dari pendaftaran, bimbingan dosen, hingga pengumpulan laporan dapat dilakukan secara efisien, transparan, dan terintegrasi dengan sistem akademik kampus.
          </p>
        </div>
      </div>
    </div>

    <!-- Gelombang pemisah halus ke section berikut -->
    <div class="absolute -bottom-1 left-0 right-0 overflow-hidden leading-[0]">
      <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
        <path fill="#1a246a" fill-opacity="1"
              d="M0,64L48,58.7C96,53,192,43,288,42.7C384,43,480,53,576,64C672,75,768,85,864,80C960,75,1056,53,1152,48C1248,43,1344,53,1392,58.7L1440,64L1440,0L0,0Z">
        </path>
      </svg>
    </div>
  </section>

  <!-- ===== FITUR ===== -->
  <section id="fitur" class="py-14 bg-[#1a246a] -mt-6">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-white mb-10">Fitur Unggulan</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <!-- Fitur 1 -->
        <div class="bg-white text-[#1a246a] rounded-2xl p-8 shadow-lg transform transition duration-300 hover:-translate-y-3 hover:shadow-2xl hover:scale-105">
          <div class="flex justify-center mb-6">
            <div class="bg-[#1a246a] rounded-full w-16 h-16 flex items-center justify-center shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 10.5V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25h12a2.25 2.25 0 002.25-2.25v-5.25M16.5 10.5l4.5-4.5m0 0L16.5 1.5m4.5 4.5H12" />
              </svg>
            </div>
          </div>
          <h3 class="text-xl font-semibold mb-3">Pendaftaran Online</h3>
          <p>Ajukan Kerja Praktek tanpa datang ke kampus — cepat dan mudah digunakan di mana saja.</p>
        </div>

        <!-- Fitur 2 -->
        <div class="bg-white text-[#1a246a] rounded-2xl p-8 shadow-lg transform transition duration-300 hover:-translate-y-3 hover:shadow-2xl hover:scale-105">
          <div class="flex justify-center mb-6">
            <div class="bg-orange-500 rounded-full w-16 h-16 flex items-center justify-center shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12h.01M12 12h.01M9 12h.01M21 12c0 4.418-3.582 8-8 8H8.5a3.5 3.5 0 01-3.5-3.5V4.75A2.25 2.25 0 017.25 2.5h9.5A2.25 2.25 0 0119 4.75V12z" />
              </svg>
            </div>
          </div>
          <h3 class="text-xl font-semibold mb-3">Bimbingan Terintegrasi</h3>
          <p>Pantau bimbingan dan revisi laporan langsung bersama dosen pembimbing melalui dashboard digital.</p>
        </div>

        <!-- Fitur 3 -->
        <div class="bg-white text-[#1a246a] rounded-2xl p-8 shadow-lg transform transition duration-300 hover:-translate-y-3 hover:shadow-2xl hover:scale-105">
          <div class="flex justify-center mb-6">
            <div class="bg-[#1a246a] rounded-full w-16 h-16 flex items-center justify-center shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="white" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 17.25v1.5m6-1.5v1.5M3.75 9h16.5M4.5 4.5h15A2.25 2.25 0 0121.75 6.75v10.5A2.25 2.25 0 0119.5 19.5H4.5A2.25 2.25 0 012.25 17.25V6.75A2.25 2.25 0 014.5 4.5z" />
              </svg>
            </div>
          </div>
          <h3 class="text-xl font-semibold mb-3">Laporan Digital</h3>
          <p>Unggah laporan akhir tanpa ribet dan pantau status revisi secara real-time kapan pun dibutuhkan.</p>
        </div>
      </div>
    </div>
  </section>


  <!-- ===== FOOTER ===== -->
  <footer id="kontak" class="bg-[#111827] text-gray-300 pt-14 pb-8 w-full">
    <div class="w-full px-6 md:px-16">
      <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-10 items-start text-center md:text-left">
        <div class="flex flex-col items-center md:items-start space-y-3">
          <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIKP" class="w-10 h-10 object-contain">
            <h3 class="text-xl font-bold text-white">
              <span class="text-white">SIKP</span>
              <span class="text-[#f97316]">UNIB</span>
            </h3>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
            Sistem Informasi Kerja Praktek Universitas Bengkulu — mempermudah mahasiswa dalam seluruh proses KP secara digital.
          </p>
        </div>

        <div class="space-y-3">
          <h4 class="text-white font-semibold mb-2">Navigasi</h4>
          <ul class="space-y-2">
            <li><a href="#tentang" class="hover:text-white transition">Tentang</a></li>
            <li><a href="#fitur" class="hover:text-white transition">Fitur</a></li>
            <li><a href="#alur" class="hover:text-white transition">Alur KP</a></li>
            <li><a href="https://unib.ac.id" target="_blank" class="hover:text-white transition">Portal UNIB</a></li>
          </ul>
        </div>

        <div class="flex flex-col items-center md:items-end space-y-3">
          <h4 class="text-white font-semibold mb-2">Kontak</h4>
          <p class="text-sm text-gray-400">
            Email: <a href="mailto:sikp@unib.ac.id" class="text-[#f97316] hover:underline">sikp@unib.ac.id</a>
          </p>
        </div>
      </div>

      <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-500">
        &copy; 2025 SIKP Universitas Bengkulu. Semua hak dilindungi.
      </div>
    </div>
  </footer>
</body>
</html>
