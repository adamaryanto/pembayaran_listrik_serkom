<?php
session_start();
include '../config/db.php';

$id       = $_POST['id'];
$no_kwh   = $_POST['no_kwh'];
$nama     = $_POST['nama_pelanggan'];
$alamat   = $_POST['alamat'];
$daya     = $_POST['daya'];

// Update data pelanggan di database
mysqli_query($conn, "
    UPDATE pelanggan SET 
        no_kwh = '$no_kwh',
        nama_pelanggan = '$nama',
        alamat = '$alamat',
        daya = '$daya'
    WHERE id = '$id'
");

echo "<script>
    alert('Data pelanggan berhasil diperbarui!');
    window.location = 'data_pelanggan.php';
</script>";
?>
