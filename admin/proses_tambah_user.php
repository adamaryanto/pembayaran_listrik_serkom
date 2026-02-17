<?php
include '../config/db.php';

$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$role     = $_POST['role'];

// Cek apakah username sudah digunakan
$check = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
if (mysqli_num_rows($check) > 0) {
    header("Location: tambah_user.php?error=Username sudah digunakan!");
    exit;
}

$query = "INSERT INTO users (nama, username, password, role)
          VALUES ('$nama', '$username', '$password', '$role')";

if (mysqli_query($conn, $query)) {
    header("Location: data_user.php?msg=User berhasil ditambahkan");
} else {
    echo "Gagal menambah user: " . mysqli_error($conn);
}
?>
