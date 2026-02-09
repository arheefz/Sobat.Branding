<?php
// 1. Ambil ID dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

// 2. Query ke Database
$data = null;
if ($id) {
    // Gue tambahin 'user_id' di query biar kita tau siapa penjualnya
    $query = mysqli_query($conn, "SELECT * FROM services WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
}

// 3. Jika data tidak ada, tampilkan pesan error yang rapi
if (!$data) {
?>
    <div class="py-40 text-center">
        <h2 class="text-2xl font-black text-slate-300 uppercase italic">Produk Tidak Ditemukan</h2>
        <a href="index.php" class="mt-6 inline-block bg-[#1a365d] text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest">Kembali ke Beranda</a>
    </div>
<?php
    return; // Stop eksekusi script di sini
}

// Persiapkan ID Penjual untuk fitur Chat
// Pastikan di tabel 'services' lo ada kolom yang menyimpan ID user/penjual
$id_penjual = $data['user_id'] ?? 1; // Default ke 1 kalau kolom belum ada (buat testing)
?>

<div class="bg-slate-50/30 min-h-screen pb-20">
    <nav class="max-w-7xl mx-auto px-6 py-8">
        <a href="index.php?page=marketplace" class="flex items-center gap-2 text-slate-400 hover:text-[#1a365d] transition-all font-black text-[10px] uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Marketplace
        </a>
    </nav>

    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row gap-12">
        <div class="lg:w-2/3 space-y-10">
            <div class="space-y-4">
                <div class="flex gap-2">
                    <span class="px-4 py-1.5 bg-orange-50 text-[#f38d2c] text-[9px] font-black uppercase tracking-widest rounded-lg border border-orange-100">Hot Deals</span>
                    <span class="px-4 py-1.5 bg-blue-50 text-[#1a365d] text-[9px] font-black uppercase tracking-widest rounded-lg border border-blue-100"><?= htmlspecialchars($data['category']) ?></span>
                </div>
                <h1 class="text-4xl font-black text-[#1a365d] italic tracking-tighter leading-[1.1]">
                    <?= htmlspecialchars($data['title']) ?>
                </h1>
                
                <div class="flex items-center gap-4 pt-2">
                    <div class="w-12 h-12 rounded-2xl bg-[#1a365d] flex items-center justify-center text-white font-black italic shadow-lg">SB</div>
                    <div>
                        <p class="text-sm font-bold text-[#1a365d]">Partner SobatBranding</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-orange-400 text-xs">★</span>
                            <span class="text-[11px] font-black text-[#1a365d]"><?= $data['rating'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[48px] overflow-hidden shadow-2xl shadow-blue-100/50 border-8 border-white bg-white">
                <img src="<?= $data['image'] ?>" class="w-full aspect-video object-cover">
            </div>

            <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm">
                <h2 class="text-xl font-black text-[#1a365d] italic mb-6">Deskripsi Layanan</h2>
                <p class="text-slate-500 font-bold leading-relaxed">
                    <?= nl2br(htmlspecialchars($data['description'] ?? 'Layanan profesional dengan hasil pengerjaan terbaik untuk kebutuhan brand Anda.')) ?>
                </p>
            </div>
        </div>

        <div class="lg:w-1/3">
            <div class="sticky top-10 bg-white rounded-[40px] border border-slate-100 shadow-2xl shadow-blue-100/30 overflow-hidden">
                <div class="flex border-b border-slate-50 bg-[#1a365d]">
                    <button class="flex-1 py-6 text-[10px] font-black uppercase tracking-[2px] text-white">Paket Standar</button>
                </div>

                <div class="p-10 space-y-8">
                    <div>
                        <p class="text-[10px] font-black text-orange-400 uppercase tracking-[3px] mb-2">Harga Jasa</p>
                        <h3 class="text-4xl font-black text-[#1a365d] italic tracking-tighter">
                            Rp<?= number_format($data['price'], 0, ',', '.') ?>
                        </h3>
                    </div>

                    <div class="space-y-3 pt-4">
                        <a href="index.php?page=checkout&id=<?= $data['id'] ?>" class="block text-center w-full bg-[#f38d2c] text-white font-black py-5 rounded-2xl shadow-xl shadow-orange-100 hover:scale-105 transition-all uppercase tracking-[2px] text-xs active:scale-95">
                            Pesan Sekarang
                        </a>

                        <a href="chat.php?lawan_chat=<?= $id_penjual ?>" class="flex items-center justify-center w-full bg-white border-2 border-slate-100 text-[#1a365d] font-black py-5 rounded-2xl hover:bg-slate-50 transition-all uppercase tracking-[2px] text-xs">
                            Hubungi Penjual
                        </a>
                    </div>

                    <p class="text-[9px] font-black text-slate-300 text-center uppercase tracking-[1px] pt-4">
                        Escrow System: Dana aman & Terjamin
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>