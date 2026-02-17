<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/db.php';

$id = $_GET['id'];

// Cegah penghapusan akun sendiri
if ($id == $_SESSION['id']) {
    header("Location: data_user.php?error=Anda tidak bisa menghapus akun sendiri!");
    exit;
}

$query = "DELETE FROM users WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header("Location: data_user.php?msg=User berhasil dihapus");
} else {
    echo "Gagal menghapus user: " . mysqli_error($conn);
}
?>
