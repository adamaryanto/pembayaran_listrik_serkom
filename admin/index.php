<?php
$start_time = microtime(true);
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit; // Pastikan untuk exit setelah header redirect
}
include '../config/db.php';
include '../config/init.php';


?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Aplikasi Listrik</title>
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
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Admin Dashboard
            </h1>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mt-4">
                <p class="text-lg text-gray-700">
                    Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?>. Kelola sistem dari sini.
                </p>
            </div>

            <div class="mt-8">
                <ul role="list" class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    
                    <li class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden divide-y divide-gray-200">
                        <a href="data_user.php" class="block hover:bg-gray-50">
                            <div class="p-6 flex items-center space-x-4">
                                <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                    <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-gray-900">Data User</p>
                                    <p class="text-sm text-gray-500">Kelola akun admin & user.</p>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden divide-y divide-gray-200">
                        <a href="data_pelanggan.php" class="block hover:bg-gray-50">
                            <div class="p-6 flex items-center space-x-4">
                                <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                    <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-4.682-2.72-4.682 2.72a3 3 0 0 1-4.682-2.72 9.094 9.094 0 0 1 3.741-.479m7.41 1.407a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zmm-4.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-gray-900">Data Pelanggan</p>
                                    <p class="text-sm text-gray-500">Kelola data pelanggan terdaftar.</p>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden divide-y divide-gray-200">
                        <a href="input_pemakaian.php" class="block hover:bg-gray-50">
                            <div class="p-6 flex items-center space-x-4">
                                <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                    <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-gray-900">Input Pemakaian</p>
                                    <p class="text-sm text-gray-500">Catat meteran kWh bulanan.</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    
                    <li class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden divide-y divide-gray-200">
                        <a href="data_tagihan.php" class="block hover:bg-gray-50">
                            <div class="p-6 flex items-center space-x-4">
                                <div class="flex-shrink-0 p-3 bg-blue-100 rounded-full">
                                    <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-gray-900">Data Tagihan</p>
                                    <p class="text-sm text-gray-500">Lihat & kelola semua tagihan.</p>
                                </div>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
            </main>
    </div>


    </body>
</html>