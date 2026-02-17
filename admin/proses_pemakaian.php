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

// Cek ketersediaan pelanggan dan ambil daya
$qPelanggan = mysqli_query($conn, "SELECT daya FROM pelanggan WHERE id = $pelanggan_id");
if (!$qPelanggan || mysqli_num_rows($qPelanggan) == 0) {
    echo "<script>alert('Pelanggan tidak ditemukan!');history.back();</script>";
    exit;
}
$dataPelanggan = mysqli_fetch_assoc($qPelanggan);
$daya = $dataPelanggan['daya'];

// Simpan data pemakaian
$sqlPemakaian = "INSERT INTO pemakaian (pelanggan_id, bulan, tahun, meter_awal, meter_akhir)
                 VALUES ('$pelanggan_id', '$bulan', '$tahun', '$meter_awal', '$meter_akhir')";

if (mysqli_query($conn, $sqlPemakaian)) {
    // Ambil ID pemakaian yang baru saja disimpan
    $pemakaian_id = mysqli_insert_id($conn);

    // Hitung jumlah kWh dan total tagihan
    $jumlah_kwh = $meter_akhir - $meter_awal;
    
    // Tentukan tarif per kWh berdasarkan daya
    if ($daya <= 900) {
        $tarif = 1000;
    } elseif ($daya <= 1200) {
        $tarif = 1400;
    } elseif ($daya <= 1300) {
        $tarif = 1500;
    } elseif ($daya <= 2200) {
        $tarif = 1700;
    } else {
        $tarif = 2000;
    }

    $total_bayar = $jumlah_kwh * $tarif;

    // Simpan data tagihan otomatis
    $sqlTagihan = "INSERT INTO tagihan (pemakaian_id, jumlah_kwh, total_bayar, status)
                   VALUES ('$pemakaian_id', '$jumlah_kwh', '$total_bayar', 'belum dibayar')";
    
    if (mysqli_query($conn, $sqlTagihan)) {
        echo "<script>
                alert('Data pemakaian dan tagihan berhasil disimpan!');
                window.location='data_tagihan.php';
              </script>";
    } else {
        echo "<script>
                alert('Data pemakaian disimpan, tetapi gagal membuat tagihan: " . mysqli_error($conn) . "');
                window.location='data_tagihan.php';
              </script>";
    }

} else {
    die('Gagal menyimpan data pemakaian: ' . mysqli_error($conn));
}
?>
