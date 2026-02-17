<?php 
$start_time = microtime(true);
session_start(); 
if($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/init.php';
$nama = $_SESSION['nama'] ?? 'Admin';
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Aplikasi Listrik Pascabayar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
                    <svg class="h-8 w-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" 
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">Listrik Pascabayar</span>
                </div>
            </div>
            <div class="flex items-center">
                <div class="text-sm text-gray-600">
                    Halo, <strong class="font-medium text-gray-800"><?= htmlspecialchars($nama) ?></strong> 
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
                Tambah User Baru
            </h1>
            <a href="data_user.php" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm 
                      text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                &larr; Kembali
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Formulir User</h3>
                <p class="mt-1 text-sm text-gray-500">Buat akun baru untuk admin atau user.</p>
                
                <form action="proses_tambah_user.php" method="POST" class="mt-6 space-y-6">
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                      focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                               placeholder="Nama lengkap">
                    </div>
                    
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" id="username" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                      focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                               placeholder="Username (untuk login)">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                      focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                               placeholder="Password baru">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role Pengguna</label>
                        <select name="role" id="role" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                       focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    
                    <div>
                        <button type="submit"
                                class="flex w-full justify-center rounded-md border border-transparent 
                                       bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm 
                                       hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<?php include '../config/init.php';?>
</body>
</html>
