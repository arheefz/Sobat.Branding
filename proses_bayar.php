<?php
include 'config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek kalau user belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama_pengirim = mysqli_real_escape_string($conn, $_POST['nama_pengirim']);
    $metode = mysqli_real_escape_string($conn, $_POST['metode']);
    $nominal = mysqli_real_escape_string($conn, $_POST['nominal']);
    
    // --- PROSES UPLOAD GAMBAR ---
    $nama_file = $_FILES['bukti']['name'];
    $tmp_file = $_FILES['bukti']['tmp_name'];
    $ukuran_file = $_FILES['bukti']['size'];
    
    // Acak nama file biar gak bentrok (Contoh: 8273_bukti.jpg)
    $ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_baru = rand(1000, 9999) . "_" . time() . "." . $ekstensi;
    $path_tujuan = "uploads/" . $nama_baru;

    // Validasi Ukuran (Max 5MB)
    if ($ukuran_file > 5000000) {
        echo "<script>alert('Gagal! Ukuran file terlalu besar (Max 5MB)'); history.back();</script>";
        exit;
    }

    // Pindahkan file dari folder sementara ke folder uploads
    if (move_uploaded_file($tmp_file, $path_tujuan)) {
        
        // Simpan data ke database (Sesuaikan nama tabel lo, misal: pesanan)
        // Jika tabel belum ada, buat dulu di phpMyAdmin
        $sql = "INSERT INTO pesanan (user_id, nama_pengirim, metode, nominal, bukti_transfer, status) 
                VALUES ('$user_id', '$nama_pengirim', '$metode', '$nominal', '$nama_baru', 'pending')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Konfirmasi terkirim! Admin akan mengecek pesanan Anda.'); window.location='index.php';</script>";
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }

    } else {
        echo "<script>alert('Gagal mengunggah gambar. Cek folder uploads!'); history.back();</script>";
    }
} else {
    header("Location: checkout.php");
}
?>