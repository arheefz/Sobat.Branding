<?php
// Mulai session agar bisa dihancurkan
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Tendang balik ke halaman utama (Landing Page)
header("Location: index.php");
exit();
?>