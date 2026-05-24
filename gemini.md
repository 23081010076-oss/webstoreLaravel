# PROMPT: Implementasi Fitur Lanjutan E-Commerce (Sistem Kupon, Akun, Multi-Variant, & Review)

Bertindaklah sebagai Senior Full-Stack Software Engineer dan Software Architect. Saya ingin mengimplementasikan 4 fitur lanjutan pada sistem e-commerce yang sedang dibangun.

## 🛠️ Stack Teknologi & Arsitektur
- **Backend:** Node.js, Express.js
- **ORM:** Prisma ORM (PostgreSQL/MySQL)
- **Mobile Client:** React Native
- **Pendekatan Kode:** Clean Architecture (Separation of Concerns: Entities/Models, Repositories, Use Cases/Services, Controllers/Handlers, Routes).

---

## 📋 Spesifikasi Fitur Lanjutan

### 1. Sistem Kupon & Diskon (Promo Codes)
* **Kondisi Sekarang:** Belum ada input potongan harga di halaman keranjang atau checkout.
* **Fitur Lanjutan:**
  * Buat skema tabel database `coupons` (id, code, type [percentage/fixed], value, min_order_amount, max_discount, start_date, expiry_date, usage_limit, used_count, is_active).
  * Backend API untuk validasi kode promo berdasarkan masa berlaku, minimal pembelian, dan limit penggunaan.
  * Integrasi di Halaman Checkout: Input kode promo, pengurangan harga total secara dinamis, dan kalkulasi total akhir sebelum bayar.

### 2. Akun Customer & Riwayat Pesanan (Customer Dashboard)
* **Kondisi Sekarang:** Pembelian dilakukan secara guest checkout tanpa ada halaman pendaftaran pengguna.
* **Fitur Lanjutan:**
  * Autentikasi Customer: Register, Login (menggunakan JWT), dan Middleware Proteksi Route.
  * Halaman Profil: Mengubah data diri di aplikasi mobile.
  * Riwayat Transaksi: Menampilkan daftar pesanan lengkap beserta detail item, status pembayaran, status pengiriman barang, dan nomor resi kurir.

### 3. Multi-Variant Products (Variasi Produk)
* **Kondisi Sekarang:** Setiap produk hanya memiliki satu harga, satu stok, dan satu SKU tunggal.
* **Fitur Lanjutan:**
  * Skema database relasional: Produk memiliki banyak `ProductVariant` (misal: Ukuran S/M/L, Warna Hitam/Putih). Setiap variasi wajib memiliki `stock`, `price`, `sku`, dan `image_url` tersendiri.
  * Backend: Penyesuaian API Product Detail, API Keranjang (Cart), dan API Checkout agar mencatat `variant_id` bukan hanya `product_id`.
  * Mobile UI: Dropdown atau chip selector untuk memilih variasi di halaman detail produk sebelum dimasukkan ke keranjang.

### 4. Review & Rating Produk
* **Kondisi Sekarang:** Halaman detail produk hanya menampilkan deskripsi dasar.
* **Fitur Lanjutan:**
  * Skema database `reviews` (id, product_id, customer_id, rating [1-5], comment, created_at).
  * Validasi: Kolom review & rating hanya terbuka untuk pembeli yang status pesanannya sudah selesai (`completed`).
  * Mobile UI: Menampilkan daftar review di halaman detail produk dan form input rating setelah pesanan selesai.

---

## 🎯 Output yang Diharapkan

Mohon buatkan panduan implementasi langkah demi langkah (Step-by-Step) yang meliputi:

1. **Prisma Schema Update:** Tambahkan atau perbarui model (`Coupon`, `User/Customer`, `Product`, `ProductVariant`, `Order`, `OrderItem`, `Review`) lengkap dengan relasinya.
2. **Backend Implementation (Clean Architecture):**
   - Berikan contoh potongan kode pada layer *Repository* dan *Use Case* terutama untuk validasi kupon dan kalkulasi harga variasi saat checkout.
3. **Mobile Client (React Native):**
   - Logika state management sederhana saat user memilih variasi produk dan memasukkan kode promo.
4. **API Endpoint List:** Daftar route baru yang perlu dibuat (misal: `POST /api/v1/coupons/validate`, `GET /api/v1/orders/history`, dll).

Tuliskan kode yang bersih, aman dari eksploitasi (seperti SQL Injection atau manipulasi harga di sisi klien), dan siap pakai.