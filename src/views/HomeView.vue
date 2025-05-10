<template>
    <Header />
    <!-- Hero Section -->
    <section
      id="home"
      className="relative overflow-hidden bg-gradient-to-r from-primary-700 to-primary-900 text-white"
    >
      <div
        className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1604335399105-a0c585fd81a1?ixlib=rb-4.0.3&auto=format&fit=crop&q=80')] opacity-10 bg-cover bg-center"
      ></div>
      <div
        className="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 lg:py-32 relative"
      >
        <div className="flex flex-col md:flex-row items-center">
          <div className="md:w-1/2 mb-12 md:mb-0 reveal">
            <span
              className="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-6"
            >
              #1 Rated Laundry Service
            </span>
            <h1
              className="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
            >
              Laundry Tanpa <span className="text-primary-200">Ribet</span>
            </h1>
            <p className="text-lg md:text-xl mb-8 text-primary-100 max-w-xl">
              Nikmati layanan laundry premium dengan penjemputan, pencucian, dan
              pengantaran — semua dijadwalkan langsung dari ponsel Anda.
            </p>
            <div
              className="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4"
            >
              <a
                href="#"
                className="bg-white text-primary-700 px-8 py-4 rounded-md font-medium hover:bg-primary-50 shadow-lg hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1"
              >
                Pesan Sekarang
              </a>
              <a
                href="#how-it-works"
                className="bg-transparent border-2 border-white text-white px-8 py-4 rounded-md font-medium hover:bg-white/10 transition-all duration-300 text-center"
              >
                Pelajari Lebih Lanjut
              </a>
            </div>
          </div>
          <div className="md:w-1/2 reveal">
            <div className="relative">
              <div
                className="absolute -inset-4 bg-primary-600/20 rounded-3xl blur-xl"
              ></div>
              <img
                src="https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                alt="Laundry Service"
                className="relative rounded-2xl shadow-2xl w-full object-cover transform hover:scale-[1.02] transition-all duration-500"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </div>
      <div className="absolute bottom-0 left-0 right-0">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 1440 120"
          class="fill-white"
        >
          <path
            d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"
          ></path>
        </svg>
      </div>
    </section>

    <!-- Features Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Keunggulan Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Mengapa Memilih LaundrEase?
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Rasakan kemudahan layanan laundry modern dengan fitur-fitur yang
            dirancang untuk mempermudah hidup Anda.
          </p>
        </div>

        <div
          className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10"
        >
          <!-- Feature 1 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-truck-fast text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Pickup & Delivery
            </h3>
            <p className="text-secondary-600">
              Kami menjemput dan mengantarkan kembali cucian Anda hingga ke
              depan pintu tanpa biaya tambahan, menghemat waktu dan tenaga Anda.
            </p>
          </div>

          <!-- Feature 2 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-credit-card text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Secure Online Payment
            </h3>
            <p className="text-secondary-600">
              Bayar dengan aman secara daring melalui berbagai metode
              pembayaran, termasuk kartu kredit, dompet digital, dan transfer
              bank.
            </p>
          </div>

          <!-- Feature 3 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-location-dot text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Real-time Tracking
            </h3>
            <p className="text-secondary-600">
              Lacak status cucian Anda secara langsung mulai dari penjemputan
              hingga pengantaran melalui aplikasi seluler kami yang mudah
              digunakan.
            </p>
          </div>

          <!-- Feature 4 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-clock text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Express Service
            </h3>
            <p className="text-secondary-600">
              Butuh pakaian Anda segera? Layanan ekspres kami menjamin cucian
              Anda siap dalam waktu 8 jam.
            </p>
          </div>

          <!-- Feature 5 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-shirt text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Premium Dry Cleaning
            </h3>
            <p className="text-secondary-600">
              Perawatan khusus untuk pakaian lembut Anda melalui layanan dry
              cleaning profesional kami.
            </p>
          </div>

          <!-- Feature 6 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-leaf text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Eco-Friendly Process
            </h3>
            <p className="text-secondary-600">
              Kami menggunakan deterjen ramah lingkungan dan mesin hemat energi
              untuk mengurangi jejak karbon kami.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section id="services" className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Layanan Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Solusi Binatu Profesional
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Kami menyediakan berbagai layanan binatu dan cuci lengkap untuk
            memenuhi seluruh kebutuhan Anda.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Layanan 1 -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="relative overflow-hidden h-56">
              <img
                src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Cuci dan Lipat"
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              />
              <div
                className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div
                className="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"
              >
                <p className="font-medium">
                  Pencucian dan pelipatan profesional untuk seluruh pakaian
                  harian Anda
                </p>
              </div>
            </div>
            <div className="p-6">
              <h3
                className="text-xl font-semibold mb-2 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
              >
                Cuci dan Lipat
              </h3>
              <p className="text-secondary-600 mb-4">
                Pakaian harian Anda dicuci, dikeringkan, dan dilipat dengan
                rapi, siap disimpan.
              </p>
              <div className="flex justify-between items-center">
                <span className="text-primary-600 font-semibold"
                  >Mulai dari Rp12.000/Kg</span
                >
                <a
                  href="#"
                  className="text-primary-600 hover:text-primary-700 font-medium group-hover:underline"
                  >Selengkapnya →</a
                >
              </div>
            </div>
          </div>

          <!-- Layanan 2 -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="relative overflow-hidden h-56">
              <img
                src="https://images.unsplash.com/photo-1489274495757-95c7c837b101?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Cuci Kering"
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              />
              <div
                className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div
                className="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"
              >
                <p className="font-medium">
                  Perawatan ahli untuk pakaian formal dan berbahan lembut
                </p>
              </div>
            </div>
            <div className="p-6">
              <h3
                className="text-xl font-semibold mb-2 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
              >
                Cuci Kering
              </h3>
              <p className="text-secondary-600 mb-4">
                Layanan cuci kering profesional untuk jas, gaun, dan pakaian
                berbahan khusus.
              </p>
              <div className="flex justify-between items-center">
                <span className="text-primary-600 font-semibold"
                  >Mulai dari Rp79.000/item</span
                >
                <a
                  href="#"
                  className="text-primary-600 hover:text-primary-700 font-medium group-hover:underline"
                  >Selengkapnya →</a
                >
              </div>
            </div>
          </div>

          <!-- Layanan 3 -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="relative overflow-hidden h-56">
              <img
                src="https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Setrika & Pres"
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              />
              <div
                className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div
                className="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"
              >
                <p className="font-medium">
                  Setrika profesional untuk hasil rapi dan bebas kusut
                </p>
              </div>
            </div>
            <div className="p-6">
              <h3
                className="text-xl font-semibold mb-2 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
              >
                Setrika & Pres
              </h3>
              <p className="text-secondary-600 mb-4">
                Pakaian Anda disetrika secara profesional agar terlihat segar
                dan rapi.
              </p>
              <div className="flex justify-between items-center">
                <span className="text-primary-600 font-semibold"
                  >Mulai dari Rp39.000/item</span
                >
                <a
                  href="#"
                  className="text-primary-600 hover:text-primary-700 font-medium group-hover:underline"
                  >Selengkapnya →</a
                >
              </div>
            </div>
          </div>

          <!-- Layanan lainnya dapat dilanjutkan dengan format serupa -->
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" className="py-20 bg-white relative overflow-hidden">
      <div
        className="absolute top-0 right-0 w-1/3 h-full bg-primary-50 -z-10 rounded-l-3xl"
      ></div>
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Proses Sederhana</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Cara Kerjanya
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Mencuci pakaian kini menjadi lebih mudah. Ikuti langkah-langkah
            sederhana berikut ini:
          </p>
        </div>

        <div
          className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative"
        >
          <!-- Langkah 1 -->
          <div className="text-center reveal">
            <div className="relative inline-block">
              <div
                className="w-20 h-20 bg-primary-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6 shadow-lg transform hover:rotate-6 transition-all duration-300"
              >
                1
              </div>
              <div
                className="hidden lg:block absolute top-10 left-full w-full h-1 bg-primary-200 z-0"
              ></div>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Jadwalkan Penjemputan
            </h3>
            <p className="text-secondary-600 mx-auto max-w-xs">
              Pesan waktu penjemputan yang sesuai dengan jadwal Anda melalui
              situs web atau aplikasi kami.
            </p>
          </div>

          <!-- Langkah 2 -->
          <div className="text-center reveal">
            <div className="relative inline-block">
              <div
                className="w-20 h-20 bg-primary-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6 shadow-lg transform hover:rotate-6 transition-all duration-300"
              >
                2
              </div>
              <div
                className="hidden lg:block absolute top-10 left-full w-full h-1 bg-primary-200 z-0"
              ></div>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Kami Menjemput
            </h3>
            <p className="text-secondary-600 mx-auto max-w-xs">
              Pengemudi kami akan menjemput cucian Anda langsung dari depan
              rumah sesuai waktu yang dijadwalkan.
            </p>
          </div>

          <!-- Langkah 3 -->
          <div className="text-center reveal">
            <div className="relative inline-block">
              <div
                className="w-20 h-20 bg-primary-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6 shadow-lg transform hover:rotate-6 transition-all duration-300"
              >
                3
              </div>
              <div
                className="hidden lg:block absolute top-10 left-full w-full h-1 bg-primary-200 z-0"
              ></div>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Kami Mencuci
            </h3>
            <p className="text-secondary-600 mx-auto max-w-xs">
              Pakaian Anda akan dicuci secara profesional sesuai dengan layanan
              yang Anda pilih.
            </p>
          </div>

          <!-- Langkah 4 -->
          <div className="text-center reveal">
            <div className="inline-block">
              <div
                className="w-20 h-20 bg-primary-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6 shadow-lg transform hover:rotate-6 transition-all duration-300"
              >
                4
              </div>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Kami Antar
            </h3>
            <p className="text-secondary-600 mx-auto max-w-xs">
              Pakaian bersih dan segar Anda akan dikirim kembali ke depan rumah
              sesuai waktu yang Anda inginkan.
            </p>
          </div>
        </div>

        <div className="mt-16 text-center reveal">
          <a
            href="#"
            className="inline-flex items-center bg-primary-600 text-white px-8 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
          >
            <i className="fas fa-mobile-screen-button mr-2"></i> Unduh Aplikasi Kami
          </a>
        </div>
      </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Paket Harga</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Harga yang Sederhana dan Transparan
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Pilih paket yang sesuai dengan kebutuhan laundry Anda.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
          <!-- Paket Dasar -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div className="p-8 border-b border-secondary-100">
              <h3
                className="text-2xl font-bold text-secondary-900 mb-2 group-hover:text-primary-600 transition-colors duration-300"
              >
                Dasar
              </h3>
              <p className="text-secondary-600">Cocok untuk individu</p>
              <div className="mt-6 flex items-end">
                <span className="text-5xl font-bold text-primary-600">300k</span>
                <span className="text-secondary-600 ml-2">/bulan</span>
              </div>
              <p className="text-sm text-secondary-500 mt-2">
                Hingga 20 lbs laundry per bulan
              </p>
            </div>
            <div className="p-8">
              <ul className="space-y-4">
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Penjemputan & pengantaran mingguan</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Layanan cuci & lipat</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Proses dalam 48 jam</span>
                </li>
                <li className="flex items-center text-secondary-400">
                  <div
                    className="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-times text-red-600 text-sm"></i>
                  </div>
                  <span>Cuci kering</span>
                </li>
                <li className="flex items-center text-secondary-400">
                  <div
                    className="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-times text-red-600 text-sm"></i>
                  </div>
                  <span>Layanan ekspres</span>
                </li>
              </ul>
              <a
                href="#"
                className="mt-8 block text-center bg-primary-600 text-white px-6 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform group-hover:-translate-y-1"
                >Pilih Paket</a
              >
            </div>
          </div>

          <!-- Paket Premium -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-xl border-2 border-primary-500 transform md:-translate-y-4 scale-105 z-10 reveal"
          >
            <div
              className="bg-primary-600 text-white text-center py-2 text-sm font-semibold"
            >
              PAKET PALING POPULER
            </div>
            <div className="p-8 border-b border-secondary-100">
              <h3 className="text-2xl font-bold text-secondary-900 mb-2">
                Premium
              </h3>
              <p className="text-secondary-600">Ideal untuk pasangan & keluarga</p>
              <div className="mt-6 flex items-end">
                <span className="text-5xl font-bold text-primary-600">500k</span>
                <span className="text-secondary-600 ml-2">/bulan</span>
              </div>
              <p className="text-sm text-secondary-500 mt-2">
                Hingga 40 lbs laundry per bulan
              </p>
            </div>
            <div className="p-8">
              <ul className="space-y-4">
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Penjemputan & pengantaran dua minggu sekali</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Layanan cuci & lipat</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Proses dalam 24 jam</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Cuci kering dasar (5 item)</span>
                </li>
                <li className="flex items-center text-secondary-400">
                  <div
                    className="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-times text-red-600 text-sm"></i>
                  </div>
                  <span>Layanan ekspres</span>
                </li>
              </ul>
              <a
                href="#"
                className="mt-8 block text-center bg-primary-600 text-white px-6 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                >Pilih Paket</a
              >
            </div>
          </div>

          <!-- Paket Ultimate -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div className="p-8 border-b border-secondary-100">
              <h3
                className="text-2xl font-bold text-secondary-900 mb-2 group-hover:text-primary-600 transition-colors duration-300"
              >
                Ultimate
              </h3>
              <p className="text-secondary-600">Untuk keluarga besar</p>
              <div className="mt-6 flex items-end">
                <span className="text-5xl font-bold text-primary-600">1000k</span>
                <span className="text-secondary-600 ml-2">/bulan</span>
              </div>
              <p className="text-sm text-secondary-500 mt-2">
                Hingga 80 lbs laundry per bulan
              </p>
            </div>
            <div className="p-8">
              <ul className="space-y-4">
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Penjemputan & pengantaran tak terbatas</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Layanan cuci & lipat</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Proses pada hari yang sama</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Cuci kering premium (10 item)</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-sm"></i>
                  </div>
                  <span>Layanan ekspres termasuk</span>
                </li>
              </ul>
              <a
                href="#"
                className="mt-8 block text-center bg-primary-600 text-white px-6 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform group-hover:-translate-y-1"
                >Pilih Paket</a
              >
            </div>
          </div>
        </div>

        <div className="mt-16 text-center reveal">
          <p className="text-secondary-600 mb-4">
            Butuh paket kustom untuk bisnis Anda? Kami menawarkan tarif khusus
            untuk bisnis.
          </p>
          <a
            href="#"
            className="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium group"
          >
            <span>Hubungi kami untuk harga bisnis</span>
            <i
              className="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"
            ></i>
          </a>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Testimoni</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Apa Kata Pelanggan Kami
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Jangan hanya percaya pada kata kami. Inilah pendapat dari para
            pelanggan yang puas.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Testimoni 1 -->
          <div
            className="bg-secondary-50 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="flex items-center mb-6">
              <img
                src="https://randomuser.me/api/portraits/women/32.jpg"
                alt="Sarah Johnson"
                className="w-14 h-14 rounded-full object-cover mr-4 border-2 border-primary-200"
                loading="lazy"
              />
              <div>
                <h4
                  className="font-semibold text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
                >
                  Sarah Johnson
                </h4>
                <p className="text-secondary-500 text-sm">New York, NY</p>
              </div>
            </div>
            <p className="text-secondary-600 mb-6 italic">
              "LaundrEase benar-benar mengubah cara saya menangani cucian.
              Layanan penjemputan dan pengantarannya sangat praktis, dan pakaian
              saya selalu kembali dalam keadaan bersih dan terlipat rapi. Sangat
              saya rekomendasikan!"
            </p>
            <div className="flex text-yellow-400">
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
            </div>
          </div>

          <!-- Testimoni 2 -->
          <div
            className="bg-secondary-50 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="flex items-center mb-6">
              <img
                src="https://randomuser.me/api/portraits/men/45.jpg"
                alt="Michael Chen"
                className="w-14 h-14 rounded-full object-cover mr-4 border-2 border-primary-200"
                loading="lazy"
              />
              <div>
                <h4
                  className="font-semibold text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
                >
                  Michael Chen
                </h4>
                <p className="text-secondary-500 text-sm">San Francisco, CA</p>
              </div>
            </div>
            <p className="text-secondary-600 mb-6 italic">
              "Sebagai seorang profesional yang sibuk, saya tidak punya waktu
              untuk mencuci pakaian. Paket langganan LaundrEase sangat cocok
              untuk saya. Aplikasinya mudah digunakan, dan sistem pembayarannya
              juga lancar. Layanan yang luar biasa!"
            </p>
            <div className="flex text-yellow-400">
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star-half-alt"></i>
            </div>
          </div>

          <!-- Testimoni 3 -->
          <div
            className="bg-secondary-50 p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="flex items-center mb-6">
              <img
                src="https://randomuser.me/api/portraits/women/68.jpg"
                alt="Emily Rodriguez"
                className="w-14 h-14 rounded-full object-cover mr-4 border-2 border-primary-200"
                loading="lazy"
              />
              <div>
                <h4
                  className="font-semibold text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
                >
                  Emily Rodriguez
                </h4>
                <p className="text-secondary-500 text-sm">Chicago, IL</p>
              </div>
            </div>
            <p className="text-secondary-600 mb-6 italic">
              "Saya sudah mencoba beberapa layanan laundry, dan LaundrEase
              adalah yang terbaik sejauh ini. Perhatian mereka terhadap detail
              sangat mengesankan, dan fitur pelacakan waktu nyata memberi tahu
              saya kapan cucian saya akan tiba."
            </p>
            <div className="flex text-yellow-400">
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
              <i className="fas fa-star"></i>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section
      className="py-20 bg-gradient-to-r from-primary-700 to-primary-900 text-white relative overflow-hidden"
    >
      <div
        className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')] opacity-10 bg-cover bg-center mix-blend-overlay"
      ></div>
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div className="max-w-3xl mx-auto text-center reveal">
          <h2 className="text-3xl md:text-4xl font-bold mb-6">
            Siap untuk Tidak Mencuci Pakaian Lagi?
          </h2>
          <p className="text-lg mb-8 text-primary-100 max-w-2xl mx-auto">
            Bergabunglah bersama ribuan pelanggan puas yang telah mendapatkan
            kembali waktu mereka dengan mempercayakan cucian kepada kami.
          </p>
          <div
            className="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4"
          >
            <a
              href="#"
              className="bg-white text-primary-700 px-8 py-4 rounded-md font-medium hover:bg-primary-50 shadow-lg hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1"
            >
              Jadwalkan Penjemputan Pertama Anda
            </a>
            <a
              href="#"
              className="bg-transparent border-2 border-white text-white px-8 py-4 rounded-md font-medium hover:bg-white/10 transition-all duration-300 text-center"
            >
              Unduh Aplikasi Kami
            </a>
          </div>
          <p className="mt-6 text-sm text-primary-100">
            Tanpa kontrak. Batalkan kapan saja.
          </p>
        </div>
      </div>
    </section>

    <!-- App Download Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col md:flex-row items-center">
          <div className="md:w-1/2 mb-12 md:mb-0 reveal">
            <span
              className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
              >Aplikasi Seluler</span
            >
            <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-6">
              Unduh Aplikasi Seluler Kami
            </h2>
            <p className="text-lg text-secondary-600 mb-8">
              Rasakan pengalaman LaundrEase sepenuhnya melalui aplikasi seluler
              kami. Jadwalkan penjemputan, lacak cucian Anda, dan kelola
              pembayaran langsung dari ponsel Anda.
            </p>
            <ul className="space-y-4 mb-8">
              <li className="flex items-center">
                <div
                  className="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 text-primary-600"
                >
                  <i className="fas fa-check text-sm"></i>
                </div>
                <span>Penjadwalan dan penjadwalan ulang yang mudah</span>
              </li>
              <li className="flex items-center">
                <div
                  className="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 text-primary-600"
                >
                  <i className="fas fa-check text-sm"></i>
                </div>
                <span>Pemberitahuan pelacakan waktu nyata</span>
              </li>
              <li className="flex items-center">
                <div
                  className="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 text-primary-600"
                >
                  <i className="fas fa-check text-sm"></i>
                </div>
                <span>Pengelolaan pembayaran yang aman</span>
              </li>
              <li className="flex items-center">
                <div
                  className="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 text-primary-600"
                >
                  <i className="fas fa-check text-sm"></i>
                </div>
                <span>Diskon eksklusif khusus pengguna seluler</span>
              </li>
            </ul>
            <div
              className="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4"
            >
              <a
                href="#"
                className="bg-black text-white px-6 py-3 rounded-xl flex items-center hover:bg-secondary-800 transition-all duration-300 shadow-md hover:shadow-lg"
              >
                <i className="fab fa-apple text-2xl mr-3"></i>
                <div>
                  <div className="text-xs">Unduh di</div>
                  <div className="text-sm font-semibold">App Store</div>
                </div>
              </a>
              <a
                href="#"
                className="bg-black text-white px-6 py-3 rounded-xl flex items-center hover:bg-secondary-800 transition-all duration-300 shadow-md hover:shadow-lg"
              >
                <i className="fab fa-google-play text-2xl mr-3"></i>
                <div>
                  <div className="text-xs">Dapatkan di</div>
                  <div className="text-sm font-semibold">Google Play</div>
                </div>
              </a>
            </div>
          </div>
          <div className="md:w-1/2 flex justify-center reveal">
            <div className="relative">
              <div
                className="absolute -inset-4 bg-primary-600/10 rounded-3xl blur-xl"
              ></div>
              <img
                src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                alt="Aplikasi Seluler LaundrEase"
                className="relative w-64 shadow-2xl rounded-3xl border-8 border-white transform hover:rotate-3 transition-all duration-500"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="max-w-5xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div className="reveal">
              <span
                className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
                >Hubungi Kami</span
              >
              <h2
                className="text-3xl md:text-4xl font-bold text-secondary-900 mb-6"
              >
                Kontak Kami
              </h2>
              <p className="text-lg text-secondary-600 mb-8">
                Punya pertanyaan atau butuh bantuan? Tim layanan pelanggan kami
                siap membantu segala pertanyaan Anda.
              </p>


              <div className="space-y-6">
                <div className="flex items-start">
                  <div
                    className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                  >
                    <i className="fas fa-map-marker-alt"></i>
                  </div>
                  <div>
                    <h4 className="font-semibold text-secondary-900 mb-1">
                      Lokasi Kami
                    </h4>
                    <p className="text-secondary-600">
                      Jl. Raya Gresik No. 123, Gresik, Jawa Timur 61122
                    </p>
                  </div>
                </div>

                <div className="flex items-start">
                  <div
                    className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                  >
                    <i className="fas fa-phone"></i>
                  </div>
                  <div>
                    <h4 className="font-semibold text-secondary-900 mb-1">
                      Nomor Telepon
                    </h4>
                    <p className="text-secondary-600">(031) 1234-5678</p>
                  </div>
                </div>

                <div className="flex items-start">
                  <div
                    className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                  >
                    <i className="fas fa-envelope"></i>
                  </div>
                  <div>
                    <h4 className="font-semibold text-secondary-900 mb-1">
                      Alamat Surel
                    </h4>
                    <p className="text-secondary-600">hello@laundrease.com</p>
                  </div>
                </div>

                <div className="flex items-start">
                  <div
                    className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                  >
                    <i className="fas fa-clock"></i>
                  </div>
                  <div>
                    <h4 className="font-semibold text-secondary-900 mb-1">
                      Jam Operasional
                    </h4>
                    <p className="text-secondary-600">
                      Senin - Jumat: 08.00 - 20.00<br />Sabtu - Minggu: 09.00 -
                      18.00
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div className="bg-white p-8 rounded-xl shadow-md reveal">
              <h3 className="text-2xl font-semibold text-secondary-900 mb-6">
                Kirim Pesan kepada Kami
              </h3>
              <form>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                  <div>
                    <label
                      for="name"
                      className="block text-sm font-medium text-secondary-700 mb-2"
                      >Nama Lengkap</label
                    >
                    <input
                      type="text"
                      id="name"
                      className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                      placeholder="Nama Anda"
                    />
                  </div>
                  <div>
                    <label
                      for="email"
                      className="block text-sm font-medium text-secondary-700 mb-2"
                      >Alamat Surel</label
                    >
                    <input
                      type="email"
                      id="email"
                      className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                      placeholder="Email Anda"
                    />
                  </div>
                </div>
                <div className="mb-6">
                  <label
                    for="subject"
                    className="block text-sm font-medium text-secondary-700 mb-2"
                    >Subjek</label
                  >
                  <input
                    type="text"
                    id="subject"
                    className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                    placeholder="Subjek pesan"
                  />
                </div>
                <div className="mb-6">
                  <label
                    for="message"
                    className="block text-sm font-medium text-secondary-700 mb-2"
                    >Pesan</label
                  >
                  <textarea
                    id="message"
                    rows="5"
                    className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                    placeholder="Tulis pesan Anda"
                  ></textarea>
                </div>
                <button
                  type="submit"
                  className="w-full bg-primary-600 text-white px-6 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                >
                  Kirim Pesan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Footer />
</template>

<script setup>
import Footer from '../components/Footer.vue';
import Header from '../components/Header.vue';
</script>

<!-- <HelloWorld msg="Welcome to the LaundrEase App" /> -->
