<template>
  <div>
    <Header />
    
    <!-- Page Header -->
    <section
      className="bg-gradient-to-r from-primary-700 to-primary-900 text-white py-16 md:py-24 relative overflow-hidden"
    >
      <div
        className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')] opacity-10 bg-cover bg-center mix-blend-overlay"
      ></div>
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div className="max-w-3xl mx-auto text-center reveal">
          <h1
            className="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
          >
            Layanan Kami
          </h1>
          <p className="text-lg md:text-xl mb-8 text-primary-100 max-w-2xl mx-auto">
            Solusi laundry lengkap untuk semua kebutuhan pakaian dan linen Anda.
          </p>
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

    <!-- Main Services Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Layanan Utama</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Layanan Laundry Premium
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Kami menawarkan berbagai layanan laundry berkualitas tinggi untuk
            memenuhi semua kebutuhan Anda.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
          <!-- Service 1: Cuci & Lipat -->
          <div className="flex flex-col md:flex-row gap-8 reveal">
            <div className="md:w-2/5">
              <div className="relative rounded-xl overflow-hidden h-64 md:h-full">
                <img
                  src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Cuci & Lipat"
                  className="w-full h-full object-cover"
                  loading="lazy"
                />
              </div>
            </div>
            <div className="md:w-3/5">
              <h3 className="text-2xl font-bold text-secondary-900 mb-4">
                Cuci & Lipat
              </h3>
              <p className="text-secondary-600 mb-4">
                Layanan cuci dan lipat kami adalah solusi sempurna untuk pakaian
                sehari-hari Anda. Kami mencuci, mengeringkan, dan melipat
                pakaian Anda dengan hati-hati, sehingga siap untuk disimpan di
                lemari Anda.
              </p>
              <ul className="space-y-2 mb-6">
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Deterjen premium ramah lingkungan</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pelipatan profesional</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pengemasan rapi dengan kertas pembungkus</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pengantaran dalam 24-48 jam</span>
                </li>
              </ul>
              <div className="flex items-center justify-between">
                <span className="text-xl font-bold text-primary-600"
                  >Mulai dari Rp12.000/kg</span
                >
                <a
                  href="#"
                  className="bg-primary-600 text-white px-6 py-3 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300"
                >
                  Pesan Sekarang
                </a>
              </div>
            </div>
          </div>

          <!-- Service 2: Cuci Kering -->
          <div className="flex flex-col md:flex-row gap-8 reveal">
            <div className="md:w-2/5">
              <div className="relative rounded-xl overflow-hidden h-64 md:h-full">
                <img
                  src="https://images.unsplash.com/photo-1489274495757-95c7c837b101?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Cuci Kering"
                  className="w-full h-full object-cover"
                  loading="lazy"
                />
              </div>
            </div>
            <div className="md:w-3/5">
              <h3 className="text-2xl font-bold text-secondary-900 mb-4">
                Cuci Kering
              </h3>
              <p className="text-secondary-600 mb-4">
                Layanan cuci kering profesional kami ideal untuk pakaian formal,
                sutra, wol, dan kain halus lainnya yang membutuhkan perawatan
                khusus. Kami menggunakan teknik dan pelarut khusus untuk
                membersihkan pakaian Anda tanpa air.
              </p>
              <ul className="space-y-2 mb-6">
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Perawatan khusus untuk kain sensitif</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Penghilangan noda profesional</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Perawatan jas, gaun, dan pakaian formal</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pengemasan dengan hanger premium</span>
                </li>
              </ul>
              <div className="flex items-center justify-between">
                <span className="text-xl font-bold text-primary-600"
                  >Mulai dari Rp79.000/item</span
                >
                <a
                  href="#"
                  className="bg-primary-600 text-white px-6 py-3 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300"
                >
                  Pesan Sekarang
                </a>
              </div>
            </div>
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
          <!-- Service 3: Setrika & Pres -->
          <div className="flex flex-col md:flex-row gap-8 reveal">
            <div className="md:w-2/5">
              <div className="relative rounded-xl overflow-hidden h-64 md:h-full">
                <img
                  src="https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Setrika & Pres"
                  className="w-full h-full object-cover"
                  loading="lazy"
                />
              </div>
            </div>
            <div className="md:w-3/5">
              <h3 className="text-2xl font-bold text-secondary-900 mb-4">
                Setrika & Pres
              </h3>
              <p className="text-secondary-600 mb-4">
                Layanan setrika profesional kami menjamin pakaian Anda terlihat
                rapi dan bebas kerutan. Sempurna untuk kemeja kantor, celana,
                dan pakaian formal yang membutuhkan tampilan profesional.
              </p>
              <ul className="space-y-2 mb-6">
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Setrika uap profesional</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pres untuk lipatan sempurna</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Penanganan khusus untuk berbagai jenis kain</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span
                    >Pengantaran dengan hanger untuk menghindari kerutan</span
                  >
                </li>
              </ul>
              <div className="flex items-center justify-between">
                <span className="text-xl font-bold text-primary-600"
                  >Mulai dari Rp39.000/item</span
                >
                <a
                  href="#"
                  className="bg-primary-600 text-white px-6 py-3 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300"
                >
                  Pesan Sekarang
                </a>
              </div>
            </div>
          </div>

          <!-- Service 4: Seprai & Linen -->
          <div className="flex flex-col md:flex-row gap-8 reveal">
            <div className="md:w-2/5">
              <div className="relative rounded-xl overflow-hidden h-64 md:h-full">
                <img
                  src="https://images.unsplash.com/photo-1584470179563-9f3f4e1d1d3d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                  alt="Seprai & Linen"
                  className="w-full h-full object-cover"
                  loading="lazy"
                />
              </div>
            </div>
            <div className="md:w-3/5">
              <h3 className="text-2xl font-bold text-secondary-900 mb-4">
                Seprai & Linen
              </h3>
              <p className="text-secondary-600 mb-4">
                Layanan khusus untuk seprai, selimut, sarung bantal, dan linen
                rumah tangga lainnya. Kami menggunakan deterjen lembut dan
                teknik khusus untuk menjaga kualitas dan kelembutan linen Anda.
              </p>
              <ul className="space-y-2 mb-6">
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pencucian dengan air suhu tinggi untuk sanitasi</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Deterjen hipoalergenik</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pelipatan profesional</span>
                </li>
                <li className="flex items-center">
                  <div
                    className="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3"
                  >
                    <i className="fas fa-check text-green-600 text-xs"></i>
                  </div>
                  <span>Pengemasan rapi dan bersih</span>
                </li>
              </ul>
              <div className="flex items-center justify-between">
                <span className="text-xl font-bold text-primary-600"
                  >Mulai dari Rp25.000/kg</span
                >
                <a
                  href="#"
                  className="bg-primary-600 text-white px-6 py-3 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300"
                >
                  Pesan Sekarang
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Specialty Services Section -->
    <section className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Layanan Khusus</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Layanan Premium Tambahan
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Kami juga menawarkan layanan khusus untuk kebutuhan laundry yang
            lebih spesifik.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Specialty Service 1 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-bolt text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Layanan Ekspres
            </h3>
            <p className="text-secondary-600 mb-6">
              Butuh pakaian Anda segera? Layanan ekspres kami menjamin
              pengerjaan dalam 8 jam untuk kebutuhan mendesak Anda.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-primary-600 font-semibold"
                >+50% dari harga reguler</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium group-hover:underline"
              >
                Selengkapnya →
              </a>
            </div>
          </div>

          <!-- Specialty Service 2 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-building text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Layanan Bisnis
            </h3>
            <p className="text-secondary-600 mb-6">
              Solusi laundry khusus untuk hotel, restoran, spa, dan bisnis
              lainnya dengan harga korporat yang kompetitif.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-primary-600 font-semibold">Harga khusus</span>
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium group-hover:underline"
              >
                Selengkapnya →
              </a>
            </div>
          </div>

          <!-- Specialty Service 3 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-couch text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Pembersihan Karpet & Gorden
            </h3>
            <p className="text-secondary-600 mb-6">
              Layanan pembersihan profesional untuk karpet, gorden, dan tekstil
              rumah tangga lainnya dengan hasil yang bersih dan segar.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-primary-600 font-semibold"
                >Mulai dari Rp50.000/m²</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium group-hover:underline"
              >
                Selengkapnya →
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Process Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Proses Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Bagaimana Kami Bekerja
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Proses laundry kami dirancang untuk memberikan hasil terbaik dengan
            memperhatikan setiap detail.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Step 1 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-600 rounded-full flex items-center justify-center text-white text-xl font-bold mb-6 group-hover:scale-110 transition-transform duration-300"
            >
              1
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Sortir & Inspeksi
            </h3>
            <p className="text-secondary-600">
              Kami menyortir pakaian berdasarkan warna, jenis kain, dan tingkat
              kekotoran, serta memeriksa kantong dan noda.
            </p>
          </div>

          <!-- Step 2 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-600 rounded-full flex items-center justify-center text-white text-xl font-bold mb-6 group-hover:scale-110 transition-transform duration-300"
            >
              2
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Pra-Perawatan
            </h3>
            <p className="text-secondary-600">
              Noda yang membandel mendapatkan perawatan khusus sebelum proses
              pencucian utama untuk hasil yang optimal.
            </p>
          </div>

          <!-- Step 3 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-600 rounded-full flex items-center justify-center text-white text-xl font-bold mb-6 group-hover:scale-110 transition-transform duration-300"
            >
              3
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Pencucian & Pengeringan
            </h3>
            <p className="text-secondary-600">
              Menggunakan mesin modern dan deterjen berkualitas tinggi, pakaian
              Anda dicuci dan dikeringkan dengan hati-hati.
            </p>
          </div>

          <!-- Step 4 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-14 h-14 bg-primary-600 rounded-full flex items-center justify-center text-white text-xl font-bold mb-6 group-hover:scale-110 transition-transform duration-300"
            >
              4
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Finishing & Pengemasan
            </h3>
            <p className="text-secondary-600">
              Pakaian dilipat dengan rapi atau digantung, diperiksa kualitasnya,
              dan dikemas dengan aman untuk pengantaran.
            </p>
          </div>
        </div>

        <div className="mt-16 text-center reveal">
          <a
            href="pricing.html"
            className="inline-flex items-center bg-primary-600 text-white px-8 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
          >
            <span>Lihat Harga Layanan Kami</span>
            <i className="fas fa-arrow-right ml-2"></i>
          </a>
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
            Siap untuk Mencoba Layanan Kami?
          </h2>
          <p className="text-lg mb-8 text-primary-100 max-w-2xl mx-auto">
            Jadwalkan penjemputan pertama Anda hari ini dan rasakan perbedaan
            layanan laundry premium LaundrEase.
          </p>
          <div
            className="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4"
          >
            <a
              href="#"
              className="bg-white text-primary-700 px-8 py-4 rounded-md font-medium hover:bg-primary-50 shadow-lg hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1"
            >
              Jadwalkan Penjemputan
            </a>
            <a
              href="contact.html"
              className="bg-transparent border-2 border-white text-white px-8 py-4 rounded-md font-medium hover:bg-white/10 transition-all duration-300 text-center"
            >
              Hubungi Kami
            </a>
          </div>
        </div>
      </div>
    </section>
    
    <Footer />
  </div>
</template>

<script setup>
import Footer from '../components/Footer.vue';
import Header from '../components/Header.vue';
</script>
