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
            Tentang LaundrEase
          </h1>
          <p className="text-lg md:text-xl mb-8 text-primary-100 max-w-2xl mx-auto">
            Mengenal lebih dekat dengan layanan laundry modern yang mengubah
            cara Anda mencuci pakaian.
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

    <!-- Our Story Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col md:flex-row items-center gap-12">
          <div className="md:w-1/2 reveal">
            <span
              className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
              >Cerita Kami</span
            >
            <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-6">
              Perjalanan LaundrEase
            </h2>
            <p className="text-lg text-secondary-600 mb-6">
              LaundrEase didirikan pada tahun 2025 dengan visi sederhana:
              membuat mencuci pakaian menjadi lebih mudah bagi semua orang. Kami
              memahami bahwa dalam kehidupan modern yang sibuk, waktu adalah
              aset berharga.
            </p>
            <p className="text-lg text-secondary-600 mb-6">
              Pendiri kami, Faiz Nurullah, seorang profesional sibuk yang
              frustrasi dengan waktu berharga yang terbuang untuk mencuci
              pakaian, memutuskan untuk menciptakan solusi yang akan mengubah
              industri laundry selamanya.
            </p>
            <p className="text-lg text-secondary-600">
              Sejak itu, LaundrEase telah berkembang dari startup kecil menjadi
              layanan laundry terkemuka dengan ribuan pelanggan setia di seluruh
              Indonesia. Misi kami tetap sama: memberikan kebebasan kepada
              orang-orang untuk fokus pada hal-hal yang benar-benar penting
              dalam hidup mereka.
            </p>
          </div>
          <div className="md:w-1/2 reveal">
            <div className="relative">
              <div
                className="absolute -inset-4 bg-primary-600/20 rounded-3xl blur-xl"
              ></div>
              <img
                src="https://images.unsplash.com/photo-1521898284481-a5ec348cb555?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                alt="Founder LaundrEase"
                className="relative rounded-2xl shadow-2xl w-full object-cover transform hover:scale-[1.02] transition-all duration-500"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Mission Section -->
    <section className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Misi Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Nilai-Nilai yang Kami Pegang
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Di LaundrEase, kami berkomitmen pada nilai-nilai inti yang membentuk
            setiap aspek bisnis kami.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Value 1 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-star text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Kualitas Tanpa Kompromi
            </h3>
            <p className="text-secondary-600">
              Kami berkomitmen untuk memberikan layanan laundry berkualitas
              tertinggi dengan perhatian terhadap detail dan perawatan khusus
              untuk setiap pakaian.
            </p>
          </div>

          <!-- Value 2 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-leaf text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Keberlanjutan
            </h3>
            <p className="text-secondary-600">
              Kami menggunakan deterjen ramah lingkungan, mesin hemat energi,
              dan praktik berkelanjutan untuk mengurangi dampak lingkungan kami.
            </p>
          </div>

          <!-- Value 3 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100 group reveal"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300"
            >
              <i className="fas fa-users text-2xl"></i>
            </div>
            <h3
              className="text-xl font-semibold mb-3 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
            >
              Fokus pada Pelanggan
            </h3>
            <p className="text-secondary-600">
              Kepuasan pelanggan adalah prioritas utama kami. Kami terus
              berinovasi dan meningkatkan layanan kami berdasarkan umpan balik
              pelanggan.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Team Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Tim Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Bertemu dengan Para Profesional
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Tim berdedikasi kami bekerja keras untuk memastikan pengalaman
            laundry terbaik bagi Anda.
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
          <!-- Team Member 1 -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="relative overflow-hidden h-64">
              <img
                src="https://gapura.uisi.ac.id/assets/upload/user/300x300/4d37b8189613a907d7090f8f79b51657.JPG"
                alt="Faiz Nurullah"
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              />
              <div
                className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div
                className="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"
              >
                <div className="flex space-x-3 justify-center">
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fab fa-linkedin-in"></i>
                  </a>
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fab fa-twitter"></i>
                  </a>
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fas fa-envelope"></i>
                  </a>
                </div>
              </div>
            </div>
            <div className="p-6 text-center">
              <h3
                className="text-xl font-semibold mb-1 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
              >
                Faiz Nurullah
              </h3>
              <p className="text-primary-600 font-medium">Founder & CEO</p>
            </div>
          </div>

          <!-- Team Member 2 -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="relative overflow-hidden h-64">
              <img
                src="https://gapura.uisi.ac.id/assets/upload/user/300x300/29410f7921cf04cbb2525fd3e048b2ee.JPG"
                alt="Ari Setia Hinanda"
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              />
              <div
                className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div
                className="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"
              >
                <div className="flex space-x-3 justify-center">
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fab fa-linkedin-in"></i>
                  </a>
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fab fa-twitter"></i>
                  </a>
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fas fa-envelope"></i>
                  </a>
                </div>
              </div>
            </div>
            <div className="p-6 text-center">
              <h3
                className="text-xl font-semibold mb-1 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
              >
                Ari Setia Hinanda
              </h3>
                
              <p className="text-primary-600 font-medium">Operations Manager</p>
            </div>
          </div>

          <!-- Team Member 3 -->
          <div
            className="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group reveal"
          >
            <div className="relative overflow-hidden h-64">
              <img
                src="https://gapura.uisi.ac.id/assets/upload/user/300x300/3d2825956bd72cdbd02668d0028665ee.JPG"
                alt="Muhammad Muqoffin Nuha"
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                loading="lazy"
              />
              <div
                className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
              <div
                className="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"
              >
                <div className="flex space-x-3 justify-center">
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fab fa-linkedin-in"></i>
                  </a>
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fab fa-twitter"></i>
                  </a>
                  <a
                    href="#"
                    className="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-primary-600 transition-all duration-300"
                  >
                    <i className="fas fa-envelope"></i>
                  </a>
                </div>
              </div>
            </div>
            <div className="p-6 text-center">
              <h3
                className="text-xl font-semibold mb-1 text-secondary-900 group-hover:text-primary-600 transition-colors duration-300"
              >
                Muhammad Muqoffin Nuha
              </h3>
              <p className="text-primary-600 font-medium">Technology Director</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Achievements Section -->
    <section className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Pencapaian Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Perjalanan Menuju Kesuksesan
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Beberapa pencapaian kami selama bertahun-tahun yang menunjukkan
            komitmen kami terhadap kualitas dan inovasi.
          </p>
        </div>

        <div
          className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 reveal"
        >
          <!-- Achievement 1 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 text-center"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mx-auto mb-6"
            >
              <i className="fas fa-users text-2xl"></i>
            </div>
            <h3 className="text-4xl font-bold text-primary-600 mb-2">50,000+</h3>
            <p className="text-secondary-600 font-medium">Pelanggan Puas</p>
          </div>

          <!-- Achievement 2 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 text-center"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mx-auto mb-6"
            >
              <i className="fas fa-tshirt text-2xl"></i>
            </div>
            <h3 className="text-4xl font-bold text-primary-600 mb-2">2 Juta+</h3>
            <p className="text-secondary-600 font-medium">Pakaian Dicuci</p>
          </div>

          <!-- Achievement 3 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 text-center"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mx-auto mb-6"
            >
              <i className="fas fa-city text-2xl"></i>
            </div>
            <h3 className="text-4xl font-bold text-primary-600 mb-2">15+</h3>
            <p className="text-secondary-600 font-medium">Kota Terlayani</p>
          </div>

          <!-- Achievement 4 -->
          <div
            className="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 text-center"
          >
            <div
              className="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mx-auto mb-6"
            >
              <i className="fas fa-award text-2xl"></i>
            </div>
            <h3 className="text-4xl font-bold text-primary-600 mb-2">12+</h3>
            <p className="text-secondary-600 font-medium">Penghargaan Industri</p>
          </div>
        </div>

        <div className="mt-16 text-center reveal">
          <a
            href="/services"
            className="inline-flex items-center bg-primary-600 text-white px-8 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
          >
            <span>Jelajahi Layanan Kami</span>
            <i className="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>
    </section>
    
    <Footer />
  </div>
</template>

<script setup>
import Footer from '../components/Footer.vue'; 
</script>