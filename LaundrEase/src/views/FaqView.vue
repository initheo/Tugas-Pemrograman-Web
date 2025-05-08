<template>
  <div>
    <Header />
    
     <!-- Page Header -->
    <section
      className="bg-gradient-to-r from-primary-700 to-primary-900 text-white py-16 md:py-24 relative overflow-hidden"
    >
      <div
        className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')] opacity-10 bg-cover bg-center mix-blend-overlay"
      ></div>
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div className="max-w-3xl mx-auto text-center reveal">
          <h1
            className="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
          >
            Pertanyaan yang Sering Diajukan
          </h1>
          <p className="text-lg md:text-xl mb-8 text-primary-100 max-w-2xl mx-auto">
            Temukan jawaban untuk pertanyaan umum tentang layanan laundry kami.
          </p>
        </div>
      </div>
      <div className="absolute bottom-0 left-0 right-0">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 1440 120"
          className="fill-white"
        >
          <path
            d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"
          ></path>
        </svg>
      </div>
    </section>

    <!-- FAQ Categories Section -->
    <section className="py-12 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-wrap justify-center gap-4 mb-12 reveal">
          <a
            href="#general"
            className="px-6 py-3 bg-primary-50 text-primary-600 rounded-full font-medium hover:bg-primary-100 transition-all duration-300"
          >
            Umum
          </a>
          <a
            href="#services"
            className="px-6 py-3 bg-primary-50 text-primary-600 rounded-full font-medium hover:bg-primary-100 transition-all duration-300"
          >
            Layanan
          </a>
          <a
            href="#pricing"
            className="px-6 py-3 bg-primary-50 text-primary-600 rounded-full font-medium hover:bg-primary-100 transition-all duration-300"
          >
            Harga & Pembayaran
          </a>
          <a
            href="#delivery"
            className="px-6 py-3 bg-primary-50 text-primary-600 rounded-full font-medium hover:bg-primary-100 transition-all duration-300"
          >
            Pengantaran
          </a>
          <a
            href="#account"
            className="px-6 py-3 bg-primary-50 text-primary-600 rounded-full font-medium hover:bg-primary-100 transition-all duration-300"
          >
            Akun & Aplikasi
          </a>
        </div>

        <!-- Search Box -->
        <div className="max-w-2xl mx-auto mb-16 reveal">
          <div className="relative">
            <input
              type="text"
              id="faq-search"
              placeholder="Cari pertanyaan..."
              className="w-full px-5 py-4 pr-12 rounded-lg border border-secondary-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
            />
            <div
              className="absolute right-4 top-1/2 transform -translate-y-1/2 text-secondary-400"
            >
              <i className="fas fa-search"></i>
            </div>
          </div>
        </div>

        <!-- General Questions -->
        <div id="general" className="max-w-3xl mx-auto mb-16 reveal">
          <h2
            className="text-2xl md:text-3xl font-bold text-secondary-900 mb-8 flex items-center"
          >
            <div
              className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3"
            >
              <i className="fas fa-info-circle"></i>
            </div>
            Pertanyaan Umum
          </h2>

          <div className="space-y-4">
            <!-- FAQ Item 1 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Apa itu LaundrEase?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  LaundrEase adalah layanan laundry modern yang menawarkan
                  solusi lengkap untuk kebutuhan laundry Anda. Kami menyediakan
                  layanan penjemputan dan pengantaran, serta berbagai jenis
                  layanan laundry termasuk cuci & lipat, cuci kering, setrika,
                  dan lainnya. Misi kami adalah memberikan kebebasan kepada Anda
                  dari tugas mencuci pakaian sehingga Anda dapat fokus pada
                  hal-hal yang lebih penting dalam hidup.
                </p>
              </div>
            </div>

            <!-- FAQ Item 2 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Bagaimana cara kerja layanan LaundrEase?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Layanan kami sangat mudah digunakan. Pertama, jadwalkan
                  penjemputan melalui situs web atau aplikasi kami. Kemudian,
                  pengemudi kami akan menjemput cucian Anda pada waktu yang
                  telah ditentukan. Pakaian Anda akan dicuci, dikeringkan,
                  dan/atau disetrika sesuai dengan layanan yang Anda pilih.
                  Terakhir, kami akan mengantarkan pakaian bersih Anda kembali
                  ke alamat Anda pada waktu yang telah dijadwalkan. Anda dapat
                  melacak status cucian Anda secara real-time melalui aplikasi
                  kami.
                </p>
              </div>
            </div>

            <!-- FAQ Item 3 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Di kota mana saja LaundrEase beroperasi?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Saat ini, LaundrEase beroperasi di 15 kota besar di Indonesia,
                  termasuk Jakarta, Surabaya, Bandung, Medan, Makassar,
                  Semarang, Yogyakarta, Denpasar, Palembang, Balikpapan, Manado,
                  Padang, Malang, Pekanbaru, dan Banjarmasin. Kami terus
                  memperluas layanan kami ke kota-kota lain. Silakan periksa
                  aplikasi atau situs web kami untuk melihat apakah kami
                  melayani area Anda.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Services Questions -->
        <div id="services" className="max-w-3xl mx-auto mb-16 reveal">
          <h2
            className="text-2xl md:text-3xl font-bold text-secondary-900 mb-8 flex items-center"
          >
            <div
              className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3"
            >
              <i className="fas fa-tshirt"></i>
            </div>
            Layanan
          </h2>

          <div className="space-y-4">
            <!-- FAQ Item 1 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Layanan apa saja yang ditawarkan oleh LaundrEase?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600 mb-4">
                  LaundrEase menawarkan berbagai layanan laundry untuk memenuhi
                  semua kebutuhan Anda:
                </p>
                <ul className="list-disc pl-5 space-y-2 text-secondary-600">
                  <li>
                    <strong>Cuci & Lipat</strong> - Layanan dasar untuk pakaian
                    sehari-hari
                  </li>
                  <li>
                    <strong>Cuci Kering</strong> - Untuk pakaian formal dan kain
                    sensitif
                  </li>
                  <li>
                    <strong>Setrika & Pres</strong> - Layanan penyetrikaan
                    profesional
                  </li>
                  <li>
                    <strong>Seprai & Linen</strong> - Khusus untuk linen rumah
                    tangga
                  </li>
                  <li>
                    <strong>Layanan Ekspres</strong> - Pengerjaan dalam 8 jam
                  </li>
                  <li>
                    <strong>Layanan Bisnis</strong> - Solusi untuk hotel,
                    restoran, dan bisnis lainnya
                  </li>
                  <li>
                    <strong>Pembersihan Karpet & Gorden</strong> - Untuk tekstil
                    rumah tangga besar
                  </li>
                </ul>
              </div>
            </div>

            <!-- FAQ Item 2 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Berapa lama waktu yang dibutuhkan untuk mencuci pakaian
                  saya?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Waktu pengerjaan standar kami adalah 24-48 jam untuk layanan
                  Cuci & Lipat reguler. Untuk layanan Cuci Kering, waktu
                  pengerjaan biasanya 48-72 jam. Jika Anda membutuhkan pakaian
                  Anda lebih cepat, kami juga menawarkan Layanan Ekspres dengan
                  pengerjaan dalam 8 jam dengan biaya tambahan. Waktu pengerjaan
                  dihitung dari saat pakaian Anda tiba di fasilitas kami, bukan
                  dari waktu penjemputan.
                </p>
              </div>
            </div>

            <!-- FAQ Item 3 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Apakah LaundrEase menggunakan deterjen ramah
                  lingkungan?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Ya, LaundrEase berkomitmen pada praktik ramah lingkungan. Kami
                  menggunakan deterjen biodegradable yang aman untuk lingkungan
                  namun tetap efektif membersihkan pakaian Anda. Mesin kami juga
                  hemat energi dan air. Jika Anda memiliki preferensi deterjen
                  tertentu atau alergi, Anda dapat menginformasikannya kepada
                  kami saat memesan, dan kami akan mengakomodasi kebutuhan Anda
                  jika memungkinkan.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Pricing Questions -->
        <div id="pricing" className="max-w-3xl mx-auto mb-16 reveal">
          <h2
            className="text-2xl md:text-3xl font-bold text-secondary-900 mb-8 flex items-center"
          >
            <div
              className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3"
            >
              <i className="fas fa-tag"></i>
            </div>
            Harga & Pembayaran
          </h2>

          <div className="space-y-4">
            <!-- FAQ Item 1 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Berapa biaya layanan LaundrEase?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600 mb-4">
                  Harga kami bervariasi tergantung pada layanan yang Anda pilih:
                </p>
                <ul className="list-disc pl-5 space-y-2 text-secondary-600">
                  <li><strong>Cuci & Lipat</strong>: Mulai dari Rp12.000/kg</li>
                  <li>
                    <strong>Cuci Kering</strong>: Mulai dari Rp79.000/item
                  </li>
                  <li>
                    <strong>Setrika & Pres</strong>: Mulai dari Rp39.000/item
                  </li>
                  <li>
                    <strong>Seprai & Linen</strong>: Mulai dari Rp25.000/kg
                  </li>
                  <li>
                    <strong>Layanan Ekspres</strong>: +50% dari harga reguler
                  </li>
                </ul>
                <p className="text-secondary-600 mt-4">
                  Kami juga menawarkan paket langganan bulanan yang dapat
                  menghemat biaya hingga 30%. Lihat halaman Harga kami untuk
                  informasi lebih detail.
                </p>
              </div>
            </div>

            <!-- FAQ Item 2 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Metode pembayaran apa yang diterima?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  LaundrEase menerima berbagai metode pembayaran untuk
                  kenyamanan Anda. Anda dapat membayar melalui kartu
                  kredit/debit, dompet digital (GoPay, OVO, DANA, LinkAja),
                  transfer bank, dan tunai saat pengantaran. Untuk pelanggan
                  berlangganan, kami akan menagih kartu Anda secara otomatis
                  setiap bulan. Semua transaksi online kami diproses melalui
                  gateway pembayaran yang aman.
                </p>
              </div>
            </div>

            <!-- FAQ Item 3 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Apakah ada biaya tambahan untuk penjemputan dan
                  pengantaran?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Tidak, layanan penjemputan dan pengantaran sudah termasuk
                  dalam harga untuk pesanan dengan nilai minimum Rp100.000.
                  Untuk pesanan di bawah nilai tersebut, akan dikenakan biaya
                  pengiriman sebesar Rp15.000-25.000 tergantung jarak. Pelanggan
                  berlangganan mendapatkan layanan penjemputan dan pengantaran
                  gratis tanpa minimum pembelian.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Delivery Questions -->
        <div id="delivery" className="max-w-3xl mx-auto mb-16 reveal">
          <h2
            className="text-2xl md:text-3xl font-bold text-secondary-900 mb-8 flex items-center"
          >
            <div
              className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3"
            >
              <i className="fas fa-truck"></i>
            </div>
            Pengantaran
          </h2>

          <div className="space-y-4">
            <!-- FAQ Item 1 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Kapan saya bisa menjadwalkan penjemputan dan
                  pengantaran?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Kami menawarkan slot penjemputan dan pengantaran dari pukul
                  08.00 hingga 20.00 setiap hari, termasuk akhir pekan. Anda
                  dapat memilih slot waktu 2 jam yang paling nyaman untuk Anda
                  (misalnya, 10.00-12.00). Untuk hasil terbaik, kami menyarankan
                  Anda menjadwalkan penjemputan setidaknya 24 jam sebelumnya,
                  meskipun kami sering dapat mengakomodasi permintaan pada hari
                  yang sama tergantung ketersediaan.
                </p>
              </div>
            </div>

            <!-- FAQ Item 2 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Bagaimana jika saya tidak ada di rumah saat penjemputan atau
                  pengantaran?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Jika Anda tidak dapat berada di rumah saat penjemputan atau
                  pengantaran, Anda dapat memberikan instruksi khusus melalui
                  aplikasi kami. Misalnya, Anda dapat meminta kami untuk
                  meninggalkan cucian dengan petugas keamanan atau tetangga.
                  Anda juga dapat menjadwalkan ulang penjemputan atau
                  pengantaran hingga 2 jam sebelum waktu yang dijadwalkan tanpa
                  biaya tambahan. Jika pengemudi kami tiba dan tidak ada yang
                  menerima, kami akan menghubungi Anda dan menunggu hingga 10
                  menit sebelum meninggalkan lokasi.
                </p>
              </div>
            </div>

            <!-- FAQ Item 3 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Bagaimana cara melacak status cucian saya?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Anda dapat melacak status cucian Anda secara real-time melalui
                  aplikasi atau situs web kami. Anda akan menerima notifikasi
                  saat cucian Anda dijemput, saat proses pencucian dimulai, saat
                  cucian Anda selesai, dan saat cucian Anda dalam perjalanan
                  untuk diantar. Anda juga dapat melihat estimasi waktu
                  pengantaran dan informasi pengemudi. Jika Anda memiliki
                  pertanyaan tentang status pesanan Anda, Anda dapat menghubungi
                  tim layanan pelanggan kami melalui aplikasi, telepon, atau
                  email.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Account Questions -->
        <div id="account" className="max-w-3xl mx-auto mb-16 reveal">
          <h2
            className="text-2xl md:text-3xl font-bold text-secondary-900 mb-8 flex items-center"
          >
            <div
              className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3"
            >
              <i className="fas fa-user"></i>
            </div>
            Akun & Aplikasi
          </h2>

          <div className="space-y-4">
            <!-- FAQ Item 1 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Bagaimana cara membuat akun LaundrEase?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Membuat akun LaundrEase sangat mudah. Anda dapat mendaftar
                  melalui situs web atau aplikasi kami. Cukup klik tombol "Sign
                  Up", masukkan alamat email Anda, buat kata sandi, dan berikan
                  informasi dasar seperti nama dan nomor telepon. Anda juga
                  dapat mendaftar menggunakan akun Google atau Facebook Anda
                  untuk proses yang lebih cepat. Setelah mendaftar, Anda perlu
                  memverifikasi alamat email Anda dan kemudian Anda siap untuk
                  mulai menggunakan layanan kami.
                </p>
              </div>
            </div>

            <!-- FAQ Item 2 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Di mana saya bisa mengunduh aplikasi LaundrEase?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Aplikasi LaundrEase tersedia untuk diunduh gratis di App Store
                  (iOS) dan Google Play Store (Android). Cukup cari "LaundrEase"
                  di toko aplikasi pilihan Anda dan klik tombol unduh. Aplikasi
                  kami kompatibel dengan iPhone yang menjalankan iOS 12.0 atau
                  lebih baru, dan perangkat Android yang menjalankan Android 6.0
                  atau lebih baru. Anda juga dapat mengakses semua fitur kami
                  melalui situs web seluler kami jika lebih suka tidak mengunduh
                  aplikasi.
                </p>
              </div>
            </div>

            <!-- FAQ Item 3 -->
            <div
              className="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
            >
              <button
                className="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
              >
                <span className="text-lg font-medium text-secondary-900"
                  >Bagaimana cara mengubah informasi akun saya?</span
                >
                <div className="ml-4 flex-shrink-0">
                  <i className="fas fa-plus text-primary-600 faq-icon-plus"></i>
                  <i className="fas fa-minus text-primary-600 faq-icon-minus"></i>
                </div>
              </button>
              <div className="faq-answer px-6 pb-6">
                <p className="text-secondary-600">
                  Untuk mengubah informasi akun Anda, masuk ke aplikasi atau
                  situs web LaundrEase dan kunjungi bagian "Profil" atau
                  "Pengaturan". Di sana Anda dapat memperbarui informasi
                  pribadi, alamat pengiriman, preferensi notifikasi, dan metode
                  pembayaran. Beberapa perubahan seperti alamat email utama
                  mungkin memerlukan verifikasi tambahan untuk keamanan. Jika
                  Anda memerlukan bantuan, tim dukungan pelanggan kami siap
                  membantu 24/7.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Support Section -->
    <section className="bg-primary-50 py-16 reveal">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="max-w-3xl mx-auto text-center">
          <h2 className="text-2xl md:text-3xl font-bold text-secondary-900 mb-4">
            Masih Punya Pertanyaan?
          </h2>
          <p className="text-secondary-600 mb-8">
            Tim dukungan pelanggan kami siap membantu Anda 24/7
          </p>
          <div className="flex flex-col sm:flex-row justify-center gap-4">
            <a
              href="contact.html"
              className="inline-flex items-center justify-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-300"
            >
              <i className="fas fa-headset mr-2"></i>
              Hubungi Kami
            </a>
            <a
              href="https://wa.me/6281234567890"
              className="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-600 font-medium rounded-lg border border-primary-600 hover:bg-primary-50 transition-all duration-300"
            >
              <i className="fab fa-whatsapp mr-2"></i>
              Chat WhatsApp
            </a>
          </div>
        </div>
      </div>
    </section>
   
    <Footer />
  </div>
</template>

<script setup>
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
</script>
