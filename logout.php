<?php

// ==========================================================
// OLD MONEY COFFEE
// LOGOUT CUSTOMER / ADMIN
// ==========================================================

// Memulai session
session_start();

// Menghapus semua data session
session_unset();

// Menghancurkan session
session_destroy();

// Kembali ke halaman utama
header("Location: index.php");

exit;

?>