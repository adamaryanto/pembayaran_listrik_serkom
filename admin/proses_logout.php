<?php
session_start();
// Hapus semua data session dan redirect ke halaman login
session_destroy();
header("Location: ../auth/login.php");
?>
