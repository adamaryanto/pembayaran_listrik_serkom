<?php
session_start();

// Pastikan hanya user yang login bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/db.php';

$user_id = $_SESSION['id'];
$pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE user_id='$user_id'"));

$total_tagihan = 0;
$total_lunas = 0;

if ($pelanggan) {
    // Hitung total tagihan dan tagihan lunas
    $tagihan = mysqli_query($conn, "
        SELECT status, COUNT(*) AS jumlah 
        FROM tagihan 
        JOIN pemakaian ON tagihan.pemakaian_id = pemakaian.id 
        WHERE pemakaian.pelanggan_id = '{$pelanggan['id']}'
        GROUP BY status
    ");
    while ($row = mysqli_fetch_assoc($tagihan)) {
        if ($row['status'] === 'Belum Bayar') {
            $total_tagihan = $row['jumlah'];
        } elseif ($row['status'] === 'Lunas') {
            $total_lunas = $row['jumlah'];
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Aplikasi Listrik</title>
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
                    Halo, <strong class="font-medium text-gray-800"><?= htmlspecialchars($_SESSION['nama']) ?></strong> 
                    (<span class="italic text-gray-500"><?= htmlspecialchars($_SESSION['role']) ?></span>)
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
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
            Dashboard Pelanggan
        </h1>
        <p class="mt-2 text-gray-600">
            Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?>!  
            Anda dapat melihat tagihan listrik Anda dan status pembayarannya.
        </p>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <?php if (!$pelanggan): ?>
            <div class="rounded-md bg-yellow-50 p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Data pelanggan tidak ditemukan</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Data pelanggan Anda belum diinput oleh admin. Silakan hubungi admin agar akun Anda dapat dihubungkan dengan data pelanggan.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
        
        <!--  Statistik Tagihan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="px-6 py-5">
                    <div class="text-sm font-medium text-gray-500 truncate">Tagihan Belum Dibayar</div>
                    <div class="mt-2 text-3xl font-semibold text-red-600"><?= $total_tagihan ?></div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="px-6 py-5">
                    <div class="text-sm font-medium text-gray-500 truncate">Tagihan Lunas</div>
                    <div class="mt-2 text-3xl font-semibold text-green-600"><?= $total_lunas ?></div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="px-6 py-5">
                    <div class="text-sm font-medium text-gray-500 truncate">Total Daya</div>
                    <div class="mt-2 text-3xl font-semibold text-blue-600"><?= htmlspecialchars($pelanggan['daya']) ?> VA</div>
                </div>
            </div>
        </div>

        <!--  Menu Aksi -->
        <div class="mt-10">
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                
                <li class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden divide-y divide-gray-200">
                    <a href="tagihan.php" class="block hover:bg-gray-50">
                        <div class="p-6 flex items-center space-x-4">
                            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xl font-semibold text-gray-900">Lihat Tagihan</p>
                                <p class="text-sm text-gray-500">Lihat detail dan status pembayaran Anda.</p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <?php endif; ?>
    </main>
</div>
<?php include '../layout/footer.php'; ?>
</body>
</html>
