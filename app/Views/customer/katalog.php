<?= $this->extend('customer/layout') ?>
<?= $this->section('title') ?>Katalog<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php
$username = session()->get('username') ?? 'Customer';
$produk   = $produk ?? [];
$kategori = $kategori ?? [];
?>

<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px 24px;margin-bottom:20px;">
    <div style="font-size:19px;font-weight:700;color:#111827;margin-bottom:4px;">Halo, <?= esc($username) ?>! 👋</div>
    <div style="font-size:13px;color:#6b7280;">Temukan produk sablon terbaik untuk Anda.</div>
</div>

<!-- Filter Kategori -->
<div style="display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:20px;">
    <span style="font-size:14px;font-weight:600;color:#4b5563;">Kategori:</span>
    <button onclick="filterKat('semua',this)" class="tab-kat active-kat"
        style="padding:8px 20px;border-radius:50px;border:1px solid #16a34a;background:#16a34a;color:#fff;font-size:13px;font-weight:600;cursor:pointer;">
        Semua
    </button>
    <?php foreach ($kategori as $k): ?>
    <button onclick="filterKat('<?= esc($k['nama_kategori']) ?>',this)" class="tab-kat"
        style="padding:8px 20px;border-radius:50px;border:1px solid #dee2e6;background:#fff;color:#495057;font-size:13px;font-weight:500;cursor:pointer;">
        <?= esc($k['nama_kategori']) ?>
    </button>
    <?php endforeach; ?>
</div>

<div style="font-size:17px;font-weight:700;color:#111827;margin-bottom:16px;">Daftar Produk</div>

<!-- Grid Produk -->
<div id="produk-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">
    <?php if (!empty($produk)): ?>
        <?php foreach ($produk as $p): ?>
        <div class="produk-card" data-kat="<?= esc($p['nama_kategori'] ?? 'semua') ?>"
             style="background:#fff;border-radius:16px;box-shadow:0 4px 12px rgba(0,0,0,0.04);padding:20px;display:flex;flex-direction:column;justify-content:space-between;transition:transform 0.2s;"
             onmouseover="this.style.transform='translateY(-2px)'"
             onmouseout="this.style.transform=''">

            <a href="<?= base_url('customer/product-detail/'.$p['id']) ?>"
               style="display:flex;align-items:center;justify-content:center;height:140px;background:#fafafa;border-radius:12px;margin-bottom:14px;text-decoration:none;overflow:hidden;">
                <?php if (!empty($p['foto'])): ?>
                    <img src="<?= base_url('uploads/'.$p['foto']) ?>" style="width:100%;height:140px;object-fit:cover;border-radius:12px;">
                <?php else: ?>
                    <span style="font-size:52px;">👕</span>
                <?php endif; ?>
            </a>

            <div>
                <?php if (!empty($p['nama_kategori'])): ?>
                <div style="font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">
                    <?= esc($p['nama_kategori']) ?>
                </div>
                <?php endif; ?>
                <div style="font-size:15px;font-weight:600;color:#212529;margin-bottom:6px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <?= esc($p['nama_produk']) ?>
                </div>
                <?php if (!empty($p['deskripsi'])): ?>
                <div style="font-size:12px;color:#9ca3af;margin-bottom:6px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <?= esc($p['deskripsi']) ?>
                </div>
                <?php endif; ?>
                <div style="font-size:18px;font-weight:700;color:#198754;margin-bottom:4px;">
                    Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                </div>
                <div style="font-size:12px;margin-bottom:14px;<?= (int)$p['stok'] > 0 ? 'color:#6b7280;' : 'color:#ef4444;font-weight:600;' ?>">
                    <?= (int)$p['stok'] > 0 ? 'Stok: ' . (int)$p['stok'] : 'Stok Habis' ?>
                </div>

                <?php if ((int)$p['stok'] > 0): ?>
                <form onsubmit="return tambahKeranjang(this)">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id"          value="<?= $p['id'] ?>">
                    <input type="hidden" name="nama_produk" value="<?= esc($p['nama_produk']) ?>">
                    <input type="hidden" name="harga"       value="<?= $p['harga'] ?>">
                    <input type="hidden" name="foto"        value="<?= $p['foto'] ?? '' ?>">
                    <input type="hidden" name="qty"         value="1">
                    <button type="submit" style="width:100%;padding:10px;background:#0d6efd;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                        + Tambah ke Keranjang
                    </button>
                </form>
                <?php else: ?>
                <button disabled style="width:100%;padding:10px;background:#e5e7eb;color:#9ca3af;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:not-allowed;">
                    Stok Habis
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column:span 3;text-align:center;padding:48px;color:#9ca3af;background:#fff;border-radius:12px;">
            <div style="font-size:40px;margin-bottom:10px;">📦</div>
            Belum ada produk tersedia.
        </div>
    <?php endif; ?>
</div>

<!-- Modal Keranjang -->
<div id="cartModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:28px;width:440px;max-width:95vw;box-shadow:0 24px 60px rgba(0,0,0,0.18);animation:popIn 0.2s ease;">
        <div style="font-size:18px;font-weight:700;color:#111827;margin-bottom:4px;">Berhasil Ditambahkan! 🎉</div>
        <div style="font-size:13px;color:#6b7280;margin-bottom:18px;">Produk telah ditambahkan ke keranjang:</div>
        <div style="display:flex;gap:14px;align-items:center;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:20px;">
            <img id="modal-img" style="width:68px;height:68px;border-radius:8px;object-fit:cover;flex-shrink:0;" src="" alt="">
            <div>
                <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:6px;" id="modal-nama"></div>
                <div style="font-size:13px;color:#374151;">Harga: <b id="modal-harga"></b></div>
                <div style="font-size:13px;color:#374151;">Jumlah: <b id="modal-qty"></b></div>
            </div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="<?= base_url('customer/cart') ?>" style="flex:1;padding:11px;border:1.5px solid #d1d5db;border-radius:8px;background:#fff;color:#374151;font-size:14px;font-weight:600;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;">
                Lihat Keranjang
            </a>
            <button onclick="tutupModal()" style="flex:1;padding:11px;border:none;border-radius:8px;background:#0d6efd;color:#fff;font-size:14px;font-weight:600;cursor:pointer;">
                Lanjut Belanja
            </button>
        </div>
    </div>
</div>

<style>
@keyframes popIn { from{transform:scale(0.92);opacity:0} to{transform:scale(1);opacity:1} }
</style>

<script>
function filterKat(kat, btn) {
    document.querySelectorAll('.tab-kat').forEach(b => {
        b.style.background = '#fff'; b.style.color = '#495057'; b.style.borderColor = '#dee2e6';
    });
    btn.style.background = '#16a34a'; btn.style.color = '#fff'; btn.style.borderColor = '#16a34a';
    document.querySelectorAll('.produk-card').forEach(c => {
        c.style.display = (kat === 'semua' || c.dataset.kat === kat) ? 'flex' : 'none';
    });
}

function tambahKeranjang(form) {
    fetch('<?= base_url('customer/cart/add') ?>', {
        method: 'POST', body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        if (!res.success) { alert('Gagal menambahkan.'); return; }
        document.getElementById('modal-nama').textContent  = res.nama_produk;
        document.getElementById('modal-harga').textContent = res.harga;
        document.getElementById('modal-qty').textContent   = res.qty;
        document.getElementById('modal-img').src           = res.foto || '';
        const badge = document.querySelector('.cart-badge');
        if (badge) badge.textContent = res.total_cart;
        else if (res.total_cart > 0) {
            const cartBtn = document.querySelector('.cart-btn');
            if (cartBtn) {
                const b = document.createElement('span');
                b.className = 'cart-badge'; b.textContent = res.total_cart;
                cartBtn.appendChild(b);
            }
        }
        document.getElementById('cartModal').style.display = 'flex';
    })
    .catch(() => alert('Terjadi kesalahan jaringan.'));
    return false;
}

function tutupModal() { document.getElementById('cartModal').style.display = 'none'; }
document.getElementById('cartModal').addEventListener('click', function(e) { if(e.target===this) tutupModal(); });
</script>

<?= $this->endSection() ?>
