<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusaFarm - Platform Investasi Pertanian Terdesentralisasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-gradient { background: radial-gradient(1200px 500px at 10% -10%, rgba(16,185,129,0.25), transparent), radial-gradient(800px 400px at 90% 10%, rgba(5,150,105,0.25), transparent), linear-gradient(135deg, #10B981 0%, #059669 100%); }
        .glass { backdrop-filter: saturate(180%) blur(10px); background: rgba(255,255,255,0.08); }
    </style>
  </head>
  <body class="bg-gray-50">
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="#" class="flex items-center">
          <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
          <span class="text-xl font-bold text-gray-900">NusaFarm</span>
        </a>
        <div class="hidden md:flex items-center space-x-6">
          <a href="#features" class="text-gray-700 hover:text-gray-900">Fitur</a>
          <a href="#how" class="text-gray-700 hover:text-gray-900">Cara Kerja</a>
          <a href="#faq" class="text-gray-700 hover:text-gray-900">FAQ</a>
          <a href="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Masuk</a>
        </div>
        <div class="md:hidden">
          <a href="/login" class="inline-flex items-center bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 text-sm">Masuk</a>
        </div>
      </div>
    </nav>

    <header class="hero-gradient text-white pt-24 md:pt-28">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
          <div>
            <div class="inline-flex items-center bg-white/10 border border-white/20 text-white rounded-full px-3 py-1 text-xs md:text-sm mb-4">
              <i class="fas fa-shield-alt mr-2"></i> Aman, Transparan, dan Berdampak
            </div>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">
              Investasi Pertanian Untuk Masa Depan yang Berkelanjutan
            </h1>
            <p class="mt-3 md:mt-4 text-green-50 text-sm md:text-base leading-relaxed">
              NusaFarm menghubungkan investor dengan petani lokal melalui proyek pertanian yang terverifikasi, lengkap dengan pelaporan harian dan ROI yang jelas.
            </p>
            <div class="mt-5 md:mt-6 flex flex-col sm:flex-row gap-3">
              <a href="/register" class="inline-flex items-center justify-center bg-white text-green-700 font-semibold px-5 py-3 rounded-lg hover:bg-gray-100">
                Mulai Investasi
              </a>
              <a href="#features" class="inline-flex items-center justify-center border-2 border-white text-white font-semibold px-5 py-3 rounded-lg hover:bg-white hover:text-green-700">
                Pelajari Lebih Lanjut
              </a>
            </div>
            <div class="mt-6 grid grid-cols-3 gap-4 text-center">
              <div class="glass rounded-xl p-3">
                <div class="text-xl md:text-2xl font-bold">500+</div>
                <div class="text-xs md:text-sm text-green-50">Investor Aktif</div>
              </div>
              <div class="glass rounded-xl p-3">
                <div class="text-xl md:text-2xl font-bold">25+</div>
                <div class="text-xs md:text-sm text-green-50">Proyek Berjalan</div>
              </div>
              <div class="glass rounded-xl p-3">
                <div class="text-xl md:text-2xl font-bold">15-35%</div>
                <div class="text-xs md:text-sm text-green-50">Rata-rata ROI</div>
              </div>
            </div>
          </div>
          <div class="relative">
            <div class="absolute -top-6 -left-6 w-40 h-40 rounded-full bg-white/10 blur-xl hidden md:block"></div>
            <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-full bg-white/10 blur-xl hidden md:block"></div>
            <div class="relative bg-white/10 border border-white/20 rounded-2xl p-4 md:p-6 shadow-xl">
              <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="relative h-56 md:h-72">
                  <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=1600&auto=format&fit=crop" alt="Contoh Lahan Pertanian" class="absolute inset-0 w-full h-full object-cover" />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                  <span class="absolute top-3 left-3 inline-flex items-center px-2.5 py-1 rounded-full text-[10px] md:text-xs font-medium bg-white/90 text-green-700 shadow">
                    <i class="fas fa-check-circle mr-1"></i> Ready for Investment
                  </span>
                </div>
                <div class="p-4">
                  <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">Contoh Proyek</div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">25% ROI</span>
                  </div>
                  <div class="mt-1 font-semibold text-gray-900">Lahan Sayuran Organik - Bogor</div>
                  <div class="mt-1 text-xs text-gray-500">Durasi 6 bulan • Min. Invest Rp 1.000.000</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section id="features" class="py-16 md:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-14">
          <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">Fitur Utama</h2>
          <p class="text-base md:text-xl text-gray-600">Platform lengkap untuk investasi pertanian modern</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-8">
          <div class="bg-gray-50 rounded-2xl p-5 text-center hover:shadow-md transition">
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-chart-line text-green-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Investasi Cerdas</h3>
            <p class="text-sm text-gray-600">Pilih proyek berdasarkan ROI, durasi, dan kebutuhan modal.</p>
          </div>
          <div class="bg-gray-50 rounded-2xl p-5 text-center hover:shadow-md transition">
            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-trophy text-purple-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Gamifikasi</h3>
            <p class="text-sm text-gray-600">Level, XP, dan badge untuk meningkatkan engagement.</p>
          </div>
          <div class="bg-gray-50 rounded-2xl p-5 text-center hover:shadow-md transition">
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-wallet text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Wallet Digital</h3>
            <p class="text-sm text-gray-600">Kelola saldo, top up, dan transaksi dengan aman.</p>
          </div>
          <div class="bg-gray-50 rounded-2xl p-5 text-center hover:shadow-md transition">
            <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-seedling text-orange-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Proyek Nyata</h3>
            <p class="text-sm text-gray-600">Proyek pertanian terverifikasi dan berdampak sosial.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="how" class="py-16 md:py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-14">
          <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">Cara Kerja</h2>
          <p class="text-base md:text-xl text-gray-600">Langkah sederhana untuk mulai berinvestasi</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8">
          <div class="bg-white rounded-2xl shadow p-5 text-center">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
              <span class="font-bold">1</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Daftar & Top Up</h3>
            <p class="text-sm text-gray-600">Buat akun dan isi saldo wallet Anda.</p>
          </div>
          <div class="bg-white rounded-2xl shadow p-5 text-center">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
              <span class="font-bold">2</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Pilih Proyek</h3>
            <p class="text-sm text-gray-600">Telusuri proyek dan tentukan nominal investasi.</p>
          </div>
          <div class="bg-white rounded-2xl shadow p-5 text-center">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
              <span class="font-bold">3</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Pantau & Nikmati ROI</h3>
            <p class="text-sm text-gray-600">Ikuti laporan harian dan raih hasil sesuai ROI.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-14 md:py-16 bg-green-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center">
          <div>
            <div class="text-2xl md:text-4xl font-bold mb-1">500+</div>
            <div class="text-green-100 text-xs md:text-sm">Investor Aktif</div>
          </div>
          <div>
            <div class="text-2xl md:text-4xl font-bold mb-1">25+</div>
            <div class="text-green-100 text-xs md:text-sm">Proyek Pertanian</div>
          </div>
          <div>
            <div class="text-2xl md:text-4xl font-bold mb-1">Rp 2.5M+</div>
            <div class="text-green-100 text-xs md:text-sm">Total Investasi</div>
          </div>
          <div>
            <div class="text-2xl md:text-4xl font-bold mb-1">15-35%</div>
            <div class="text-green-100 text-xs md:text-sm">Rata-rata ROI</div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-16 md:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-14">
          <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">Apa Kata Mereka</h2>
          <p class="text-base md:text-xl text-gray-600">Pengalaman para investor dan petani</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8">
          <div class="bg-gray-50 rounded-2xl p-5">
            <div class="flex items-center mb-3">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3"><i class="fas fa-user text-green-600"></i></div>
              <div>
                <div class="font-semibold text-gray-900 text-sm">Rani, Investor</div>
                <div class="text-xs text-gray-500">Jakarta</div>
              </div>
            </div>
            <p class="text-sm text-gray-700">UI-nya mudah digunakan, saya bisa memantau progress lahan setiap hari. ROI sesuai ekspektasi.</p>
          </div>
          <div class="bg-gray-50 rounded-2xl p-5">
            <div class="flex items-center mb-3">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3"><i class="fas fa-user text-green-600"></i></div>
              <div>
                <div class="font-semibold text-gray-900 text-sm">Budi, Petani</div>
                <div class="text-xs text-gray-500">Bandung</div>
              </div>
            </div>
            <p class="text-sm text-gray-700">Pelaporan harian sederhana. Bantuan dari manajer lapangan sangat cepat.</p>
          </div>
          <div class="bg-gray-50 rounded-2xl p-5">
            <div class="flex items-center mb-3">
              <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3"><i class="fas fa-user text-green-600"></i></div>
              <div>
                <div class="font-semibold text-gray-900 text-sm">Sarah, Landlord</div>
                <div class="text-xs text-gray-500">Bogor</div>
              </div>
            </div>
            <p class="text-sm text-gray-700">Lahan saya cepat siap untuk investasi dan transparan dalam pengelolaannya.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="faq" class="py-16 md:py-20 bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
          <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">Pertanyaan Umum</h2>
          <p class="text-base md:text-xl text-gray-600">Semua yang perlu Anda ketahui</p>
        </div>
        <div class="space-y-3 md:space-y-4">
          <details class="bg-white rounded-xl shadow p-4">
            <summary class="cursor-pointer font-semibold text-gray-900">Berapa minimal investasi?</summary>
            <p class="mt-2 text-sm text-gray-600">Minimal investasi mulai dari Rp 100.000, tergantung proyek.</p>
          </details>
          <details class="bg-white rounded-xl shadow p-4">
            <summary class="cursor-pointer font-semibold text-gray-900">Bagaimana menghitung ROI?</summary>
            <p class="mt-2 text-sm text-gray-600">ROI ditampilkan pada halaman proyek dan dihitung berdasarkan periode investasi.</p>
          </details>
          <details class="bg-white rounded-xl shadow p-4">
            <summary class="cursor-pointer font-semibold text-gray-900">Apakah dana saya aman?</summary>
            <p class="mt-2 text-sm text-gray-600">Dana dikelola transparan dan setiap transaksi terekam dalam sistem.</p>
          </details>
        </div>
      </div>
    </section>

    <section class="py-16 md:py-20 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-3 md:mb-4">Siap Mulai Investasi?</h2>
        <p class="text-base md:text-xl text-gray-600 mb-6 md:mb-8">Bergabunglah dengan ribuan investor yang telah mempercayai NusaFarm</p>
        <a href="/register" class="inline-flex items-center justify-center bg-green-600 text-white px-6 md:px-8 py-3 md:py-4 rounded-lg font-semibold text-base md:text-lg hover:bg-green-700 transition-colors">Daftar Sekarang</a>
      </div>
    </section>

    <footer class="bg-gray-900 text-white pt-10 md:pt-12 pb-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <div class="flex items-center mb-4">
              <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
              <span class="text-xl font-bold">NusaFarm</span>
            </div>
            <p class="text-gray-400">Platform investasi pertanian terdesentralisasi untuk masa depan yang lebih hijau.</p>
          </div>
          <div>
            <h3 class="font-semibold mb-4">Produk</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
              <li><a href="{{ route('projects.index') }}" class="hover:text-white">Investasi</a></li>
              <li><a href="{{ route('wallet.index') }}" class="hover:text-white">Wallet</a></li>
              <li><a href="{{ route('gamification.dashboard') }}" class="hover:text-white">Gamifikasi</a></li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold mb-4">Perusahaan</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
              <li><a href="#about" class="hover:text-white">Tentang Kami</a></li>
              <li><a href="#" class="hover:text-white">Karir</a></li>
              <li><a href="#contact" class="hover:text-white">Kontak</a></li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold mb-4">Ikuti Kami</h3>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
              <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
              <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
              <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-xl"></i></a>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400 text-sm">
          <p>&copy; 2024 NusaFarm. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </body>
  </html>
