<?php
$session     = session();
$saldo       = $session->get('saldo') ?? 0;
$p           = $produk ?? [];
if (is_object($p)) $p = (array) $p;

$nama_produk = $p['nama_produk'] ?? 'Tanpa Nama';
$harga       = (int) ($p['harga'] ?? 0);
$foto        = $p['foto'] ?? null;
$deskripsi   = $p['deskripsi'] ?? '';
$stok        = (int) ($p['stok'] ?? 0);
$main_image  = $foto ? base_url('uploads/' . $foto) : null;

if (!function_exists('rupiah')) {
    function rupiah($n) { return 'Rp ' . number_format($n, 0, ',', '.'); }
}
?>
<?= $this->extend('customer/layout') ?>
<?= $this->section('title') ?>Detail Produk<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    :root { --green:#16a34a; --green-dark:#15803d; --green-light:#ecfdf5; --blue:#2563eb; --blue-dark:#1d4ed8; --text-dark:#1f2937; --text-muted:#6b7280; --border:#e2e8f0; --radius:20px; --shadow:0 4px 14px rgba(0,0,0,.06); }
    .pd-wrap { display:flex; gap:20px; align-items:flex-start; }

    .product-viewer { flex:1; background:#fff; border-radius:var(--radius); padding:28px; box-shadow:var(--shadow); }
    .main-image-box { background:#f8fafc; border-radius:16px; min-height:360px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .main-image-box img { max-width:100%; max-height:360px; object-fit:contain; border-radius:12px; }
    .img-placeholder { display:flex; flex-direction:column; align-items:center; gap:10px; color:#94a3b8; font-size:13px; }
    .img-placeholder svg { opacity:.4; }

    .product-details-form { flex:1.4; background:#fff; border-radius:var(--radius); padding:32px; box-shadow:var(--shadow); }
    .product-title { font-size:22px; font-weight:700; margin-bottom:10px; text-transform:uppercase; color:#111827; line-height:1.3; }
    .product-price { font-size:26px; font-weight:700; color:var(--green); margin-bottom:12px; }
    .stok-row { font-size:13px; color:var(--text-muted); margin-bottom:26px; }
    .stok-row strong { color:var(--text-dark); }
    .desc-text { font-size:14px; color:#4b5563; margin-bottom:24px; line-height:1.6; }

    .qty-action-row { display:flex; align-items:center; gap:12px; margin-top:8px; }
    .qty-picker { display:flex; align-items:center; border:1px solid var(--border); border-radius:10px; overflow:hidden; height:46px; }
    .qty-btn { width:40px; height:100%; border:none; background:transparent; font-size:18px; cursor:pointer; font-weight:600; color:#4b5563; }
    .qty-btn:hover { background:#f1f5f9; }
    .qty-input { width:44px; text-align:center; border:none; font-weight:700; font-size:15px; color:var(--text-dark); height:100%; outline:none; }
    .btn-primary-cart { flex:1; height:46px; background:var(--blue); color:#fff; border:none; border-radius:10px; font-weight:600; font-size:14px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:background .15s; }
    .btn-primary-cart:hover { background:var(--blue-dark); }
    .btn-buy-now { width:100%; height:46px; border:1px solid #cbd5e1; background:#fff; border-radius:10px; font-weight:600; font-size:14px; cursor:pointer; color:#4b5563; margin-top:10px; transition:background .15s; }
    .btn-buy-now:hover { background:#f8fafc; }
    .estimasi-row { margin-top:20px; font-size:12px; color:var(--text-muted); font-weight:600; }
    .estimasi-row span { color:var(--text-dark); }

    .right-sidebar { width:280px; flex-shrink:0; display:flex; flex-direction:column; gap:20px; }
    .widget-card { background:#fff; border-radius:var(--radius); box-shadow:var(--shadow); padding:22px; }
    .widget-card h3 { margin-bottom:12px; font-size:14px; font-weight:700; color:#1f2937; }
    .favorit-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
    .favorit-item { text-align:center; padding:14px 6px; border-radius:12px; font-size:12px; font-weight:600; color:#4b5563; display:flex; flex-direction:column; align-items:center; gap:6px; }
    .promo-card { background:var(--green); border-radius:var(--radius); padding:22px; color:#fff; box-shadow:var(--shadow); }
    .promo-card h4 { font-size:15px; font-weight:700; line-height:1.5; }

    .modal-overlay { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.45); z-index:1050; display:none; align-items:center; justify-content:center; backdrop-filter:blur(3px); }
    .modal-box { background:#fff; width:460px; border-radius:24px; padding:30px; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; animation:popIn .25s ease-out; }
    @keyframes popIn { from{transform:scale(.92);opacity:0} to{transform:scale(1);opacity:1} }
    .modal-icon { width:56px; height:56px; background:#dcfce7; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
    .modal-title { font-size:20px; font-weight:700; color:#111827; margin-bottom:6px; }
    .modal-subtitle { font-size:14px; color:var(--text-muted); margin-bottom:22px; line-height:1.5; }
    .modal-product-card { display:flex; gap:14px; background:#f8fafc; border-radius:14px; padding:14px; text-align:left; margin-bottom:22px; border:1px solid #f1f5f9; }
    .modal-product-thumb { width:76px; height:76px; background:#fff; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; }
    .modal-product-thumb img { width:100%; height:100%; object-fit:contain; }
    .modal-product-info { display:flex; flex-direction:column; gap:4px; justify-content:center; }
    .modal-p-name { font-weight:700; font-size:13px; color:#111827; text-transform:uppercase; line-height:1.3; }
    .modal-p-meta { font-size:12px; color:#4b5563; }
    .modal-p-meta span { font-weight:700; color:#111827; }
    .modal-buttons-row { display:flex; gap:10px; }
    .btn-modal-secondary { flex:1; padding:13px 0; border:1px solid #cbd5e1; background:#fff; border-radius:12px; font-weight:600; font-size:14px; cursor:pointer; color:#4b5563; }
    .btn-modal-secondary:hover { background:#f8fafc; }
    .btn-modal-primary { flex:1; padding:13px 0; background:var(--blue); color:#fff; border:none; border-radius:12px; font-weight:600; font-size:14px; cursor:pointer; }
    .btn-modal-primary:hover { background:var(--blue-dark); }
</style>

<?php
$favorit_layanan = [
    ['icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>', 'label' => 'T-Shirt', 'color' => '#dcfce7'],
    ['icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>', 'label' => 'Hoodie', 'color' => '#fef9c3'],
    ['icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>', 'label' => 'Printing', 'color' => '#dbeafe'],
];
?>

<div class="pd-wrap">

    <!-- PRODUCT VIEWER -->
    <section class="product-viewer">
        <div class="main-image-box">
            <?php if ($main_image): ?>
                <img src="<?= $main_image ?>" alt="<?= esc($nama_produk) ?>">
            <?php else: ?>
                <div class="img-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    <span>Gambar belum tersedia</span>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FORM DETAIL PRODUK -->
    <section class="product-details-form">
        <h1 class="product-title"><?= esc($nama_produk) ?></h1>
        <div class="product-price" id="prodPrice"><?= rupiah($harga) ?></div>
        <div class="stok-row">Stok: <strong><?= $stok > 0 ? $stok . ' tersedia' : 'Habis' ?></strong></div>
        <?php if (!empty($deskripsi)): ?>
            <div class="desc-text"><?= esc($deskripsi) ?></div>
        <?php endif; ?>

        <div class="qty-action-row">
            <div class="qty-picker">
                <button class="qty-btn" onclick="changeQty(-1)">−</button>
                <input type="text" class="qty-input" id="quantityInput" value="1" readonly>
                <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>
            <button class="btn-primary-cart" onclick="triggerCartModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                Tambah ke Keranjang
            </button>
        </div>
        <button class="btn-buy-now" onclick="triggerCartModal()">Beli Sekarang</button>
        <div class="estimasi-row">ESTIMASI SELESAI: <span>2-3 Hari Kerja</span></div>
    </section>

    <!-- SIDEBAR KANAN -->
    <aside class="right-sidebar">
        <div class="widget-card">
            <h3>Layanan Favorit</h3>
            <div class="favorit-grid">
                <?php foreach ($favorit_layanan as $f): ?>
                    <div class="favorit-item" style="background:<?= $f['color'] ?>;"><?= $f['icon_svg'] ?><span><?= esc($f['label']) ?></span></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="promo-card"><h4>Promo Bantu Penjualan,<br>Cek Sekarang! ✨</h4></div>
    </aside>

</div>

<!-- MODAL KERANJANG -->
<div class="modal-overlay" id="cartModalOverlay">
    <div class="modal-box">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="modal-title">Berhasil Ditambahkan!</div>
        <div class="modal-subtitle">Produk berikut telah ditambahkan ke keranjang belanja Anda.</div>
        <div class="modal-product-card">
            <div class="modal-product-thumb">
                <?php if ($main_image): ?>
                    <img src="<?= $main_image ?>" alt="thumb">
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                <?php endif; ?>
            </div>
            <div class="modal-product-info">
                <div class="modal-p-name"><?= esc($nama_produk) ?></div>
                <div class="modal-p-meta">Harga: <span><?= rupiah($harga) ?></span></div>
                <div class="modal-p-meta">Jumlah: <span id="modalSelectedQty">1</span></div>
            </div>
        </div>
        <div class="modal-buttons-row">
            <button class="btn-modal-secondary" onclick="window.location.href='<?= base_url('customer/cart') ?>'">Lihat Keranjang</button>
            <button class="btn-modal-primary" onclick="closeCartModal()">Lanjut Belanja</button>
        </div>
    </div>
</div>

<script>
function changeQty(amount) {
    const input = document.getElementById('quantityInput');
    let val = parseInt(input.value) + amount;
    if (val < 1) val = 1;
    input.value = val;
}
function triggerCartModal() {
    const qty = document.getElementById('quantityInput').value;
    const fd  = new FormData();
    fd.append('id',         '<?= $p['id'] ?>');
    fd.append('nama_produk','<?= addslashes($nama_produk) ?>');
    fd.append('harga',      '<?= $harga ?>');
    fd.append('qty',        qty);
    fd.append('foto',       '<?= $foto ?? '' ?>');
    fetch('<?= base_url('customer/cart/add') ?>', {method:'POST', body:fd})
        .then(r => r.json())
        .then(() => {
            document.getElementById('modalSelectedQty').innerText = qty;
            document.getElementById('cartModalOverlay').style.display = 'flex';
        })
        .catch(() => alert('Gagal menambahkan ke keranjang.'));
}
function closeCartModal() { document.getElementById('cartModalOverlay').style.display = 'none'; }
document.getElementById('cartModalOverlay').addEventListener('click', function(e) { if(e.target===this) closeCartModal(); });
</script>

<?= $this->endSection() ?>
