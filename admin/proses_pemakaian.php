<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/db.php';

// Pastikan semua data form terisi
if (!isset($_POST['pelanggan_id'], $_POST['bulan'], $_POST['tahun'], $_POST['meter_awal'], $_POST['meter_akhir'])) {
    die("Form tidak lengkap!");
}

$pelanggan_id = (int) $_POST['pelanggan_id'];
$bulan        = mysqli_real_escape_string($conn, $_POST['bulan']);
$tahun        = (int) $_POST['tahun'];
$meter_awal   = (int) $_POST['meter_awal'];
$meter_akhir  = (int) $_POST['meter_akhir'];

// Validasi meteran
if ($meter_akhir <= $meter_awal) {
    echo "<script>alert('Meter akhir harus lebih besar dari meter awal!');history.back();</script>";
    exit;
}

// Cek ketersediaan pelanggan
$qPelanggan = mysqli_query($conn, "SELECT daya FROM pelanggan WHERE id = $pelanggan_id");
if (!$qPelanggan || mysqli_num_rows($qPelanggan) == 0) {
    echo "<script>alert('Pelanggan tidak ditemukan!');history.back();</script>";
    exit;
}

// Simpan data pemakaian
$sqlPemakaian = "INSERT INTO pemakaian (pelanggan_id, bulan, tahun, meter_awal, meter_akhir)
                 VALUES ('$pelanggan_id', '$bulan', '$tahun', '$meter_awal', '$meter_akhir')";

if (!mysqli_query($conn, $sqlPemakaian)) {
    die('Gagal menyimpan data pemakaian: ' . mysqli_error($conn));
}

echo "<script>
        alert('Data pemakaian berhasil disimpan! Tagihan otomatis dibuat.');
        window.location='data_tagihan.php';
      </script>";
?>
