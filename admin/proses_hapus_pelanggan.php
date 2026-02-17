<?php
session_start();
include '../config/db.php';

$id = $_GET['id'];

// Cek apakah pelanggan memiliki data pemakaian
$cek = mysqli_query($conn, "SELECT * FROM pemakaian WHERE pelanggan_id='$id'");

if (mysqli_num_rows($cek) > 0) {
    // Cek apakah permintaan hapus paksa dikonfirmasi
    if (isset($_GET['force']) && $_GET['force'] == 'true') {
        // Hapus tagihan terkait terlebih dahulu
        mysqli_query($conn, "
            DELETE FROM tagihan 
            WHERE pemakaian_id IN (SELECT id FROM pemakaian WHERE pelanggan_id='$id')
        ");

        // Hapus data pemakaian
        mysqli_query($conn, "DELETE FROM pemakaian WHERE pelanggan_id='$id'");

        // Hapus data pelanggan
        mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");

        echo "<script>
            alert('Pelanggan dan seluruh data terkait berhasil dihapus!');
            window.location='data_pelanggan.php';
        </script>";
    } else {
        // Konfirmasi penghapusan jika ada data terkait
        echo "<script>
            if (confirm('Pelanggan ini memiliki riwayat pemakaian. Hapus pelanggan beserta seluruh datanya?')) {
                window.location='proses_hapus_pelanggan.php?id=$id&force=true';
            } else {
                window.location='data_pelanggan.php';
            }
        </script>";
    }
    exit;
}

// Hapus pelanggan langsung jika tidak ada data terkait
mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");

echo "<script>
    alert('Data pelanggan berhasil dihapus!');
    window.location='data_pelanggan.php';
</script>";
?>
