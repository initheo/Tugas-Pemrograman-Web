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
            Harga Terjangkau untuk Semua Kebutuhan
          </h1>
          <p className="text-lg md:text-xl mb-8 text-primary-100 max-w-2xl mx-auto">
            Pilih paket yang sesuai dengan kebutuhan Anda. Kami menawarkan harga
            yang kompetitif dengan kualitas layanan terbaik.
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

    <!-- Pricing Toggle Section -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-center mb-12 reveal">
          <div class="flex items-center space-x-4">
            <span class="text-lg font-medium" :class="{ 'text-primary-600': !isYearly, 'text-secondary-700': isYearly }">
              Bulanan
            </span>
            <label class="pricing-toggle">
              <input 
                type="checkbox" 
                id="pricing-toggle" 
                v-model="isYearly"
                @change="togglePrice"
              />
              <span class="pricing-slider"></span>
            </label>
            <div class="flex items-center">
              <span class="text-lg font-medium" :class="{ 'text-primary-600': isYearly, 'text-secondary-700': !isYearly }">
                Tahunan
              </span>
              <span class="ml-2 px-2 py-1 bg-primary-100 text-primary-700 text-xs font-medium rounded-full">
                Hemat 20%
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing Plans Section -->
    <section className="py-12 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
          <!-- Basic Plan -->
          <div
            className="bg-white rounded-2xl shadow-lg border border-secondary-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 reveal"
          >
            <div className="p-8 border-b border-secondary-100">
              <h3 className="text-xl font-bold text-secondary-900 mb-2">
                Paket Dasar
              </h3>
              <p className="text-secondary-600 mb-6">
                Ideal untuk individu dengan kebutuhan laundry sederhana
              </p>
              <div className="flex items-baseline">
                <span className="text-4xl font-bold text-primary-600" :class="{ 'hidden': isYearly }">
                  Rp 199.000
                </span>
                <span className="text-4xl font-bold text-primary-600" :class="{ 'hidden': !isYearly }">
                  Rp 1.910.000
                </span>
                <span className="text-secondary-500 ml-2">{{ isYearly ? '/tahun' : '/bulan' }}</span>
              </div>
              <p className="text-sm text-secondary-500 mt-2">
                Atau mulai dari Rp 50.000 per pengambilan
              </p>
            </div>
            <div className="p-8">
              <ul className="space-y-4">
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>5 kg laundry per minggu</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan cuci & lipat standar</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Pengambilan & pengantaran 1x seminggu</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Waktu penyelesaian 48 jam</span>
                </li>
                <li className="flex items-start text-secondary-400">
                  <i className="fas fa-times-circle mt-1 mr-3"></i>
                  <span>Layanan cuci kering premium</span>
                </li>
                <li className="flex items-start text-secondary-400">
                  <i className="fas fa-times-circle mt-1 mr-3"></i>
                  <span>Layanan setrika</span>
                </li>
                <li className="flex items-start text-secondary-400">
                  <i className="fas fa-times-circle mt-1 mr-3"></i>
                  <span>Pengambilan darurat</span>
                </li>
              </ul>
              <a
                href="#"
                className="mt-8 block w-full py-3 px-6 text-center bg-white border-2 border-primary-600 text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-all duration-300"
              >
                Pilih Paket
              </a>
            </div>
          </div>

          <!-- Premium Plan -->
          <div
            className="bg-white rounded-2xl shadow-xl border-2 border-primary-500 overflow-hidden transform scale-105 md:scale-100 md:transform-none lg:scale-105 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 reveal"
          >
            <div
              className="bg-primary-600 text-white text-center py-2 text-sm font-medium"
            >
              PALING POPULER
            </div>
            <div className="p-8 border-b border-secondary-100">
              <h3 className="text-xl font-bold text-secondary-900 mb-2">
                Paket Premium
              </h3>
              <p className="text-secondary-600 mb-6">
                Sempurna untuk keluarga kecil atau pasangan
              </p>
              <div className="flex items-baseline">
                <span className="text-4xl font-bold text-primary-600" :class="{ 'hidden': isYearly }">
                  Rp 349.000
                </span>
                <span className="text-4xl font-bold text-primary-600" :class="{ 'hidden': !isYearly }">
                  Rp 3.350.000
                </span>
                <span className="text-secondary-500 ml-2">{{ isYearly ? '/tahun' : '/bulan' }}</span>
              </div>
              <p className="text-sm text-secondary-500 mt-2">
                Atau mulai dari Rp 80.000 per pengambilan
              </p>
            </div>
            <div className="p-8">
              <ul className="space-y-4">
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>10 kg laundry per minggu</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan cuci & lipat standar</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Pengambilan & pengantaran 2x seminggu</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Waktu penyelesaian 24 jam</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan cuci kering premium</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan setrika</span>
                </li>
                <li className="flex items-start text-secondary-400">
                  <i className="fas fa-times-circle mt-1 mr-3"></i>
                  <span>Pengambilan darurat</span>
                </li>
              </ul>
              <a
                href="#"
                className="mt-8 block w-full py-3 px-6 text-center bg-primary-600 text-white font-medium rounded-md hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300"
              >
                Pilih Paket
              </a>
            </div>
          </div>

          <!-- Ultimate Plan -->
          <div
            className="bg-white rounded-2xl shadow-lg border border-secondary-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 reveal"
          >
            <div className="p-8 border-b border-secondary-100">
              <h3 className="text-xl font-bold text-secondary-900 mb-2">
                Paket Ultimate
              </h3>
              <p className="text-secondary-600 mb-6">
                Solusi lengkap untuk keluarga besar
              </p>
              <div className="flex items-baseline">
                <span className="text-4xl font-bold text-primary-600" :class="{ 'hidden': isYearly }">
                  Rp 599.000
                </span>
                <span className="text-4xl font-bold text-primary-600" :class="{ 'hidden': !isYearly }">
                  Rp 5.750.000
                </span>
                <span className="text-secondary-500 ml-2">{{ isYearly ? '/tahun' : '/bulan' }}</span>
              </div>
              <p className="text-sm text-secondary-500 mt-2">
                Atau mulai dari Rp 120.000 per pengambilan
              </p>
            </div>
            <div className="p-8">
              <ul className="space-y-4">
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>20 kg laundry per minggu</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan cuci & lipat standar</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Pengambilan & pengantaran 3x seminggu</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Waktu penyelesaian 24 jam</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan cuci kering premium</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Layanan setrika</span>
                </li>
                <li className="flex items-start">
                  <i className="fas fa-check-circle text-primary-500 mt-1 mr-3"></i>
                  <span>Pengambilan darurat</span>
                </li>
              </ul>
              <a
                href="#"
                className="mt-8 block w-full py-3 px-6 text-center bg-white border-2 border-primary-600 text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-all duration-300"
              >
                Pilih Paket
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Comparison -->
    <section className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Perbandingan Fitur</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Bandingkan Semua Fitur
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Lihat perbandingan lengkap dari semua paket kami untuk membantu Anda
            memilih yang paling sesuai dengan kebutuhan Anda.
          </p>
        </div>

        <div className="overflow-x-auto reveal">
          <table className="w-full bg-white rounded-xl shadow-lg">
            <thead>
              <tr className="bg-secondary-50 border-b border-secondary-200">
                <th
                  className="py-4 px-6 text-left text-secondary-900 font-semibold"
                >
                  Fitur
                </th>
                <th
                  className="py-4 px-6 text-center text-secondary-900 font-semibold"
                >
                  Paket Dasar
                </th>
                <th
                  className="py-4 px-6 text-center text-primary-600 font-semibold"
                >
                  Paket Premium
                </th>
                <th
                  className="py-4 px-6 text-center text-secondary-900 font-semibold"
                >
                  Paket Ultimate
                </th>
              </tr>
            </thead>
            <tbody>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Kapasitas Mingguan
                </td>
                <td className="py-4 px-6 text-center">5 kg</td>
                <td className="py-4 px-6 text-center bg-primary-50">10 kg</td>
                <td className="py-4 px-6 text-center">20 kg</td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Frekuensi Pengambilan
                </td>
                <td className="py-4 px-6 text-center">1x seminggu</td>
                <td className="py-4 px-6 text-center bg-primary-50">2x seminggu</td>
                <td className="py-4 px-6 text-center">3x seminggu</td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Waktu Penyelesaian
                </td>
                <td className="py-4 px-6 text-center">48 jam</td>
                <td className="py-4 px-6 text-center bg-primary-50">24 jam</td>
                <td className="py-4 px-6 text-center">24 jam</td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Layanan Cuci Kering
                </td>
                <td className="py-4 px-6 text-center">
                  <i className="fas fa-times text-secondary-400"></i>
                </td>
                <td className="py-4 px-6 text-center bg-primary-50">
                  <i className="fas fa-check text-primary-500"></i>
                </td>
                <td className="py-4 px-6 text-center">
                  <i className="fas fa-check text-primary-500"></i>
                </td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Layanan Setrika
                </td>
                <td className="py-4 px-6 text-center">
                  <i className="fas fa-times text-secondary-400"></i>
                </td>
                <td className="py-4 px-6 text-center bg-primary-50">
                  <i className="fas fa-check text-primary-500"></i>
                </td>
                <td className="py-4 px-6 text-center">
                  <i className="fas fa-check text-primary-500"></i>
                </td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Pengambilan Darurat
                </td>
                <td className="py-4 px-6 text-center">
                  <i className="fas fa-times text-secondary-400"></i>
                </td>
                <td className="py-4 px-6 text-center bg-primary-50">
                  <i className="fas fa-times text-secondary-400"></i>
                </td>
                <td className="py-4 px-6 text-center">
                  <i className="fas fa-check text-primary-500"></i>
                </td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Perlakuan Khusus
                </td>
                <td className="py-4 px-6 text-center">Biaya tambahan</td>
                <td className="py-4 px-6 text-center bg-primary-50">Diskon 10%</td>
                <td className="py-4 px-6 text-center">Diskon 20%</td>
              </tr>
              <tr className="border-b border-secondary-100">
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Dukungan Pelanggan
                </td>
                <td className="py-4 px-6 text-center">Jam kerja</td>
                <td className="py-4 px-6 text-center bg-primary-50">
                  Jam kerja diperpanjang
                </td>
                <td className="py-4 px-6 text-center">24/7</td>
              </tr>
              <tr>
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Harga Bulanan
                </td>
                <td className="py-4 px-6 text-center font-semibold">Rp 199.000</td>
                <td className="py-4 px-6 text-center font-semibold bg-primary-50">
                  Rp 349.000
                </td>
                <td className="py-4 px-6 text-center font-semibold">Rp 599.000</td>
              </tr>
              <tr>
                <td className="py-4 px-6 text-secondary-800 font-medium">
                  Harga Tahunan
                </td>
                <td className="py-4 px-6 text-center font-semibold">
                  Rp 1.910.000
                </td>
                <td className="py-4 px-6 text-center font-semibold bg-primary-50">
                  Rp 3.350.000
                </td>
                <td className="py-4 px-6 text-center font-semibold">
                  Rp 5.750.000
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Additional Services Section -->
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >Layanan Tambahan</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Layanan Tambahan Sesuai Kebutuhan
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Kami juga menawarkan layanan tambahan yang dapat Anda pesan sesuai
            kebutuhan.
          </p>
        </div>

        <div
          className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 reveal"
        >
          <!-- Additional Service 1 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <div
              className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6"
            >
              <i className="fas fa-tshirt text-xl"></i>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Cuci Kering Premium
            </h3>
            <p className="text-secondary-600 mb-4">
              Layanan cuci kering untuk pakaian yang membutuhkan perawatan
              khusus seperti jas, gaun, dan pakaian formal lainnya.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-lg font-semibold text-primary-600"
                >Mulai Rp 25.000/item</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
              >
                <span>Detail</span>
                <i className="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Additional Service 2 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <div
              className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6"
            >
              <i className="fas fa-bed text-xl"></i>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Cuci Seprai & Linen
            </h3>
            <p className="text-secondary-600 mb-4">
              Layanan khusus untuk seprai, selimut, sarung bantal, dan linen
              rumah tangga lainnya dengan perawatan ekstra.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-lg font-semibold text-primary-600"
                >Mulai Rp 35.000/kg</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
              >
                <span>Detail</span>
                <i className="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Additional Service 3 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <div
              className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6"
            >
              <i className="fas fa-shoe-prints text-xl"></i>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Cuci Sepatu
            </h3>
            <p className="text-secondary-600 mb-4">
              Layanan pembersihan sepatu profesional untuk berbagai jenis
              sepatu, termasuk sneakers, sepatu kulit, dan sepatu olahraga.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-lg font-semibold text-primary-600"
                >Mulai Rp 50.000/pasang</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
              >
                <span>Detail</span>
                <i className="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Additional Service 4 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <div
              className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6"
            >
              <i className="fas fa-couch text-xl"></i>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Cuci Karpet & Sofa
            </h3>
            <p className="text-secondary-600 mb-4">
              Layanan pembersihan profesional untuk karpet, permadani, dan sofa
              dengan teknologi pembersihan mendalam.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-lg font-semibold text-primary-600"
                >Mulai Rp 100.000/item</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
              >
                <span>Detail</span>
                <i className="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Additional Service 5 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <div
              className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6"
            >
              <i className="fas fa-bolt text-xl"></i>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Layanan Express
            </h3>
            <p className="text-secondary-600 mb-4">
              Layanan cuci kilat dengan waktu penyelesaian dalam 6 jam untuk
              kebutuhan mendesak Anda.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-lg font-semibold text-primary-600"
                >Tambahan Rp 30.000</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
              >
                <span>Detail</span>
                <i className="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Additional Service 6 -->
          <div
            className="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-secondary-100"
          >
            <div
              className="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6"
            >
              <i className="fas fa-building text-xl"></i>
            </div>
            <h3 className="text-xl font-semibold mb-3 text-secondary-900">
              Layanan Bisnis
            </h3>
            <p className="text-secondary-600 mb-4">
              Solusi laundry khusus untuk bisnis seperti hotel, restoran, salon,
              dan spa dengan harga khusus.
            </p>
            <div className="flex justify-between items-center">
              <span className="text-lg font-semibold text-primary-600"
                >Hubungi untuk penawaran</span
              >
              <a
                href="#"
                className="text-primary-600 hover:text-primary-700 font-medium flex items-center"
              >
                <span>Detail</span>
                <i className="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
          <span
            className="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4"
            >FAQ</span
          >
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Pertanyaan yang Sering Diajukan
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Temukan jawaban untuk pertanyaan umum tentang layanan dan harga
            kami.
          </p>
        </div>

        <div className="max-w-3xl mx-auto reveal">
          <div className="space-y-6">
            <!-- FAQ Item 1 -->
            <div className="bg-white rounded-xl shadow-md overflow-hidden">
              <button
                className="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
              >
                <h3 className="text-lg font-semibold text-secondary-900 text-left">
                  Bagaimana cara berlangganan paket?
                </h3>
                <i
                  className="fas fa-chevron-down text-primary-600 transition-transform duration-300"
                ></i>
              </button>
              <div className="faq-content hidden px-6 pb-6">
                <p className="text-secondary-600">
                  Untuk berlangganan paket, Anda dapat mendaftar melalui website
                  kami atau menghubungi layanan pelanggan kami. Setelah
                  mendaftar, Anda akan diminta untuk mengisi informasi kontak
                  dan jadwal pengambilan yang diinginkan. Pembayaran dapat
                  dilakukan melalui transfer bank, kartu kredit, atau e-wallet.
                </p>
              </div>
            </div>

            <!-- FAQ Item 2 -->
            <div className="bg-white rounded-xl shadow-md overflow-hidden">
              <button
                className="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
              >
                <h3 className="text-lg font-semibold text-secondary-900 text-left">
                  Apakah saya bisa mengubah paket saya?
                </h3>
                <i
                  className="fas fa-chevron-down text-primary-600 transition-transform duration-300"
                ></i>
              </button>
              <div className="faq-content hidden px-6 pb-6">
                <p className="text-secondary-600">
                  Ya, Anda dapat mengubah paket Anda kapan saja. Perubahan akan
                  berlaku pada periode penagihan berikutnya. Untuk mengubah
                  paket, silakan masuk ke akun Anda atau hubungi layanan
                  pelanggan kami.
                </p>
              </div>
            </div>

            <!-- FAQ Item 3 -->
            <div className="bg-white rounded-xl shadow-md overflow-hidden">
              <button
                className="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
              >
                <h3 className="text-lg font-semibold text-secondary-900 text-left">
                  Bagaimana jika saya melebihi batas berat paket saya?
                </h3>
                <i
                  className="fas fa-chevron-down text-primary-600 transition-transform duration-300"
                ></i>
              </button>
              <div className="faq-content hidden px-6 pb-6">
                <p className="text-secondary-600">
                  Jika Anda melebihi batas berat paket, kami akan mengenakan
                  biaya tambahan per kilogram. Biaya tambahan ini akan
                  ditambahkan ke tagihan bulanan Anda atau dapat dibayarkan
                  langsung saat pengantaran.
                </p>
              </div>
            </div>

            <!-- FAQ Item 4 -->
            <div className="bg-white rounded-xl shadow-md overflow-hidden">
              <button
                className="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
              >
                <h3 className="text-lg font-semibold text-secondary-900 text-left">
                  Apakah ada kontrak jangka panjang?
                </h3>
                <i
                  className="fas fa-chevron-down text-primary-600 transition-transform duration-300"
                ></i>
              </button>
              <div className="faq-content hidden px-6 pb-6">
                <p className="text-secondary-600">
                  Tidak, kami tidak mengharuskan kontrak jangka panjang. Anda
                  dapat berlangganan bulanan atau tahunan dan dapat membatalkan
                  kapan saja. Untuk langganan tahunan, kami menawarkan diskon
                  20% dari harga bulanan.
                </p>
              </div>
            </div>

            <!-- FAQ Item 5 -->
            <div className="bg-white rounded-xl shadow-md overflow-hidden">
              <button
                className="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
              >
                <h3 className="text-lg font-semibold text-secondary-900 text-left">
                  Bagaimana cara membatalkan langganan?
                </h3>
                <i
                  className="fas fa-chevron-down text-primary-600 transition-transform duration-300"
                ></i>
              </button>
              <div className="faq-content hidden px-6 pb-6">
                <p className="text-secondary-600">
                  Untuk membatalkan langganan, Anda dapat masuk ke akun Anda dan
                  memilih opsi "Batalkan Langganan" atau menghubungi layanan
                  pelanggan kami. Pembatalan akan berlaku pada akhir periode
                  penagihan saat ini.
                </p>
              </div>
            </div>

            <!-- FAQ Item 6 -->
            <div className="bg-white rounded-xl shadow-md overflow-hidden">
              <button
                className="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
              >
                <h3 className="text-lg font-semibold text-secondary-900 text-left">
                  Apakah ada biaya pengiriman tambahan?
                </h3>
                <i
                  className="fas fa-chevron-down text-primary-600 transition-transform duration-300"
                ></i>
              </button>
              <div className="faq-content hidden px-6 pb-6">
                <p className="text-secondary-600">
                  Tidak, biaya pengambilan dan pengantaran sudah termasuk dalam
                  harga paket untuk area layanan kami. Namun, untuk lokasi di
                  luar area layanan kami, mungkin ada biaya tambahan yang akan
                  kami informasikan sebelumnya.
                </p>
              </div>
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
            Siap untuk Memulai?
          </h2>
          <p className="text-lg mb-8 text-primary-100 max-w-2xl mx-auto">
            Pilih paket yang sesuai dengan kebutuhan Anda dan nikmati layanan
            laundry premium LaundrEase.
          </p>
          <div
            className="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4"
          >
            <a
              href="#"
              className="bg-white text-primary-700 px-8 py-4 rounded-md font-medium hover:bg-primary-50 shadow-lg hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1"
            >
              Lihat Semua Paket
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
import { onMounted, ref } from 'vue';
import Footer from '../components/Footer.vue';
import Header from '../components/Header.vue';

// Add reactive reference for toggle state
const isYearly = ref(false);

// Toggle function
const togglePrice = () => {
  isYearly.value = !isYearly.value;
  
  // Get all price elements
  const monthlyPrices = document.querySelectorAll('.monthly-price');
  const yearlyPrices = document.querySelectorAll('.yearly-price');

  // Toggle visibility based on state
  monthlyPrices.forEach(price => {
    price.classList.toggle('hidden', isYearly.value);
  });
  
  yearlyPrices.forEach(price => {
    price.classList.toggle('hidden', !isYearly.value);
  });
};

// Add event listener when component is mounted
onMounted(() => {
  const pricingToggle = document.getElementById('pricing-toggle');
  pricingToggle?.addEventListener('change', togglePrice);
});
</script>

<style scoped>
/* Add toggle switch styles */
.pricing-toggle {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.pricing-toggle input {
  opacity: 0;
  width: 0;
  height: 0;
}

.pricing-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
}

.pricing-slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .pricing-slider {
  background-color: #0284c7;
}

input:checked + .pricing-slider:before {
  transform: translateX(26px);
}
</style>
