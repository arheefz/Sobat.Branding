<?php 
include 'config/db.php'; 

// FIX NOTICE: Cek session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";
$success = "";

// --- MESIN REGISTER ---
if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $checkEmail = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $query = mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$nama', '$email', '$password')");
        if ($query) {
            $success = "Akun berhasil dibuat! Silakan login.";
        } else {
            $error = "Gagal mendaftar.";
        }
    }
}

// --- MESIN LOGIN ---
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['is_login'] = true;

            header("Location: index.php"); 
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | SobatBranding</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #d97706 0%, #1e3a8a 100%);
            background-attachment: fixed;
            margin: 0;
            overflow-x: hidden;
        }
        .card-auth { border-radius: 32px; box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.4); }
        .input-auth { border: 1px solid #f1f5f9; border-radius: 12px; transition: all 0.3s; }
        .input-auth:focus { border-color: #f38d2c; outline: none; background: white; box-shadow: 0 0 0 4px rgba(243, 141, 44, 0.1); }
        .hidden-form { display: none; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full">
        <div class="bg-white card-auth overflow-hidden p-8 md:p-10">
            
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-2 cursor-pointer" onclick="window.location='index.php'">
                    <img src="uploads/logo.png" class="w-8 h-8 object-contain">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">Sobat</span>
                        <span class="text-xs font-black text-orange-500 uppercase leading-none">Branding</span>
                    </div>
                </div>
                <a href="index.php" class="text-gray-300 hover:text-gray-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </div>

            <?php if($error): ?>
                <div class="mb-4 p-3 bg-red-50 text-red-500 text-xs font-bold rounded-xl text-center"><?= $error ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="mb-4 p-3 bg-green-50 text-green-500 text-xs font-bold rounded-xl text-center"><?= $success ?></div>
            <?php endif; ?>

            <div id="loginForm" class="<?= isset($_POST['register']) ? 'hidden-form' : '' ?>">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-[#1a365d] tracking-tight">Selamat Datang!</h1>
                    <p class="text-xs text-gray-400 mt-2 font-medium">Masuk untuk akses ribuan jasa branding.</p>
                </div>

                <form action="" method="POST" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Email</label>
                        <input type="email" name="email" placeholder="nama@email.com" class="w-full px-5 py-3.5 bg-gray-50 input-auth text-sm font-medium" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full px-5 py-3.5 bg-gray-50 input-auth text-sm font-medium" required>
                    </div>
                    
                    <button type="submit" name="login" class="w-full bg-[#1a365d] text-white py-4 mt-2 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-blue-900/20 hover:bg-[#152a4a] transition-all">
                        Masuk Sekarang
                    </button>
                </form>

                <p class="mt-8 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    Belum punya akun? <button onclick="toggleForm()" class="text-orange-500 hover:underline ml-1 font-black">Daftar Di Sini</button>
                </p>
            </div>

            <div id="registerForm" class="<?= isset($_POST['register']) ? '' : 'hidden-form' ?>">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-[#1a365d] tracking-tight">Buat Akun Baru</h1>
                    <p class="text-xs text-gray-400 mt-2 font-medium">Mulai perjalanan bisnis Anda hari ini.</p>
                </div>
                <form action="" method="POST" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Masukkan nama Anda" class="w-full px-5 py-3.5 bg-gray-50 input-auth text-sm font-medium" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Email</label>
                        <input type="email" name="email" placeholder="nama@email.com" class="w-full px-5 py-3.5 bg-gray-50 input-auth text-sm font-medium" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Password</label>
                        <input type="password" name="password" placeholder="Buat password aman" class="w-full px-5 py-3.5 bg-gray-50 input-auth text-sm font-medium" required>
                    </div>
                    <button type="submit" name="register" class="w-full bg-orange-500 text-white py-4 mt-2 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-orange-500/20 hover:bg-orange-600 transition-all">
                        Daftar Akun
                    </button>
                </form>
                <p class="mt-8 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    Sudah punya akun? <button onclick="toggleForm()" class="text-[#1a365d] hover:underline ml-1 font-black">Masuk Saja</button>
                </p>
            </div>

        </div>
    </div>

    <script>
        function toggleForm() {
            document.getElementById('loginForm').classList.toggle('hidden-form');
            document.getElementById('registerForm').classList.toggle('hidden-form');
        }
    </script>
</body>
</html>