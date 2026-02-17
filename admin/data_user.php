<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/db.php';
include '../config/init.php';

// Handle success/error messages
$msg = $_GET['msg'] ?? '';
$error = $_GET['error'] ?? '';

?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - Aplikasi Listrik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        html { font-family: 'Inter', sans-serif; }
    </style>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                Data User
            </h1>
            <div class="flex space-x-2">
                <a href="index.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    &larr; Kembali
                </a>
                <a href="tambah_user.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Tambah User
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <?php if ($msg): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p><?= htmlspecialchars($msg) ?></p>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-b-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    $no = 1;
                                    $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                                    if (mysqli_num_rows($result) === 0):
                                    ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Belum ada data user.
                                            </td>
                                        </tr>
                                    <?php else: while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $no ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['nama']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['username']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $row['role'] == 'admin' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                                    <?= htmlspecialchars(ucfirst($row['role'])) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                <a href="edit_user.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-900 font-medium mr-2">Edit</a>
                                                
                                                <?php if ($row['id'] != $_SESSION['id']): // Prevent deleting self ?>
                                                <a href="proses_hapus_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="text-red-600 hover:text-red-800 font-medium">Hapus</a>
                                                <?php else: ?>
                                                    <span class="text-gray-400 cursor-not-allowed">Hapus</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php $no++; endwhile; endif; ?>
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
