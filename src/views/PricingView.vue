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

    

    <!-- Pricing Plans Section -->
       <!-- Pricing Section -->
    <section id="pricing" className="py-20 bg-secondary-50">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16 reveal">
           
          <h2 className="text-3xl md:text-4xl font-bold text-secondary-900 mb-4">
            Harga yang Sederhana dan Transparan
          </h2>
          <p className="text-lg text-secondary-600 max-w-2xl mx-auto">
            Pilih layanan yang sesuai dengan kebutuhan laundry Anda.
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
                Cuci dan Lipat
              </h3>
              <p className="text-secondary-600">Cocok untuk individu</p>
              <div className="mt-6 flex items-end">
                <span className="text-5xl font-bold text-primary-600">25k</span>
                <span className="text-secondary-600 ml-2">/kg</span>
              </div>
              
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
                Cuci Kering
              </h3>
              <p className="text-secondary-600">Ideal untuk pasangan & keluarga</p>
              <div className="mt-6 flex items-end">
                <span className="text-5xl font-bold text-primary-600">30k</span>
                <span className="text-secondary-600 ml-2">/kg</span>
              </div>
               
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
                 Setrika & Pres
              </h3>
              <p className="text-secondary-600">Untuk keluarga besar</p>
              <div className="mt-6 flex items-end">
                <span className="text-5xl font-bold text-primary-600">30k</span>
                <span className="text-secondary-600 ml-2">/kg</span>
              </div>
               
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

        <div class="max-w-3xl mx-auto reveal">
    <div class="space-y-6">
      <!-- Dynamic FAQ Items -->
      <div 
        v-for="(item, index) in faqItems" 
        :key="index"
        class="bg-white rounded-xl shadow-md overflow-hidden"
        :id="`faq-item-${index}`"
      >
        <button
          class="faq-toggle w-full flex justify-between items-center p-6 focus:outline-none"
          @click="toggleFaq(index)"
        >
          <h3 class="text-lg font-semibold text-secondary-900 text-left">
            {{ item.question }}
          </h3>
          <i
            :class="[
              'fas fa-chevron-down text-primary-600 transition-transform duration-300',
              { 'transform rotate-180': openIndex === index }
            ]"
          ></i>
        </button>
        <div
          class="px-6 pb-6 transition-all duration-300"
          :class="{ 'hidden': openIndex !== index }"
        >
          <p class="text-secondary-600">{{ item.answer }}</p>
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
              href="/contact"
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

<script>
export default {
  name: 'DynamicFaqAccordion',
  props: {
    // You can pass FAQ items from parent component
    items: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      openIndex: null,
      // Default FAQ items if none are provided via props
      defaultFaqItems: [
        {
          question: "Bagaimana cara berlangganan paket?",
          answer: "Untuk berlangganan paket, Anda dapat mendaftar melalui website kami atau menghubungi layanan pelanggan kami. Setelah mendaftar, Anda akan diminta untuk mengisi informasi kontak dan jadwal pengambilan yang diinginkan. Pembayaran dapat dilakukan melalui transfer bank, kartu kredit, atau e-wallet."
        },
        {
          question: "Apakah saya bisa mengubah paket saya?",
          answer: "Ya, Anda dapat mengubah paket Anda kapan saja. Perubahan akan berlaku pada periode penagihan berikutnya. Untuk mengubah paket, silakan masuk ke akun Anda atau hubungi layanan pelanggan kami."
        },
        {
          question: "Bagaimana jika saya melebihi batas berat paket saya?",
          answer: "Jika Anda melebihi batas berat paket, kami akan mengenakan biaya tambahan per kilogram. Biaya tambahan ini akan ditambahkan ke tagihan bulanan Anda atau dapat dibayarkan langsung saat pengantaran."
        },
        {
          question: "Apakah ada kontrak jangka panjang?",
          answer: "Tidak, kami tidak mengharuskan kontrak jangka panjang. Anda dapat berlangganan bulanan atau tahunan dan dapat membatalkan kapan saja. Untuk langganan tahunan, kami menawarkan diskon 20% dari harga bulanan."
        },
        {
          question: "Bagaimana cara membatalkan langganan?",
          answer: "Untuk membatalkan langganan, Anda dapat masuk ke akun Anda dan memilih opsi \"Batalkan Langganan\" atau menghubungi layanan pelanggan kami. Pembatalan akan berlaku pada akhir periode penagihan saat ini."
        },
        {
          question: "Apakah ada biaya pengiriman tambahan?",
          answer: "Tidak, biaya pengambilan dan pengantaran sudah termasuk dalam harga paket untuk area layanan kami. Namun, untuk lokasi di luar area layanan kami, mungkin ada biaya tambahan yang akan kami informasikan sebelumnya."
        }
      ]
    }
  },
  computed: {
    // Use provided items or fall back to default items
    faqItems() {
      return this.items.length > 0 ? this.items : this.defaultFaqItems;
    }
  },
  methods: {
    toggleFaq(index) {
      if (this.openIndex === index) {
        // If clicking the same item, close it
        this.openIndex = null;
      } else {
        // Otherwise, open the clicked item
        this.openIndex = index;
      }
    }
  },
  mounted() {
    // Check for hash in URL to open specific FAQ
    if (this.$route.hash) {
      const id = this.$route.hash.substring(1); // Remove the # character
      const match = id.match(/faq-item-(\d+)/);
      
      if (match && match[1]) {
        const index = parseInt(match[1]);
        if (!isNaN(index) && index >= 0 && index < this.faqItems.length) {
          this.openIndex = index;
          
          // Scroll to the element
          setTimeout(() => {
            const element = document.querySelector(this.$route.hash);
            if (element) {
              element.scrollIntoView({ behavior: 'smooth' });
            }
          }, 300);
        }
      }
    }
  }
}
</script>