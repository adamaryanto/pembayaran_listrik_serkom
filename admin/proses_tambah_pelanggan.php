<?php
session_start();
include '../config/db.php';

$no_kwh         = $_POST['no_kwh'];
$nama_pelanggan = $_POST['nama_pelanggan'];
$alamat         = $_POST['alamat'];
$daya           = $_POST['daya'];
$user_id        = $_POST['user_id'];

// Cek jika nomor KWH sudah terdaftar
$cek = mysqli_query($conn, "SELECT * FROM pelanggan WHERE no_kwh='$no_kwh'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Nomor KWH sudah terdaftar!');
            window.location='tambah_pelanggan.php';
          </script>";
    exit;
}

$sql = "INSERT INTO pelanggan (user_id, no_kwh, nama_pelanggan, alamat, daya)
        VALUES ('$user_id', '$no_kwh', '$nama_pelanggan', '$alamat', '$daya')";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Data pelanggan berhasil disimpan!');
            window.location='data_pelanggan.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menyimpan data!');
            window.location='tambah_pelanggan.php';
          </script>";
}
?>
