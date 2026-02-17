<?php
$start_time = microtime(true);
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/db.php';

include '../config/init.php';

?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tagihan - Aplikasi Listrik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Optional: Tambahkan font default yang lebih baik */
        @import url('https://rsms.me/inter/inter.css');
        html { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

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
                    <a href="proses_logout.php" class="ml-4 text-sm font-medium text-blue-600 hover:text-blue-500">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="py-10">
        <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">
                    Data Tagihan Pelanggan
                </h1>
                <a href="index.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-b-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah kWh</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Bayar</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        
                                        <?php
                                        // Logika PHP Anda tetap sama
                                        $no = 1;
                                        $query = mysqli_query($conn, "
                                            SELECT t.*, p.nama_pelanggan, pm.bulan, pm.tahun 
                                            FROM tagihan t
                                            JOIN pemakaian pm ON t.pemakaian_id = pm.id
                                            JOIN pelanggan p ON pm.pelanggan_id = p.id
                                            ORDER BY pm.tahun DESC, pm.bulan ASC
                                        ");

                                        if (mysqli_num_rows($query) === 0):
                                        ?>
                                            <tr>
                                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    Belum ada data tagihan.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <?= $no ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($row['nama_pelanggan']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($row['bulan']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($row['tahun']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($row['jumlah_kwh']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp <?= number_format($row['total_bayar']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <?php
                                                    // Logika untuk Badge Status
                                                    $status = $row['status'];
                                                    $badge_class = '';
                                                    if ($status === 'Lunas') {
                                                        $badge_class = 'bg-green-100 text-green-800';
                                                    } elseif ($status === 'Belum Bayar') {
                                                        $badge_class = 'bg-red-100 text-red-800';
                                                    } else {
                                                        $badge_class = 'bg-gray-100 text-gray-800';
                                                    }
                                                    ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badge_class ?>">
                                                        <?= htmlspecialchars($status) ?>
                                                    </span>
                                                </td>
                                                
                                            </tr>
                                            <?php 
                                            $no++;
                                            endwhile; 
                                            ?>
                                        <?php endif; ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>
    </div>

<?php include '../config/init.php';?>
    </body>
</html>