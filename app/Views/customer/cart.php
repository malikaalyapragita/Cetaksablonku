<?= $this->extend('customer/layout') ?>
<?= $this->section('title') ?>Keranjang<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .qty-wrap { display:flex; align-items:center; gap:4px; }
    .qty-wrap button { width:30px; height:30px; border:1px solid #d1d5db; background:#f9fafb; border-radius:6px; font-size:16px; cursor:pointer; line-height:1; }
    .qty-wrap button:hover { background:#e5e7eb; }
    .qty-wrap input { width:44px; text-align:center; border:1px solid #d1d5db; border-radius:6px; height:30px; font-weight:600; }
</style>

<h5 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h5>

<?php if (!empty($cart)): ?>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <table class="table align-middle border-bottom mb-4">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; foreach ($cart as $id => $item):
                    $subtotal = $item['harga'] * $item['qty'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td class="fw-semibold">
                        <?php if (!empty($item['foto'])): ?>
                            <img src="<?= base_url('uploads/'.$item['foto']) ?>" style="width:36px;height:36px;object-fit:cover;border-radius:6px;margin-right:8px;">
                        <?php endif; ?>
                        <?= esc($item['nama_produk']) ?>
                    </td>
                    <td class="text-muted">Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td>
                        <div class="qty-wrap">
                            <form method="POST" action="<?= base_url('customer/cart/update') ?>">
                                <input type="hidden" name="id" value="<?= esc($id) ?>">
                                <input type="hidden" name="qty" value="<?= $item['qty'] - 1 ?>">
                                <button type="submit">−</button>
                            </form>
                            <span style="min-width:28px;text-align:center;font-weight:600;"><?= $item['qty'] ?></span>
                            <form method="POST" action="<?= base_url('customer/cart/update') ?>">
                                <input type="hidden" name="id" value="<?= esc($id) ?>">
                                <input type="hidden" name="qty" value="<?= $item['qty'] + 1 ?>">
                                <button type="submit">+</button>
                            </form>
                        </div>
                    </td>
                    <td class="text-end fw-bold text-success">Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('customer/cart/remove/'.$id) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Hapus produk ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <a href="<?= base_url('customer/katalog') ?>" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Lanjut Belanja
            </a>
            <div class="text-end">
                <p class="mb-1 text-muted small">Total Pembayaran</p>
                <h4 class="fw-bold text-success mb-3">Rp<?= number_format($total, 0, ',', '.') ?></h4>
                <a href="<?= base_url('customer/checkout') ?>" class="btn btn-primary px-5">
                    <i class="bi bi-check-circle me-1"></i>Checkout Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<div class="card border-0 shadow-sm text-center py-5">
    <div class="card-body">
        <i class="bi bi-cart-x" style="font-size:3rem;color:#d1d5db;"></i>
        <h5 class="text-muted mt-3">Keranjang masih kosong</h5>
        <p class="text-muted mb-4">Belum ada produk yang ditambahkan.</p>
        <a href="<?= base_url('customer/katalog') ?>" class="btn btn-outline-primary">Mulai Belanja</a>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
