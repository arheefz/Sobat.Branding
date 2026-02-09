<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Tangkap data dari form
    $new_jasa = [
        'id'          => time(), // buat ID unik pake timestamp
        'nama_jasa'   => $_POST['title'],
        'harga'       => $_POST['price'],
        'kategori'    => $_POST['category'],
        'deskripsi'   => $_POST['description'],
        'gambar'      => ''
    ];

    // 2. Proses upload gambar ke folder
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $filename = time() . "_" . $_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename)) {
            $new_jasa['gambar'] = $filename;
        }
    }

    // 3. Simpan ke dalam SESSION (Array list jasa)
    if (!isset($_SESSION['list_jasa'])) {
        $_SESSION['list_jasa'] = [];
    }
    
    // Masukkan data baru ke urutan paling atas
    array_unshift($_SESSION['list_jasa'], $new_jasa);

    // 4. Langsung lempar ke beranda
    echo "<script>alert('Jasa berhasil diupload secara instan!'); window.location.href='index.php';</script>";
}