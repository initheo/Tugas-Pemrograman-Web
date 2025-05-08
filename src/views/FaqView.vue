<template>
  <div>
    <Header />

    <!-- Page Header -->
    <section
      class="bg-gradient-to-r from-primary-700 to-primary-900 text-white py-16 md:py-24 relative overflow-hidden"
    >
      <div
        class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')] opacity-10 bg-cover bg-center mix-blend-overlay"
      ></div>
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-3xl mx-auto text-center reveal">
          <h1
            class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
          >
            Pertanyaan yang Sering Diajukan
          </h1>
          <p class="text-lg md:text-xl mb-8 text-primary-100 max-w-2xl mx-auto">
            Temukan jawaban untuk pertanyaan umum tentang layanan laundry kami.
          </p>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0">
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

    <!-- FAQ Categories Section -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4 mb-12 reveal">
          <a
            v-for="category in faqCategoriesData"
            :key="category.id"
            :href="`#${category.id}`"
            @click.prevent="scrollToCategory(category.id)"
            class="px-6 py-3 bg-primary-50 text-primary-600 rounded-full font-medium hover:bg-primary-100 transition-all duration-300"
          >
            {{ category.title }}
          </a>
        </div>

        <!-- Search Box -->
        <div class="max-w-2xl mx-auto mb-16 reveal">
          <div class="relative">
            <input
              type="text"
              id="faq-search"
              v-model="searchTerm"
              placeholder="Cari pertanyaan..."
              class="w-full px-5 py-4 pr-12 rounded-lg border border-secondary-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
            />
            <div
              class="absolute right-4 top-1/2 transform -translate-y-1/2 text-secondary-400"
            >
              <i class="fas fa-search"></i>
            </div>
          </div>
        </div>

        <!-- Dynamic FAQ Sections -->
        <div v-if="filteredFaqCategories.length > 0">
          <div
            v-for="category in filteredFaqCategories"
            :key="category.id"
            :id="category.id"
            class="max-w-3xl mx-auto mb-16 reveal"
          >
            <h2
              class="text-2xl md:text-3xl font-bold text-secondary-900 mb-8 flex items-center"
            >
              <div
                class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mr-3"
              >
                <i :class="category.icon"></i>
              </div>
              {{ category.title }}
            </h2>

            <!-- Accordion Items for this category -->
            <div class="space-y-4">
              <div
                v-for="(item, itemIndex) in category.items"
                :key="`${category.id}-${itemIndex}`"
                class="faq-item bg-white rounded-xl border border-secondary-200 overflow-hidden"
                :id="`faq-item-${category.id}-${itemIndex}`"
              >
                <button
                  class="faq-question w-full flex justify-between items-center p-6 text-left focus:outline-none"
                  @click="toggleFaq(category.id, itemIndex)"
                  :aria-expanded="openIndexes[category.id] === itemIndex"
                  :aria-controls="`faq-answer-${category.id}-${itemIndex}`"
                >
                  <span class="text-lg font-medium text-secondary-900">
                    {{ item.question }}
                  </span>
                  <div class="ml-4 flex-shrink-0">
                    <i
                      class="fas fa-minus text-primary-600 transition-opacity duration-300"
                      :class="{ 'opacity-100': openIndexes[category.id] === itemIndex, 'opacity-0 absolute': openIndexes[category.id] !== itemIndex }"
                    ></i>
                    <i
                      class="fas fa-plus text-primary-600 transition-opacity duration-300"
                      :class="{ 'opacity-100': openIndexes[category.id] !== itemIndex, 'opacity-0 absolute': openIndexes[category.id] === itemIndex }"
                    ></i>
                  </div>
                </button>
                <div
                  :id="`faq-answer-${category.id}-${itemIndex}`"
                  class="faq-answer transition-all duration-300 ease-in-out overflow-hidden"
                  :style="{ maxHeight: openIndexes[category.id] === itemIndex && answerHeightsByCategory[category.id] ? (answerHeightsByCategory[category.id][itemIndex] || 0) + 'px' : '0px' }"
                  :ref="(el) => setAnswerRef(category.id, itemIndex, el)"
                >
                  <div class="px-6 pb-6">
                    <div class="text-secondary-600" v-if="isHtml(item.answer)" v-html="item.answer"></div>
                    <p class="text-secondary-600" v-else>{{ item.answer }}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Accordion Items -->
          </div>
        </div>
        <div v-else class="text-center text-secondary-600 py-8 reveal">
          <p class="text-xl">Tidak ada pertanyaan yang cocok dengan pencarian Anda.</p>
        </div>
      </div>
    </section>

    <!-- Contact Support Section -->
    <section class="bg-primary-50 py-16 reveal">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
          <h2 class="text-2xl md:text-3xl font-bold text-secondary-900 mb-4">
            Masih Punya Pertanyaan?
          </h2>
          <p class="text-secondary-600 mb-8">
            Tim dukungan pelanggan kami siap membantu Anda 24/7
          </p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <RouterLink
              to="/contact"
              class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-300"
            >
              <i class="fas fa-headset mr-2"></i>
              Hubungi Kami
            </RouterLink>
            <a
              href="https://wa.me/6281234567890"
              target="_blank" rel="noopener noreferrer"
              class="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-600 font-medium rounded-lg border border-primary-600 hover:bg-primary-50 transition-all duration-300"
            >
              <i class="fab fa-whatsapp mr-2"></i>
              Chat WhatsApp
            </a>
          </div>
        </div>
      </div>
    </section>

    <Footer />
  </div>
</template>

<script>
import Header from '../components/Header.vue'; // Sesuaikan path jika perlu
import Footer from '../components/Footer.vue'; // Sesuaikan path jika perlu
// RouterLink sudah diimpor secara global jika menggunakan setup Vue Router yang standar
// import { RouterLink } from 'vue-router'; // Tidak perlu impor manual jika sudah global

export default {
  name: 'FaqPage',
  components: {
    Header,
    Footer,
    // RouterLink // Tidak perlu jika sudah global
  },
  data() {
    const openIndexes = {};
    const answerHeightsByCategory = {};
    const answerElementsRefs = {};

    const faqCategoriesData = [
      {
        id: 'general',
        title: 'Umum',
        icon: 'fas fa-info-circle',
        items: [
          {
            question: "Apa itu LaundrEase?",
            answer: "LaundrEase adalah layanan laundry modern yang menawarkan solusi lengkap untuk kebutuhan laundry Anda. Kami menyediakan layanan penjemputan dan pengantaran, serta berbagai jenis layanan laundry termasuk cuci & lipat, cuci kering, setrika, dan lainnya. Misi kami adalah memberikan kebebasan kepada Anda dari tugas mencuci pakaian sehingga Anda dapat fokus pada hal-hal yang lebih penting dalam hidup."
          },
          {
            question: "Bagaimana cara kerja layanan LaundrEase?",
            answer: "Layanan kami sangat mudah digunakan. Pertama, jadwalkan penjemputan melalui situs web atau aplikasi kami. Kemudian, pengemudi kami akan menjemput cucian Anda pada waktu yang telah ditentukan. Pakaian Anda akan dicuci, dikeringkan, dan/atau disetrika sesuai dengan layanan yang Anda pilih. Terakhir, kami akan mengantarkan pakaian bersih Anda kembali ke alamat Anda pada waktu yang telah dijadwalkan. Anda dapat melacak status cucian Anda secara real-time melalui aplikasi kami."
          },
          {
            question: "Di kota mana saja LaundrEase beroperasi?",
            answer: "Saat ini, LaundrEase beroperasi di 15 kota besar di Indonesia, termasuk Jakarta, Surabaya, Bandung, Medan, Makassar, Semarang, Yogyakarta, Denpasar, Palembang, Balikpapan, Manado, Padang, Malang, Pekanbaru, dan Banjarmasin. Kami terus memperluas layanan kami ke kota-kota lain. Silakan periksa aplikasi atau situs web kami untuk melihat apakah kami melayani area Anda."
          }
        ]
      },
      {
        id: 'services',
        title: 'Layanan',
        icon: 'fas fa-tshirt',
        items: [
          {
            question: "Layanan apa saja yang ditawarkan oleh LaundrEase?",
            answer: `<p class="mb-4">LaundrEase menawarkan berbagai layanan laundry untuk memenuhi semua kebutuhan Anda:</p>
                       <ul class="list-disc pl-5 space-y-2">
                         <li><strong>Cuci & Lipat</strong> - Layanan dasar untuk pakaian sehari-hari</li>
                         <li><strong>Cuci Kering</strong> - Untuk pakaian formal dan kain sensitif</li>
                         <li><strong>Setrika & Pres</strong> - Layanan penyetrikaan profesional</li>
                         <li><strong>Seprai & Linen</strong> - Khusus untuk linen rumah tangga</li>
                         <li><strong>Layanan Ekspres</strong> - Pengerjaan dalam 8 jam</li>
                         <li><strong>Layanan Bisnis</strong> - Solusi untuk hotel, restoran, dan bisnis lainnya</li>
                         <li><strong>Pembersihan Karpet & Gorden</strong> - Untuk tekstil rumah tangga besar</li>
                       </ul>`
          },
          {
            question: "Berapa lama waktu yang dibutuhkan untuk mencuci pakaian saya?",
            answer: "Waktu pengerjaan standar kami adalah 24-48 jam untuk layanan Cuci & Lipat reguler. Untuk layanan Cuci Kering, waktu pengerjaan biasanya 48-72 jam. Jika Anda membutuhkan pakaian Anda lebih cepat, kami juga menawarkan Layanan Ekspres dengan pengerjaan dalam 8 jam dengan biaya tambahan. Waktu pengerjaan dihitung dari saat pakaian Anda tiba di fasilitas kami, bukan dari waktu penjemputan."
          },
          {
            question: "Apakah LaundrEase menggunakan deterjen ramah lingkungan?",
            answer: "Ya, LaundrEase berkomitmen pada praktik ramah lingkungan. Kami menggunakan deterjen biodegradable yang aman untuk lingkungan namun tetap efektif membersihkan pakaian Anda. Mesin kami juga hemat energi dan air. Jika Anda memiliki preferensi deterjen tertentu atau alergi, Anda dapat menginformasikannya kepada kami saat memesan, dan kami akan mengakomodasi kebutuhan Anda jika memungkinkan."
          }
        ]
      },
      {
        id: 'pricing',
        title: 'Harga & Pembayaran',
        icon: 'fas fa-tag',
        items: [
          {
            question: "Berapa biaya layanan LaundrEase?",
            answer: `<p class="mb-4">Harga kami bervariasi tergantung pada layanan yang Anda pilih:</p>
                       <ul class="list-disc pl-5 space-y-2">
                         <li><strong>Cuci & Lipat</strong>: Mulai dari Rp12.000/kg</li>
                         <li><strong>Cuci Kering</strong>: Mulai dari Rp79.000/item</li>
                         <li><strong>Setrika & Pres</strong>: Mulai dari Rp39.000/item</li>
                         <li><strong>Seprai & Linen</strong>: Mulai dari Rp25.000/kg</li>
                         <li><strong>Layanan Ekspres</strong>: +50% dari harga reguler</li>
                       </ul>
                       <p class="mt-4">Kami juga menawarkan paket langganan bulanan yang dapat menghemat biaya hingga 30%. Lihat halaman Harga kami untuk informasi lebih detail.</p>`
          },
          {
            question: "Metode pembayaran apa yang diterima?",
            answer: "LaundrEase menerima berbagai metode pembayaran untuk kenyamanan Anda. Anda dapat membayar melalui kartu kredit/debit, dompet digital (GoPay, OVO, DANA, LinkAja), transfer bank, dan tunai saat pengantaran. Untuk pelanggan berlangganan, kami akan menagih kartu Anda secara otomatis setiap bulan. Semua transaksi online kami diproses melalui gateway pembayaran yang aman."
          },
          {
            question: "Apakah ada biaya tambahan untuk penjemputan dan pengantaran?",
            answer: "Tidak, layanan penjemputan dan pengantaran sudah termasuk dalam harga untuk pesanan dengan nilai minimum Rp100.000. Untuk pesanan di bawah nilai tersebut, akan dikenakan biaya pengiriman sebesar Rp15.000-25.000 tergantung jarak. Pelanggan berlangganan mendapatkan layanan penjemputan dan pengantaran gratis tanpa minimum pembelian."
          }
        ]
      },
      {
        id: 'delivery',
        title: 'Pengantaran',
        icon: 'fas fa-truck',
        items: [
          {
            question: "Kapan saya bisa menjadwalkan penjemputan dan pengantaran?",
            answer: "Kami menawarkan slot penjemputan dan pengantaran dari pukul 08.00 hingga 20.00 setiap hari, termasuk akhir pekan. Anda dapat memilih slot waktu 2 jam yang paling nyaman untuk Anda (misalnya, 10.00-12.00). Untuk hasil terbaik, kami menyarankan Anda menjadwalkan penjemputan setidaknya 24 jam sebelumnya, meskipun kami sering dapat mengakomodasi permintaan pada hari yang sama tergantung ketersediaan."
          },
          {
            question: "Bagaimana jika saya tidak ada di rumah saat penjemputan atau pengantaran?",
            answer: "Jika Anda tidak dapat berada di rumah saat penjemputan atau pengantaran, Anda dapat memberikan instruksi khusus melalui aplikasi kami. Misalnya, Anda dapat meminta kami untuk meninggalkan cucian dengan petugas keamanan atau tetangga. Anda juga dapat menjadwalkan ulang penjemputan atau pengantaran hingga 2 jam sebelum waktu yang dijadwalkan tanpa biaya tambahan. Jika pengemudi kami tiba dan tidak ada yang menerima, kami akan menghubungi Anda dan menunggu hingga 10 menit sebelum meninggalkan lokasi."
          },
          {
            question: "Bagaimana cara melacak status cucian saya?",
            answer: "Anda dapat melacak status cucian Anda secara real-time melalui aplikasi atau situs web kami. Anda akan menerima notifikasi saat cucian Anda dijemput, saat proses pencucian dimulai, saat cucian Anda selesai, dan saat cucian Anda dalam perjalanan untuk diantar. Anda juga dapat melihat estimasi waktu pengantaran dan informasi pengemudi. Jika Anda memiliki pertanyaan tentang status pesanan Anda, Anda dapat menghubungi tim layanan pelanggan kami melalui aplikasi, telepon, atau email."
          }
        ]
      },
      {
        id: 'account',
        title: 'Akun & Aplikasi',
        icon: 'fas fa-user',
        items: [
          {
            question: "Bagaimana cara membuat akun LaundrEase?",
            answer: "Membuat akun LaundrEase sangat mudah. Anda dapat mendaftar melalui situs web atau aplikasi kami. Cukup klik tombol \"Sign Up\", masukkan alamat email Anda, buat kata sandi, dan berikan informasi dasar seperti nama dan nomor telepon. Anda juga dapat mendaftar menggunakan akun Google atau Facebook Anda untuk proses yang lebih cepat. Setelah mendaftar, Anda perlu memverifikasi alamat email Anda dan kemudian Anda siap untuk mulai menggunakan layanan kami."
          },
          {
            question: "Di mana saya bisa mengunduh aplikasi LaundrEase?",
            answer: "Aplikasi LaundrEase tersedia untuk diunduh gratis di App Store (iOS) dan Google Play Store (Android). Cukup cari \"LaundrEase\" di toko aplikasi pilihan Anda dan klik tombol unduh. Aplikasi kami kompatibel dengan iPhone yang menjalankan iOS 12.0 atau lebih baru, dan perangkat Android yang menjalankan Android 6.0 atau lebih baru. Anda juga dapat mengakses semua fitur kami melalui situs web seluler kami jika lebih suka tidak mengunduh aplikasi."
          },
          {
            question: "Bagaimana cara mengubah informasi akun saya?",
            answer: "Untuk mengubah informasi akun Anda, masuk ke aplikasi atau situs web LaundrEase dan kunjungi bagian \"Profil\" atau \"Pengaturan\". Di sana Anda dapat memperbarui informasi pribadi, alamat pengiriman, preferensi notifikasi, dan metode pembayaran. Beberapa perubahan seperti alamat email utama mungkin memerlukan verifikasi tambahan untuk keamanan. Jika Anda memerlukan bantuan, tim dukungan pelanggan kami siap membantu 24/7."
          }
        ]
      }
    ];

    faqCategoriesData.forEach(category => {
      openIndexes[category.id] = null;
      answerHeightsByCategory[category.id] = [];
      answerElementsRefs[category.id] = [];
    });

    return {
      searchTerm: '',
      faqCategoriesData,
      openIndexes,
      answerHeightsByCategory,
      answerElementsRefs,
      observer: null, // Untuk menyimpan instance IntersectionObserver
    };
  },
  computed: {
    filteredFaqCategories() {
      if (!this.searchTerm.trim()) {
        return this.faqCategoriesData;
      }
      const lowerSearchTerm = this.searchTerm.toLowerCase();
      return this.faqCategoriesData
        .map(category => {
          const filteredItems = category.items.filter(
            item =>
              item.question.toLowerCase().includes(lowerSearchTerm) ||
              this.stripHtml(item.answer).toLowerCase().includes(lowerSearchTerm)
          );
          return { ...category, items: filteredItems };
        })
        .filter(category => category.items.length > 0);
    }
  },
  methods: {
    isHtml(str) {
      if (typeof str !== 'string') return false;
      const doc = new DOMParser().parseFromString(str, "text/html");
      return Array.from(doc.body.childNodes).some(node => node.nodeType === 1);
    },
    stripHtml(html) {
      if (typeof html !== 'string') return '';
      let tmp = document.createElement("DIV");
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || "";
    },
    setAnswerRef(categoryId, itemIndex, el) {
      if (!this.answerElementsRefs[categoryId]) {
        this.answerElementsRefs[categoryId] = [];
      }
      // Pastikan array cukup panjang sebelum assignment langsung
      while(this.answerElementsRefs[categoryId].length <= itemIndex) {
        this.answerElementsRefs[categoryId].push(undefined);
      }
      this.answerElementsRefs[categoryId][itemIndex] = el;
    },
    toggleFaq(categoryId, itemIndex) {
      if (this.openIndexes[categoryId] === itemIndex) {
        this.openIndexes[categoryId] = null;
      } else {
        this.openIndexes[categoryId] = itemIndex;
        this.$nextTick(() => {
          this.calculateAllAnswerHeights();
        });
      }
    },
    calculateAllAnswerHeights() {
      this.$nextTick(() => {
        this.filteredFaqCategories.forEach(category => {
          const categoryId = category.id;
          const newHeightsForCategory = [];

          if (this.answerElementsRefs[categoryId] && category.items) {
            category.items.forEach((_, itemIndex) => {
              const el = this.answerElementsRefs[categoryId][itemIndex];
              if (el && el.children[0]) {
                newHeightsForCategory[itemIndex] = el.children[0].scrollHeight;
              } else {
                newHeightsForCategory[itemIndex] = 0;
              }
            });
          }
          // Pastikan answerHeightsByCategory[categoryId] ada sebelum assignment
          if (!this.answerHeightsByCategory[categoryId]) {
              this.answerHeightsByCategory[categoryId] = [];
          }
          // Isi atau update array
          newHeightsForCategory.forEach((height, idx) => {
              this.answerHeightsByCategory[categoryId][idx] = height;
          });
          // Jika newHeightsForCategory lebih pendek, potong array yang ada
          if (this.answerHeightsByCategory[categoryId].length > newHeightsForCategory.length) {
              this.answerHeightsByCategory[categoryId].length = newHeightsForCategory.length;
          }

        });
      });
    },
    scrollToCategory(categoryId) {
      const element = document.getElementById(categoryId);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    },
    setupRevealAnimations() {
      if (!this.$el) return; // Pastikan elemen root komponen sudah ada
      const revealElements = this.$el.querySelectorAll('.reveal');

      if (typeof IntersectionObserver !== 'undefined') {
        if (this.observer) {
          this.observer.disconnect();
        }
        this.observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('revealed');
              // this.observer.unobserve(entry.target); // Opsional
            } else {
              // entry.target.classList.remove('revealed'); // Opsional
            }
          });
        }, { threshold: 0.1 });

        revealElements.forEach(el => {
          if (this.observer && el) {
            this.observer.observe(el);
          }
        });
      } else {
        revealElements.forEach(el => el.classList.add('revealed'));
      }
    }
  },
  watch: {
    filteredFaqCategories: {
      handler(newCategories, oldCategories) {
         // Reset dan re-initialize refs structure if categories change significantly
        if (newCategories.length !== oldCategories.length || JSON.stringify(newCategories.map(c=>c.id)) !== JSON.stringify(oldCategories.map(c=>c.id))) {
            this.answerElementsRefs = {};
            this.faqCategoriesData.forEach(cat => {
                this.answerElementsRefs[cat.id] = [];
                 // Juga pastikan answerHeightsByCategory diinisialisasi dengan benar
                if (!this.answerHeightsByCategory[cat.id]) {
                    this.answerHeightsByCategory[cat.id] = [];
                }
            });
        }

        this.$nextTick(() => {
            this.calculateAllAnswerHeights();
            this.setupRevealAnimations(); // Setup animasi untuk elemen baru/yang berubah
        });
      },
      deep: true,
      // immediate: true // Bisa jadi diperlukan jika ingin langsung dijalankan saat komponen dimuat
    }
  },
  mounted() {
    this.$nextTick(() => { // Pastikan $el ada dan DOM siap
        this.calculateAllAnswerHeights();
        this.setupRevealAnimations();
    });
    window.addEventListener('resize', this.calculateAllAnswerHeights);

    // Deep linking logic
    if (this.$route && this.$route.hash) {
      const hash = this.$route.hash.substring(1);
      const categoryLinkMatch = this.faqCategoriesData.find(cat => cat.id === hash);

      if (categoryLinkMatch) {
        this.$nextTick(() => {
          this.scrollToCategory(hash);
        });
      } else {
        const itemHashPattern = /^faq-item-([a-zA-Z0-9_]+)-(\d+)$/;
        const itemMatch = hash.match(itemHashPattern);

        if (itemMatch && itemMatch[1] && itemMatch[2]) {
          const categoryId = itemMatch[1];
          const itemIndex = parseInt(itemMatch[2]);
          const targetCategory = this.faqCategoriesData.find(cat => cat.id === categoryId);

          if (targetCategory && itemIndex >= 0 && itemIndex < targetCategory.items.length) {
            this.openIndexes[categoryId] = itemIndex;

            this.$nextTick(() => {
              this.calculateAllAnswerHeights();
              setTimeout(() => {
                const element = document.getElementById(hash);
                if (element) {
                  element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
              }, 350);
            });
          }
        }
      }
    }
  },
  updated() {
    // Dipanggil setelah DOM komponen diupdate.
    // Perhitungan tinggi dan setup animasi mungkin perlu dijalankan lagi.
    // Watcher filteredFaqCategories seharusnya sudah menangani ini sebagian besar.
    // this.calculateAllAnswerHeights();
    // this.setupRevealAnimations();
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.calculateAllAnswerHeights);
    if (this.observer) {
      this.observer.disconnect();
      this.observer = null;
    }
  }
};
</script>

<style scoped> /* <<< PENTING: Menambahkan 'scoped' */
/* Contoh animasi untuk class 'reveal' */
.reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}
.reveal.revealed {
  opacity: 1;
  transform: translateY(0);
}

/* Style untuk ikon plus/minus agar tidak melompat saat opacity berubah */
.faq-question .ml-4.flex-shrink-0 {
  position: relative;
  width: 1em;
  height: 1em;
}
.faq-question .ml-4.flex-shrink-0 i {
  position: absolute;
  top: 0;
  left: 0;
  transition-property: opacity;
}
</style>