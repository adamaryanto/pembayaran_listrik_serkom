<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/db.php';
include '../config/init.php';


$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE id='$id'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-xl mx-auto mt-10 bg-white p-6 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Data Pelanggan</h2>
    <form action="proses_edit_pelanggan.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label class="block text-sm font-medium text-gray-700">No KWH</label>
        <input type="text" name="no_kwh" value="<?= htmlspecialchars($data['no_kwh']) ?>" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm mb-3">

        <label class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" value="<?= htmlspecialchars($data['nama_pelanggan']) ?>" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm mb-3">

        <label class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea name="alamat" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm mb-3"><?= htmlspecialchars($data['alamat']) ?></textarea>

        <label class="block text-sm font-medium text-gray-700">Daya (VA)</label>
        <input type="number" name="daya" value="<?= htmlspecialchars($data['daya']) ?>" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm mb-4">

        <div class="flex justify-end space-x-2">
            <a href="data_pelanggan.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
