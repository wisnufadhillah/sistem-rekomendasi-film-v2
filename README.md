# 🎬 K-REC V2 | Sistem Rekomendasi Drama Korea (Collaborative Filtering)

K-REC V2 adalah pembaruan dari aplikasi sistem rekomendasi K-Drama sebelumnya. Pada versi ini, sistem tidak lagi merekomendasikan drama berdasarkan kemiripan teks/sinopsis, melainkan menggunakan pendekatan **Item-Based Collaborative Filtering** berdasarkan riwayat **rating** dari seluruh pengguna.

## 🧠 Algoritma & Cara Kerja
Aplikasi ini memprediksi seberapa besar seorang pengguna akan menyukai suatu drama yang belum ditontonnya, dengan mengukur tingkat kemiripan antar drama berdasarkan *rating* yang diberikan oleh banyak pengguna.

Tahapan perhitungannya:
1. **Pemetaan Data Rating:** Mengambil seluruh data *rating* dari *database* (tabel `nilai`) yang melibatkan interaksi antara *User* dan *Item* (Drama).
2. **Pemisahan Data:** Memisahkan mana drama yang sudah ditonton (rating > 0) dan belum ditonton (rating = 0) oleh pengguna yang sedang *login*.
3. **Item-Based Cosine Similarity:** Menghitung nilai *similarity* (kemiripan) antara satu drama dengan drama lainnya menggunakan rumus *Cosine Similarity*. Kemiripan ini diukur dari pola *rating* yang diberikan oleh *user-user* lain yang menonton kedua drama tersebut.
4. **Prediksi Rating:** Untuk setiap drama yang *belum* ditonton, sistem memprediksi skor ratingnya dengan menghitung rata-rata tertimbang (*weighted average*). Perhitungan ini melibatkan *rating* asli pengguna pada drama yang sudah ditonton, dikalikan dengan bobot *similarity* antar drama tersebut.
5. **Top-N Recommendation:** Mengurutkan hasil prediksi dari skor tertinggi ke terendah, lalu menampilkannya sebagai rekomendasi utama di *dashboard*.

## 🚀 Fitur Utama
* **Sistem Autentikasi (Session):** Menggunakan *session login* untuk mengenali pengguna dan mempersonalisasi rekomendasi.
* **Dashboard Rekomendasi (Predicted Ratings):** Menampilkan daftar drama yang disarankan lengkap dengan lencana estimasi/prediksi *rating*-nya.
* **Riwayat Tontonan (Actual Ratings):** Menampilkan daftar drama yang sudah dinilai/ditonton oleh pengguna beserta *rating* aslinya.
* **Responsive UI:** Antarmuka modern dan rapi yang dibangun menggunakan *Tailwind CSS*.

## 🛠️ Teknologi yang Digunakan
* **Backend:** PHP Native (Session-based)
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, Tailwind CSS

## ⚙️ Cara Instalasi & Menjalankan di Server Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/wisnufadhillah/sistem-rekomendasi-film-v2.git
