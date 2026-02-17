# Changelog - Manajemen User

Berikut adalah ringkasan perubahan yang telah dilakukan pada sistem manajemen user di folder `admin/`.

## 1. Perubahan Struktur Halaman
Sistem manajemen user telah di-refactor dari satu file menjadi beberapa file terpisah untuk modularitas dan kemudahan pengelolaan:

*   **[BARU] `admin/data_user.php`**:
    *   Halaman utama untuk menampilkan daftar user.
    *   Menggantikan peran file lama yang mencampur logika tambah user.
    *   Menyediakan tabel daftar user dengan tombol aksi "Edit" dan "Hapus".
    *   Tombol "Tambah User" mengarahkan ke halaman form terpisah.

*   **[BARU] `admin/tambah_user.php`**:
    *   Halaman khusus berisi formulir untuk menambah user baru.
    *   Memisahkan tampilan form dari logika pemrosesan.

*   **[BARU] `admin/edit_user.php`**:
    *   Halaman khusus berisi formulir untuk mengedit data user yang sudah ada.
    *   Password bersifat opsional (kosongkan jika tidak ingin mengubah).
    *   Data user yang akan diedit otomatis terisi berdasarkan ID yang dipilih.

*   **[HAPUS]** Fitur Modal (Pop-up):
    *   Implementasi awal menggunakan modal (pop-up) telah dihapus dan dikembalikan ke halaman terpisah (`tambah_user.php` dan `edit_user.php`) untuk stabilitas dan menghindari konflik JavaScript/HTML yang sempat terjadi.

## 2. Peningkatan Logika Pemrosesan (Backend)
File pemrosesan data telah diperbarui dengan validasi tambahan:

*   **`admin/proses_tambah_user.php`**:
    *   **Validasi Username Duplikat**: Sistem kini mengecek apakah username yang dimasukkan sudah ada di database sebelum menyimpan.
    *   Jika duplikat, pengguna diredirect kembali ke halaman `tambah_user.php` dengan pesan error, bukan ke halaman list.

*   **`admin/proses_edit_user.php`**:
    *   **Validasi Username Duplikat**: Sistem mengecek apakah username baru sudah digunakan oleh user *lain* (mengecualikan user yang sedang diedit).
    *   Jika duplikat, pengguna diredirect kembali ke halaman `edit_user.php` dengan pesan error.

## 3. Navigasi
*   **`admin/index.php`**: Link menu "Data User" telah disesuaikan agar mengarah ke `admin/data_user.php`.
*   Tombol "Kembali" pada halaman tambah dan edit user mengarah ke `admin/data_user.php`.

---
*Perubahan terakhir: 17 Februari 2026*
