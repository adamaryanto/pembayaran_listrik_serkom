<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include '../config/db.php';

$id       = $_POST['id'];
$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

// Cek apakah username sudah digunakan (kecuali oleh user ini sendiri)
$check = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username' AND id != '$id'");
if (mysqli_num_rows($check) > 0) {
    header("Location: edit_user.php?id=$id&error=Username sudah digunakan!");
    exit;
}

// Update password hanya jika diisi
if (!empty($password)) {
    $password = md5($password);
    $query = "UPDATE users SET nama='$nama', username='$username', password='$password', role='$role' WHERE id='$id'";
} else {
    $query = "UPDATE users SET nama='$nama', username='$username', role='$role' WHERE id='$id'";
}

if (mysqli_query($conn, $query)) {
    header("Location: data_user.php?msg=Data user berhasil diperbarui");
} else {
    echo "Gagal memperbarui user: " . mysqli_error($conn);
}
?>
