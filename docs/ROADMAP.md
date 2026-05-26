# Malang Mengajar - Peta Jalan Pengembangan (Roadmap)

Dokumen ini mendefinisikan seluruh rencana pengembangan, optimasi, keamanan, dan peningkatan performa untuk platform **Malang Mengajar** setelah fase awal selesai.

## 📊 Matriks Prioritas Pengembangan

| Prioritas | Kategori | Fitur / Langkah Optimasi | Estimasi Effort | Deskripsi & Alasan Utama |
| :--- | :--- | :--- | :--- | :--- |
| **P1 (Tinggi)** | Keamanan | **1. Security Audit (Protection)** | Rendah | Memperketat *route protection* & *controller checks* agar tidak terjadi kebocoran hak akses antar-peran. |
| **P1 (Tinggi)** | Kestabilan | **2. Validasi Batasan Ukuran Upload File** | Rendah | Membatasi ukuran berkas upload KTM dan Laporan Mengajar (`max:2048`) agar tidak memenuhi server. |
| **P1 (Tinggi)** | Keamanan | **3. Fitur Ubah Password Pengguna** | Rendah-Sedang | Menambahkan form ubah password di halaman Profil Volunteer & Admin. |
| **P1 (Tinggi)** | Kinerja | **4. Kompresi Gambar Otomatis (WebP)** | Sedang | Mengompresi & melakukan resize otomatis pada gambar yang diunggah ke format `.webp`. |
| **P1 (Tinggi)** | Fitur | **5. Sistem Pendaftaran Berbasis Batch** | Sedang | Mengontrol pembukaan & penutupan registrasi volunteer per angkatan dari panel admin. |
| **P2 (Sedang)** | Fitur | **6. Integrasi Notifikasi Email (SMTP)** | Sedang | Mengirimkan email saat volunteer disetujui atau ditugaskan jadwal baru. |
| **P2 (Sedang)** | Keamanan | **7. Rate Limiting Form Laporan** | Rendah | Mencegah bot/spam spamming pada form pengiriman laporan. |
| **P2 (Sedang)** | Kestabilan | **8. Database Cascade / Soft Delete Audit** | Sedang | Memastikan relasi database bersih saat user/jadwal dihapus (*clean database state*). |
| **P2 (Sedang)** | Fitur | **9. Presensi Berbasis Geofencing (GPS)** | Sedang | Memvalidasi lokasi presensi relawan sesuai koordinat Rumah Belajar. |
| **P2 (Sedang)** | Fitur | **10. E-Sertifikat Pengabdian Otomatis (PDF)** | Sedang | Menghasilkan sertifikat pengabdian digital berbasis PDF yang bisa diunduh oleh volunteer. |
| **P2 (Sedang)** | Fitur | **11. Kalender Jadwal Interaktif** | Sedang | Visualisasi jadwal bulanan menggunakan antarmuka kalender. |
| **P3 (Rendah)** | UX | **12. Sistem Leaderboard Poin** | Sedang | Sistem poin berbasis kontribusi untuk memotivasi keaktifan relawan. |
| **P3 (Rendah)** | Fitur | **13. Presensi Swafoto (Selfie)** | Sedang | Validasi tambahan berupa unggahan foto diri saat presensi di lokasi. |
| **P3 (Rendah)** | Fitur | **14. Notifikasi WhatsApp Otomatis** | Tinggi | Integrasi WhatsApp gateway berbayar untuk pengingat jadwal mengajar. |

---

## 🛠️ Rincian Implementasi Tugas Terdekat (P1)

### 1. Security Audit (Protection)
- Melakukan pengecekan pada seluruh route dalam `routes/web.php` untuk memastikan middleware `auth`, `role:admin`, dan `role:volunteer` diterapkan secara presisi.
- Mengamankan logika controller agar pengguna tidak dapat memanipulasi data pengguna lain (misalnya volunteer mengubah laporan milik volunteer lain).

### 2. Validasi Batasan Ukuran Upload File
- Mengubah validation rules di `AuthController.php` pada registrasi volunteer: `ktm_photo` ditambahkan rule `max:2048` (maksimal 2MB) dan jenis mime gambar.
- Mengubah validation rules di `VolunteerController.php` pada pengiriman laporan: `photo` ditambahkan rule `max:3072` (maksimal 3MB).

### 3. Fitur Ubah Password Pengguna
- Membuat form ubah password di halaman Profil (`volunteer.profile` & `admin.profile`).
- Implementasi method update password dengan memvalidasi kecocokan `current_password` (password lama) menggunakan `Hash::check()` sebelum menyimpan password baru.

### 4. Kompresi Gambar Otomatis (WebP)
- Memanfaatkan library GD PHP untuk melakukan kompresi otomatis setiap ada file gambar diunggah.
- Mengubah format gambar asli ke `.webp` dengan kualitas 70-80% dan meresize dimensi lebar gambar menjadi maksimal 1200px sebelum disimpan ke storage.
