<?php
session_start();

// Hanya user yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/db.php';

// Ambil data pelanggan berdasarkan user yang login
$user_id = $_SESSION['id'];
$pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE user_id='$user_id'"));

$nama = $_SESSION['nama'] ?? 'User';
$role = $_SESSION['role'] ?? 'user';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tagihan - Aplikasi Listrik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

<!--  NAVBAR -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">Listrik Pascabayar</span>
                </div>
            </div>
            <div class="flex items-center">
                <div class="text-sm text-gray-600">
                    Halo, <strong class="font-medium text-gray-800"><?= htmlspecialchars($nama) ?></strong> 
                    (<span class="italic text-gray-500"><?= htmlspecialchars($role) ?></span>)
                </div>
                <a href="../admin/proses_logout.php" class="ml-4 text-sm font-medium text-blue-600 hover:text-blue-500">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!--  KONTEN UTAMA -->
<div class="py-10">
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">Daftar Tagihan Saya</h1>
            <a href="index.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <?php if (!$pelanggan): ?>
            <!-- Jika pelanggan belum didaftarkan admin -->
            <div class="rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Data Pelanggan Tidak Ditemukan</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Data pelanggan Anda belum diinput oleh admin. Silakan hubungi admin untuk mendaftarkan data pelanggan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>

        <?php
        // Ambil data tagihan pelanggan
        $q = mysqli_query($conn, "
            SELECT tagihan.*, pemakaian.bulan, pemakaian.tahun 
            FROM tagihan 
            JOIN pemakaian ON tagihan.pemakaian_id = pemakaian.id
            WHERE pemakaian.pelanggan_id = '{$pelanggan['id']}'
            ORDER BY pemakaian.tahun DESC,
            FIELD(pemakaian.bulan, 
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember')
        ");
        ?>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-b-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Bayar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (mysqli_num_rows($q) === 0): ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Anda belum memiliki data tagihan.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php while ($d = mysqli_fetch_assoc($q)): ?>
                                            <?php
                                            // Normalisasi status agar tidak masalah huruf besar/kecil
                                            $status = strtolower(trim($d['status']));
                                            $badge_class = ($status === 'lunas')
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800';
                                            ?>
                                            <tr>
                                                <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($d['bulan']) ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($d['tahun']) ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-700">Rp <?= number_format($d['total_bayar']) ?></td>
                                                <td class="px-6 py-4 text-sm">
                                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full <?= $badge_class ?>">
                                                        <?= htmlspecialchars(ucwords($status)) ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium">
                                                    <?php if (in_array($status, ['belum bayar', 'belum dibayar', 'belum_lunas'])): ?>
                                                        <a href="bayar.php?id=<?= $d['id'] ?>" 
                                                           class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                                            Bayar
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-gray-400 italic">Sudah Lunas</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endif; // Tutup if pelanggan ?>
    </main>
</div>
<?php include '../layout/footer.php'; ?>
</body>
</html>
