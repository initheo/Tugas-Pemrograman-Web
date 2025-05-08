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
            Hubungi Kami
          </h1>
          <p className="text-lg md:text-xl mb-8 text-primary-100 max-w-2xl mx-auto">
            Punya pertanyaan atau butuh bantuan? Tim layanan pelanggan kami siap
            membantu Anda.
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

    <!-- Contact Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- Contact Form -->
          <div className="reveal">
            <h2 className="text-2xl md:text-3xl font-bold text-secondary-900 mb-6">
              Kirim Pesan kepada Kami
            </h2>
            <p className="text-secondary-600 mb-8">
              Isi formulir di bawah ini dan tim kami akan menghubungi Anda
              sesegera mungkin. Kami menghargai umpan balik dan pertanyaan Anda.
            </p>
            <form className="space-y-6">
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label
                    for="first-name"
                    className="block text-sm font-medium text-secondary-700 mb-1"
                  >
                    Nama Depan
                  </label>
                  <input
                    type="text"
                    id="first-name"
                    className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                    placeholder="Nama depan Anda"
                  />
                </div>
                <div>
                  <label
                    for="last-name"
                    className="block text-sm font-medium text-secondary-700 mb-1"
                  >
                    Nama Belakang
                  </label>
                  <input
                    type="text"
                    id="last-name"
                    className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                    placeholder="Nama belakang Anda"
                  />
                </div>
              </div>
              <div>
                <label
                  for="email"
                  className="block text-sm font-medium text-secondary-700 mb-1"
                >
                  Alamat Email
                </label>
                <input
                  type="email"
                  id="email"
                  className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="email@contoh.com"
                />
              </div>
              <div>
                <label
                  for="phone"
                  className="block text-sm font-medium text-secondary-700 mb-1"
                >
                  Nomor Telepon
                </label>
                <input
                  type="tel"
                  id="phone"
                  className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="08xxxxxxxxxx"
                />
              </div>
              <div>
                <label
                  for="subject"
                  className="block text-sm font-medium text-secondary-700 mb-1"
                >
                  Subjek
                </label>
                <select
                  id="subject"
                  className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                >
                  <option value="" disabled selected>Pilih subjek</option>
                  <option value="general">Pertanyaan Umum</option>
                  <option value="service">Pertanyaan Layanan</option>
                  <option value="billing">Penagihan & Pembayaran</option>
                  <option value="complaint">Keluhan</option>
                  <option value="feedback">Umpan Balik</option>
                  <option value="other">Lainnya</option>
                </select>
              </div>
              <div>
                <label
                  for="message"
                  className="block text-sm font-medium text-secondary-700 mb-1"
                >
                  Pesan
                </label>
                <textarea
                  id="message"
                  rows="5"
                  className="w-full px-4 py-3 rounded-md border border-secondary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="Tulis pesan Anda di sini..."
                ></textarea>
              </div>
              <div className="flex items-start">
                <div className="flex items-center h-5">
                  <input
                    id="privacy"
                    type="checkbox"
                    className="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded transition-all duration-300"
                  />
                </div>
                <div className="ml-3 text-sm">
                  <label for="privacy" className="text-secondary-600">
                    Saya menyetujui
                    <a href="#" className="text-primary-600 hover:text-primary-700"
                      >Kebijakan Privasi</a
                    >
                    dan memberikan izin untuk dihubungi.
                  </label>
                </div>
              </div>
              <button
                type="submit"
                className="w-full bg-primary-600 text-white px-6 py-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
              >
                Kirim Pesan
              </button>
            </form>
          </div>

          <!-- Contact Information -->
          <div className="lg:pl-8 reveal">
            <h2 className="text-2xl md:text-3xl font-bold text-secondary-900 mb-6">
              Informasi Kontak
            </h2>
            <p className="text-secondary-600 mb-8">
              Anda juga dapat menghubungi kami langsung melalui informasi di
              bawah ini. Tim layanan pelanggan kami tersedia 7 hari seminggu.
            </p>

            <div className="space-y-6 mb-12">
              <div className="flex items-start">
                <div
                  className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                >
                  <i className="fas fa-map-marker-alt text-lg"></i>
                </div>
                <div>
                  <h4 className="font-semibold text-secondary-900 mb-1">
                    Alamat Kantor Pusat
                  </h4>
                  <p className="text-secondary-600">
                    Jl. Laundry Raya No. 123<br />
                    Jakarta Selatan, 12345<br />
                    Indonesia
                  </p>
                </div>
              </div>

              <div className="flex items-start">
                <div
                  className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                >
                  <i className="fas fa-phone text-lg"></i>
                </div>
                <div>
                  <h4 className="font-semibold text-secondary-900 mb-1">Telepon</h4>
                  <p className="text-secondary-600">
                    Layanan Pelanggan: (021) 123-4567<br />
                    Kantor: (021) 765-4321
                  </p>
                </div>
              </div>

              <div className="flex items-start">
                <div
                  className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                >
                  <i className="fas fa-envelope text-lg"></i>
                </div>
                <div>
                  <h4 className="font-semibold text-secondary-900 mb-1">Email</h4>
                  <p className="text-secondary-600">
                    Layanan Pelanggan: customer@laundrease.com<br />
                    Info Umum: info@laundrease.com<br />
                    Karir: careers@laundrease.com
                  </p>
                </div>
              </div>

              <div className="flex items-start">
                <div
                  className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-4 mt-1"
                >
                  <i className="fas fa-clock text-lg"></i>
                </div>
                <div>
                  <h4 className="font-semibold text-secondary-900 mb-1">
                    Jam Operasional
                  </h4>
                  <p className="text-secondary-600">
                    Senin - Jumat: 08.00 - 20.00<br />
                    Sabtu - Minggu: 09.00 - 18.00
                  </p>
                </div>
              </div>
            </div>

            <!-- Social Media -->
            <div>
              <h4 className="font-semibold text-secondary-900 mb-4">Ikuti Kami</h4>
              <div className="flex space-x-4">
                <a
                  href="#"
                  className="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-primary-600 hover:text-white transition-all duration-300"
                  aria-label="Facebook"
                >
                  <i className="fab fa-facebook-f text-lg"></i>
                </a>
                <a
                  href="#"
                  className="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-primary-600 hover:text-white transition-all duration-300"
                  aria-label="Twitter"
                >
                  <i className="fab fa-twitter text-lg"></i>
                </a>
                <a
                  href="#"
                  className="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-primary-600 hover:text-white transition-all duration-300"
                  aria-label="Instagram"
                >
                  <i className="fab fa-instagram text-lg"></i>
                </a>
                <a
                  href="#"
                  className="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 hover:bg-primary-600 hover:text-white transition-all duration-300"
                  aria-label="LinkedIn"
                >
                  <i className="fab fa-linkedin-in text-lg"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Map Section -->
    <section className="py-12 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12 reveal">
          <h2 className="text-2xl md:text-3xl font-bold text-secondary-900 mb-4">
            Temukan Kami
          </h2>
          <p className="text-secondary-600 max-w-2xl mx-auto">
            Kunjungi kantor pusat kami atau salah satu lokasi drop-off kami di
            seluruh kota.
          </p>
        </div>
        <div className="rounded-xl overflow-hidden shadow-lg reveal">
          <!-- Placeholder for Google Maps -->
          <div
            className="w-full h-96 bg-secondary-200 flex items-center justify-center"
          >
            <div className="text-center">
              <i
                className="fas fa-map-marked-alt text-5xl text-secondary-400 mb-4"
              ></i>
              <p className="text-secondary-600">
                Peta Google akan ditampilkan di sini
              </p>
              <p className="text-sm text-secondary-500 mt-2">
                Untuk implementasi nyata, tambahkan API Google Maps
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Locations Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Lokasi Kami</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Lokasi Drop-Off
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Selain layanan penjemputan, Anda juga dapat mengunjungi salah satu
            lokasi drop-off kami.
          </p>
        </div>

        <div
          className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 reveal"
        >
          <!-- Location 1 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              LaundrEase Jakarta Selatan
            </h3>
            <p className="text-secondary-600 mb-4">
              Jl. Laundry Raya No. 123<br />
              Jakarta Selatan, 12345
            </p>
            <div className="flex items-center text-secondary-500 mb-1">
              <i className="fas fa-clock w-5 text-primary-500"></i>
              <span className="ml-2">Senin - Minggu: 08.00 - 20.00</span>
            </div>
            <div className="flex items-center text-secondary-500 mb-4">
              <i className="fas fa-phone w-5 text-primary-500"></i>
              <span className="ml-2">(021) 123-4567</span>
            </div>
            <a
              href="#"
              className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
            >
              <span>Lihat di peta</span>
              <i className="fas fa-arrow-right ml-2"></i>
            </a>
          </div>

          <!-- Location 2 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              LaundrEase Jakarta Barat
            </h3>
            <p className="text-secondary-600 mb-4">
              Jl. Cucian Bersih No. 45<br />
              Jakarta Barat, 11560
            </p>
            <div className="flex items-center text-secondary-500 mb-1">
              <i className="fas fa-clock w-5 text-primary-500"></i>
              <span className="ml-2">Senin - Minggu: 08.00 - 20.00</span>
            </div>
            <div className="flex items-center text-secondary-500 mb-4">
              <i className="fas fa-phone w-5 text-primary-500"></i>
              <span className="ml-2">(021) 987-6543</span>
            </div>
            <a
              href="#"
              className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
            >
              <span>Lihat di peta</span>
              <i className="fas fa-arrow-right ml-2"></i>
            </a>
          </div>

          <!-- Location 3 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              LaundrEase Jakarta Timur
            </h3>
            <p className="text-secondary-600 mb-4">
              Jl. Setrika Rapi No. 78<br />
              Jakarta Timur, 13210
            </p>
            <div className="flex items-center text-secondary-500 mb-1">
              <i className="fas fa-clock w-5 text-primary-500"></i>
              <span className="ml-2">Senin - Minggu: 08.00 - 20.00</span>
            </div>
            <div className="flex items-center text-secondary-500 mb-4">
              <i className="fas fa-phone w-5 text-primary-500"></i>
              <span className="ml-2">(021) 456-7890</span>
            </div>
            <a
              href="#"
              className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
            >
              <span>Lihat di peta</span>
              <i className="fas fa-arrow-right ml-2"></i>
            </a>
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
              href="register.html"
              className="bg-transparent border-2 border-white text-white px-8 py-4 rounded-md font-medium hover:bg-white/10 transition-all duration-300 text-center"
            >
              Daftar Sekarang
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
