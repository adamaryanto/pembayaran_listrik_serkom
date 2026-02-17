<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/db.php';

$id = $_GET['id'] ?? 0;
$id = (int) $id;

// Ubah status tagihan jadi Lunas
mysqli_query($conn, "UPDATE tagihan SET status='Lunas' WHERE id=$id");

echo "<script>
alert('Pembayaran berhasil! Terima kasih sudah membayar tagihan Anda.');
window.location='tagihan.php';
</script>";
?>
