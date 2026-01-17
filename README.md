# 📓 My Daily Journal - AI Powered & Smart Image Processing

**My Daily Journal** adalah aplikasi web manajemen artikel (CMS) yang mengintegrasikan teknologi **Generative AI** untuk membantu proses penulisan dan library pemrosesan gambar interaktif untuk manajemen aset visual yang presisi.

## 🌟 Fitur Unggulan (Spotlight)

### 1. 🤖 Integrasi AI (Gemini Flash 2.5)
Fitur ini dirancang untuk mengatasi *writer's block* dan mempercepat produktivitas admin dalam mengelola konten.

* **Generate Ide & Isi Otomatis**:
    Admin cukup memasukkan topik (keyword), dan AI akan menghasilkan **5 opsi judul menarik** beserta **isi artikel** yang terstruktur, lengkap dengan gaya penulisan web. User tinggal memilih salah satu opsi, dan form akan terisi otomatis.
    
* **Smart Summarization (Ringkasan)**:
    Fitur ini menganalisis isi artikel yang panjang dan secara otomatis membuatkan **ringkasan singkat (2-3 kalimat)** yang ideal untuk deskripsi thumbnail atau meta description, sehingga admin tidak perlu menulis rangkuman secara manual.

### 2. ✂️ Manual Image Cropping (User Input)
Berbeda dengan upload biasa yang memotong gambar secara otomatis (tengah-tengah), fitur ini memberikan kontrol penuh kepada pengguna melalui antarmuka visual.

* **Interactive Cropping Tool**:
    Saat gambar dipilih dari komputer, modal interaktif akan muncul menggunakan library **CropperJS**.
* **User Control**:
    Pengguna dapat melakukan **Zoom In/Out**, menggeser area fokus, dan menyesuaikan komposisi gambar secara manual sebelum diunggah.
* **Fixed Aspect Ratio**:
    Sistem mengunci rasio pemotongan (354x236) untuk menjamin estetika dan konsistensi tampilan *grid* artikel di halaman depan (frontend).

## 🛠️ Teknologi

* **Backend**: PHP 8 (Native)
* **Database**: MySQL / MariaDB
* **Frontend**: Bootstrap 5.3, jQuery
* **Image Processing**: CropperJS (Client-side), PHP GD Library (Server-side)
* **AI Service**: Google Gemini API (`gemini-2.5-flash`)

## 📂 Struktur File Penting

* `admin.php`: Halaman dashboard utama admin.
* `article.php`: Halaman manajemen artikel (CRUD) tempat fitur AI dan Cropper berada.
* `generate_article.php`: API Wrapper internal yang menghubungkan aplikasi dengan Google Gemini API.
* `upload_foto.php`: Handler backend untuk menerima hasil crop dan menyimpan gambar.
* `config.local.php`: File konfigurasi (harus dibuat manual) untuk menyimpan API Key.

## 🚀 Cara Instalasi

1.  **Clone / Download** repositori ini ke folder server lokal (`htdocs`).
2.  **Import Database**:
    * Buat database baru bernama `webdailyjournal`.
    * Import file SQL yang tersedia (pastikan tabel `article` ada).
3.  **Setup API Key**:
    * Buat file baru bernama `config.local.php` di root folder.
    * Isi dengan kode berikut:
        ```php
        <?php
        return [
            'GEMINI_API_KEY' => 'MASUKKAN_KEY_GEMINI_ANDA_DISINI'
        ];
        ```
4.  **Jalankan**: Buka `http://localhost/folder-proyek/login.php`.

## 👤 Author - Kelompok 1 (Pemrograman Berbasis Web)
* **Nama**: Farros Rifantiarno Ramadhani | **NIM**: A11.2024.15694
* **Nama**: Angela Echa Naresti | **NIM**: A11.2024.15971
* **Nama**: Puguh Wibowo | **NIM**: A11.2024.15942
* **Nama**: Adam Haritsa Thahara | **NIM**: A11.2024.15556
