<?php 
session_start();
include 'config/db.php'; 

// Ambil data user untuk foto profil jika login
$current_user = null;
if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    $user_id = $_SESSION['user_id'];
    $query_user = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
    $current_user = mysqli_fetch_assoc($query_user);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SobatBranding | Marketplace Jasa Digital UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .text-navy { color: #1a365d; }
        .bg-navy { background-color: #1a365d; }
        .text-orange { color: #f38d2c; }
        .bg-orange { background-color: #f38d2c; }
        
        .hero-bg {
            background: linear-gradient(rgba(26, 54, 93, 0.85), rgba(26, 54, 93, 0.85)), 
                        url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80');
            background-size: cover; background-position: center;
        }
        .cta-box { background: #1a365d; border-radius: 40px; }
        
        /* Animasi Dropdown */
        .dropdown-animate {
            transform-origin: top right;
            transition: all 0.2s ease-out;
        }
    </style>
</head>
<body class="bg-white antialiased">

    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3 cursor-pointer" onclick="window.location='index.php'">
                <img src="uploads/logo.png" alt="Logo" class="w-10 h-10 object-contain">
                <div class="leading-none">
                    <span class="text-xl font-extrabold block tracking-tight text-navy">Sobat</span>
                    <span class="text-xl font-extrabold block tracking-tight text-orange -mt-1">Branding</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-10">
                <a href="#eksplor-jasa" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-navy transition-all">Cari Jasa</a>
                <a href="index.php?page=sejarah" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-navy transition-all">Sejarah</a>
            </nav>

            <div class="flex items-center gap-6">
                <?php if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true): ?>
                    <div class="relative" id="userDropdown">
                        <button onclick="toggleDropdown()" class="flex items-center gap-3 bg-gray-50 hover:bg-gray-100 p-1.5 pr-4 rounded-full transition-all border border-gray-100">
                            <div class="w-9 h-9 rounded-full bg-navy flex items-center justify-center text-white font-bold text-xs overflow-hidden border-2 border-white shadow-sm">
                                <?php if (!empty($current_user['foto_profil'])): ?>
                                    <img src="uploads/profile/<?= $current_user['foto_profil'] ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= $current_user['username'] ?>&background=1a365d&color=fff" class="w-full h-full">
                                <?php endif; ?>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-[9px] font-black text-gray-400 uppercase leading-none mb-1">Halo,</p>
                                <p class="text-xs font-black text-navy leading-none"><?= explode(' ', $current_user['username'])[0] ?></p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div id="dropdownContent" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-3 z-50 dropdown-animate">
                            <div class="px-4 py-2 border-b border-gray-50 mb-2">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Email</p>
                                <p class="text-xs font-bold text-navy truncate"><?= $current_user['email'] ?></p>
                            </div>
                            <a href="index.php?page=profil" class="flex items-center gap-3 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-gray-500 hover:text-navy hover:bg-gray-50 transition-all">
                                <span>👤</span> Profil Saya
                            </a>
                            <a href="index.php?page=pesanan" class="flex items-center gap-3 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-gray-500 hover:text-navy hover:bg-gray-50 transition-all">
                                <span>📦</span> Pesanan Saya
                            </a>
                            <hr class="my-2 border-gray-50">
                            <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-red-500 hover:bg-red-50 transition-all">
                                <span>🚪</span> Keluar Akun
                            </a>
                        </div>
                    </div>
                    <a href="index.php?page=tambah_jasa" class="bg-orange text-white text-[11px] font-black px-7 py-3 rounded-xl shadow-lg shadow-orange/20 hover:scale-105 transition-all uppercase tracking-widest">Mulai Jualan</a>
                <?php else: ?>
                    <a href="login.php" class="text-xs font-extrabold uppercase tracking-widest text-navy">Masuk</a>
                    <a href="login.php" class="bg-orange text-white text-[11px] font-black px-7 py-3 rounded-xl shadow-lg shadow-orange/20 hover:scale-105 transition-all uppercase tracking-widest">Mulai Jualan</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <?php if(!isset($_GET['page']) || $_GET['page'] == 'home'): ?>
            
            <section class="hero-bg min-h-[85vh] flex flex-col items-center justify-center text-center px-6 text-white">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                    Solusi Branding & Jasa Digital <br> <span class="text-orange">Terbaik untuk UMKM Indonesia</span>
                </h1>
                <p class="text-lg text-gray-200 max-w-2xl mb-12 font-medium opacity-90 leading-relaxed">
                    Temukan ribuan freelancer profesional siap membantu bisnis Anda naik kelas. <br> Cepat, aman, dan berkualitas.
                </p>
                <div class="flex flex-col md:flex-row gap-5">
                    <a href="#eksplor-jasa" class="bg-orange text-white px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-2xl shadow-orange/30 hover:-translate-y-1 transition-all">
                        Cari Freelancer
                    </a>
                    <a href="index.php?page=sejarah" class="border-2 border-white text-white px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-white hover:text-navy transition-all">
                        Kisah SobatBranding
                    </a>
                </div>
                <div class="flex flex-wrap justify-center gap-8 mt-16 text-[10px] font-bold uppercase tracking-[2px] text-gray-300">
                    <div class="flex items-center gap-2"><span class="text-orange">✓</span> Transaksi Aman</div>
                    <div class="flex items-center gap-2"><span class="text-orange">✓</span> Kualitas Terjamin</div>
                    <div class="flex items-center gap-2"><span class="text-orange">✓</span> Dukungan 24/7</div>
                </div>
            </section>

            <section class="py-24 bg-white px-6">
                <div class="max-w-7xl mx-auto text-center">
                    <h2 class="text-3xl font-black text-navy mb-2">Kategori Populer</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-16">Pilih spesialisasi yang Anda butuhkan</p>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
                        <?php
                        $cats = [
                            ['icon' => '🎨', 'name' => 'Desain Grafis'],
                            ['icon' => '📱', 'name' => 'Digital Marketing'],
                            ['icon' => '💻', 'name' => 'Website & IT'],
                            ['icon' => '🎥', 'name' => 'Video & Animasi'],
                            ['icon' => '✍️', 'name' => 'Penulisan & Terjemahan'],
                            ['icon' => '🌟', 'name' => 'Gaya Hidup'],
                        ];
                        foreach($cats as $c): ?>
                            <div class="group p-8 bg-white border border-gray-100 rounded-[32px] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all cursor-pointer">
                                <div class="text-4xl mb-4 grayscale group-hover:grayscale-0 transition-all"><?= $c['icon'] ?></div>
                                <span class="text-[10px] font-extrabold uppercase text-navy tracking-tighter leading-tight"><?= $c['name'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="py-24 bg-slate-50 px-6 overflow-hidden">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-4xl font-black text-navy mb-12 italic">Mengapa SobatBranding?</h2>
                        <div class="space-y-10">
                            <div class="flex gap-6">
                                <div class="w-12 h-12 bg-navy text-white rounded-2xl flex items-center justify-center font-bold shadow-lg shadow-navy/20">1</div>
                                <div>
                                    <h4 class="font-black text-navy mb-2">Sistem Escrow Terpercaya</h4>
                                    <p class="text-sm text-gray-500 leading-relaxed">Dana Anda aman di tangan kami. Kami hanya meneruskan pembayaran ke freelancer setelah Anda puas dan menyetujui hasil pengerjaan.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="w-12 h-12 bg-orange text-white rounded-2xl flex items-center justify-center font-bold shadow-lg shadow-orange/20">2</div>
                                <div>
                                    <h4 class="font-black text-navy mb-2">Freelancer Terverifikasi</h4>
                                    <p class="text-sm text-gray-500 leading-relaxed">Setiap mitra kami melewati proses kurasi manual dan verifikasi identitas (KTP) untuk menjamin kredibilitas layanan.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center font-bold shadow-lg shadow-emerald-500/20">3</div>
                                <div>
                                    <h4 class="font-black text-navy mb-2">Fokus Lokal (UMKM)</h4>
                                    <p class="text-sm text-gray-500 leading-relaxed">Kami mengerti kebutuhan bisnis lokal. Tersedia berbagai metode pembayaran Indonesia seperti QRIS, DANA, dan Transfer Bank.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80" class="rounded-[40px] shadow-2xl scale-105">
                        <div class="absolute -bottom-10 -left-10 bg-white p-8 rounded-[30px] shadow-2xl border border-gray-100">
                            <p class="text-5xl font-black text-navy tracking-tighter">10k+</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">UMKM Aktif Bergabung</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="eksplor-jasa" class="py-32 px-6 bg-white">
                <?php include "pages/marketplace.php"; ?>
            </section>

            <section class="py-24 px-6">
                <div class="max-w-6xl mx-auto cta-box p-12 md:p-24 text-center text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-4xl md:text-5xl font-black mb-8 leading-tight">Siap Memajukan Bisnis Anda?</h2>
                        <p class="text-gray-300 max-w-2xl mx-auto mb-14 text-lg font-medium opacity-90">Bergabunglah sekarang dan temukan partner branding terbaik untuk mewujudkan identitas brand impian Anda.</p>
                        <a href="login.php" class="inline-block bg-orange text-white px-14 py-6 rounded-[22px] font-black text-sm uppercase tracking-widest shadow-2xl shadow-orange/30 hover:scale-105 transition-all">Daftar Gratis Sekarang</a>
                    </div>
                    <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-24 -mb-24"></div>
                </div>
            </section>

        <?php else: ?>
            <div class="py-10">
                <?php 
                $page = $_GET['page'];
                if(file_exists("pages/$page.php")) {
                    include "pages/$page.php";
                } else {
                    echo "<div class='text-center py-20 font-bold'>Halaman tidak ditemukan.</div>";
                }
                ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-white pt-32 pb-12 px-6 border-t border-gray-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16 mb-24">
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <img src="uploads/logo.png" class="w-10 h-10 object-contain">
                    <div class="leading-none">
                        <span class="text-lg font-black block tracking-tight text-navy uppercase">Sobat</span>
                        <span class="text-lg font-black block tracking-tight text-orange -mt-1 uppercase">Branding</span>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">Platform marketplace jasa digital terpercaya untuk UMKM Indonesia. Menghubungkan kreativitas dengan peluang bisnis.</p>
            </div>
            <div>
                <h4 class="font-black text-navy mb-8 uppercase text-xs tracking-[2px]">Marketplace</h4>
                <ul class="space-y-4 text-sm font-bold text-gray-400">
                    <li><a href="#eksplor-jasa" class="hover:text-orange transition-all">Cari Jasa</a></li>
                    <li><a href="index.php?page=sejarah" class="hover:text-orange transition-all">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-orange transition-all">Panduan Keamanan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-black text-navy mb-8 uppercase text-xs tracking-[2px]">Hubungi Kami</h4>
                <ul class="space-y-5 text-sm font-bold text-gray-400">
                    <li class="flex items-center gap-3">
                        <span class="text-orange text-lg">📍</span> Tasikmalaya, Indonesia
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-orange text-lg">📧</span> ar.hdyt2003@gmail.com
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-orange text-lg">📞</span> 085945626152
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="font-black text-navy mb-8 uppercase text-xs tracking-[2px]">Metode Pembayaran</h4>
                <div class="flex flex-wrap gap-3 mt-2">
                    <span class="px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-[10px] font-black text-navy tracking-widest">QRIS</span>
                    <span class="px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-[10px] font-black text-navy tracking-widest">BCA</span>
                    <span class="px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-[10px] font-black text-navy tracking-widest">DANA</span>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-10 border-t border-gray-100 text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[5px]">&copy; 2026 SOBATBRANDING. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownContent');
            dropdown.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('#userDropdown')) {
                const dropdown = document.getElementById('dropdownContent');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>