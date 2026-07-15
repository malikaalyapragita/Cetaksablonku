<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<style>
    .sort-select { border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 12px; font-size: 0.88rem; }
    .view-toggle { color: #475569; font-size: 0.88rem; text-decoration: none; }
    .product-card { background: #fff; border-radius: 10px; overflow: hidden; border: 1px solid #eee; transition: box-shadow .2s; }
    .product-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,.08); }
    .product-img-wrap {
        position: relative; background: #f1f3f5; height: 150px;
        display: flex; align-items: center; justify-content: center;
    }
    .product-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .img-placeholder {
        width: 100%; height: 100%; display: flex; align-items: center;
        justify-content: center; color: #9ca3af; font-size: 2rem;
    }
    .wishlist-btn {
        position: absolute; top: 8px; right: 8px; width: 30px; height: 30px;
        background: #fff; border-radius: 50%; display: flex; align-items: center;
        justify-content: center; box-shadow: 0 1px 4px rgba(0,0,0,.15); color: #9ca3af;
        border: none; cursor: pointer;
    }
    .cart-icon-overlay {
        position: absolute; bottom: -14px; left: 12px; width: 34px; height: 34px;
        background: #fff; border-radius: 8px; display: flex; align-items: center;
        justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,.12); color: #475569;
        text-decoration: none; border: none; cursor: pointer;
    }
    .cart-icon-overlay:hover { background: #f1f5f9; color: #16a34a; }
    .product-body { padding: 16px 14px 14px; }
    .product-name { font-size: 0.92rem; font-weight: 500; color: #1f2937; }
    .product-price { font-weight: 700; color: #111827; font-size: 0.95rem; }
    .btn-detail-product {
        background: #fff; border: 1px solid #d1d5db; color: #374151;
        border-radius: 16px; padding: 3px 14px; font-size: 0.78rem; text-decoration: none;
    }
    .side-card { background: #fff; border-radius: 12px; padding: 18px; border: 1px solid #eee; }
    .saldo-amount { font-size: 1.6rem; font-weight: 700; color: #111827; }
    .layanan-icon {
        width: 50px; height: 50px; border-radius: 10px; background: #f1f5f9;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        margin: 0 auto 6px;
    }
    .promo-card { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 16px; }
    .promo-badge {
        background: #fff; border-radius: 14px; padding: 2px 10px; font-size: 0.75rem;
        display: inline-flex; align-items: center; gap: 4px; color: #16a34a; font-weight: 600;
    }
</style>

<div class="row">
    <!-- Kolom kiri: produk -->
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Produk Spesial Untukmu</h5>
            <div class="d-flex align-items-center gap-3">
                <select class="sort-select">
                    <option>Urutkan: Populer</option>
                    <option>Urutkan: Termurah</option>
                    <option>Urutkan: Terbaru</option>
                </select>
                <a href="#" class="view-toggle"><i class="bi bi-list"></i> Daftar</a>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach($produk ?? [] as $p): ?>
            <div class="col-md-4">
                <div class="product-card">
                    <div class="product-img-wrap">
                        <?php if(!empty($p['foto'])): ?>
                            <img src="<?= base_url('uploads/' . $p['foto']) ?>"
                                 alt="<?= esc($p['nama_produk'] ?? '') ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="img-placeholder" style="display:none;"><i class="bi bi-image"></i></div>
                        <?php else: ?>
                            <div class="img-placeholder"><i class="bi bi-image"></i></div>
                        <?php endif; ?>
                        <button type="button" class="wishlist-btn" title="Simpan ke Favorit">
                            <i class="bi bi-heart"></i>
                        </button>
                        <a href="<?= base_url('customer/product-detail/' . ($p['id'] ?? '')) ?>"
                           class="cart-icon-overlay" title="Lihat & Tambah ke Keranjang">
                            <i class="bi bi-cart3"></i>
                        </a>
                    </div>
                    <div class="product-body d-flex justify-content-between align-items-end pt-3">
                        <div>
                            <div class="product-name"><?= esc($p['nama_produk'] ?? '-') ?></div>
                            <div class="product-price">Rp. <?= number_format($p['harga'] ?? 0) ?></div>
                        </div>
                        <a href="<?= base_url('customer/product-detail/' . ($p['id'] ?? '')) ?>"
                           class="btn-detail-product">Detail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Kolom kanan -->
    <div class="col-lg-4">
        <div class="side-card mb-3">
            <p class="text-muted mb-1 small">Saldo Saya</p>
            <div class="saldo-amount mb-3">Rp. <?= number_format($saldo ?? 0) ?></div>
            <button class="btn w-100 disabled" style="background:#d1d5db;color:#6b7280;border-radius:8px;cursor:not-allowed;">
                Isi Ulang (Segera Hadir)
            </button>
        </div>

        <div class="side-card mb-3">
            <p class="fw-semibold mb-3">Layanan Favorit</p>
            <div class="row text-center">
                <div class="col-4">
                    <div class="layanan-icon"><i class="bi bi-tshirt"></i></div>
                    <small>T-Shirt</small>
                </div>
                <div class="col-4">
                    <div class="layanan-icon"><i class="bi bi-bag"></i></div>
                    <small>Hoodie</small>
                </div>
                <div class="col-4">
                    <div class="layanan-icon"><i class="bi bi-droplet"></i></div>
                    <small>Printing</small>
                </div>
            </div>
        </div>

        <div class="promo-card">
            <span class="promo-badge"><i class="bi bi-printer-fill"></i> CetakApp</span>
            <p class="fw-semibold mt-2 mb-0">Promo Bantu Penjualan, Cek Sekarang! ✨</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>