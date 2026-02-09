<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    
    // Logika Upload Gambar
    $nama_file = $_FILES['bukti_transfer']['name'];
    $tmp_file = $_FILES['bukti_transfer']['tmp_name'];
    $ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_baru = "bukti_" . time() . "." . $ekstensi; // Ganti nama biar unik
    $folder_tujuan = "uploads/bukti/" . $nama_baru;

    // Buat folder jika belum ada
    if (!is_dir('uploads/bukti')) {
        mkdir('uploads/bukti', 0777, true);
    }

    if (move_uploaded_file($tmp_file, $folder_tujuan)) {
        // Simpan ke database
        $sql = "INSERT INTO orders (user_id, service_id, note, bukti_pembayaran, status) 
                VALUES ('$user_id', '$service_id', '$catatan', '$nama_baru', 'pending')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Pembayaran Berhasil Diupload! Admin akan segera memproses.'); window.location='index.php?page=dashboard';</script>";
        } else {
            echo "Gagal simpan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengunggah gambar. Pastikan folder uploads/bukti tersedia.";
    }
}
?>