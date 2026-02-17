<?php
// ===============================
// 🔹 Mulai pengukuran waktu eksekusi (opsional)
$start_time = microtime(true);

// 🔹 Mulai session
session_start();

// 🔹 Cek apakah user sudah login dan berperan sebagai admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    // Jika bukan admin → tendang ke halaman login
    header("Location: ../auth/login.php");
    exit;
}

// 🔹 Import koneksi database & file inisialisasi
include '../config/db.php';
include '../config/init.php';
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - Aplikasi Listrik</title>
    <!-- 🔹 Gunakan TailwindCSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-100">

<!-- =============================== -->
<!-- 🔹 Navbar -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- 🔸 Kiri: Logo + Judul -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">Listrik Pascabayar</span>
                </div>
            </div>

            <!-- 🔸 Kanan: Info User + Logout -->
            <div class="flex items-center">
                <div class="text-sm text-gray-600">
                    Halo, 
                    <strong class="font-medium text-gray-800"><?= htmlspecialchars($_SESSION['nama']) ?></strong> 
                    (<span class="italic text-gray-500"><?= htmlspecialchars($_SESSION['role']) ?></span>)
                </div>
                <a href="proses_logout.php" class="ml-4 text-sm font-medium text-blue-600 hover:text-blue-500">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- =============================== -->
<!-- 🔹 Konten Utama -->
<div class="py-10">
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Tambah Pelanggan Baru
            </h1>
            <a href="data_pelanggan.php" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                &larr; Kembali ke Data Pelanggan
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900">Formulir Pelanggan</h3>
                <p class="mt-1 text-sm text-gray-500">Isi semua detail yang diperlukan di bawah ini.</p>

                <!-- 🔹 FORM INPUT DATA PELANGGAN -->
                <form action="proses_tambah_pelanggan.php" method="POST" class="mt-6 space-y-6">
                    
                    <!-- No KWH -->
                    <div>
                        <label for="no_kwh" class="block text-sm font-medium text-gray-700">No KWH</label>
                        <input type="text" name="no_kwh" id="no_kwh" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                   focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="cth: 531234567890">
                    </div>

                    <!-- Nama Pelanggan -->
                    <div>
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                   focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Nama lengkap pelanggan">
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                   focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Alamat lengkap"></textarea>
                    </div>

                    <!-- Daya -->
                    <div>
                        <label for="daya_select" class="block text-sm font-medium text-gray-700">Daya (VA)</label>
                        <div class="mt-1 flex space-x-2">
                            <!-- 🔸 Dropdown pilihan daya -->
                            <select id="daya_select" 
                                class="w-1/2 border rounded p-2 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">--Pilih Daya--</option>
                                <option value="450">450 VA</option>
                                <option value="900">900 VA</option>
                                <option value="1200">1200 VA</option>
                                <option value="1300">1300 VA</option>
                                <option value="2200">2200 VA</option>
                                <option value="3500">3500 VA</option>
                            </select>

                            <!-- 🔸 Input manual -->
                            <input type="number" name="daya" id="daya" required
                                class="w-1/2 border rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Atau tulis manual">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pilih dari daftar atau tulis manual jika tidak ada.</p>
                    </div>

                    <!-- Hubungkan ke User -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Hubungkan ke Akun User</label>
                        <select id="user_id" name="user_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm 
                                   focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">--Pilih User--</option>

                            <!-- 🔹 Ambil data user dari database -->
                            <?php
                            $users = mysqli_query($conn, "SELECT * FROM users WHERE role='user'");
                            while ($u = mysqli_fetch_assoc($users)) {
                                echo "<option value='{$u['id']}'>"
                                    .htmlspecialchars($u['nama'])
                                    ." (".htmlspecialchars($u['username']).")</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Tombol Simpan -->
                    <div>
                        <button type="submit"
                            class="w-full rounded-md border border-transparent bg-blue-600 py-2 px-4 
                                   text-sm font-medium text-white shadow-sm hover:bg-blue-700 
                                   focus:ring-2 focus:ring-blue-500">
                            Simpan Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<!-- =============================== -->
<!-- 🔹 Script otomatis isi daya -->
<script>
const dayaSelect = document.getElementById('daya_select');
const dayaInput = document.getElementById('daya');

dayaSelect.addEventListener('change', () => {
    if (dayaSelect.value) {
        dayaInput.value = dayaSelect.value; // isi otomatis input jika dropdown dipilih
    }
});
</script>

</body>
</html>
