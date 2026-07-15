<?= $this->extend('customer/layout') ?>
<?= $this->section('title') ?>Checkout<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>Konfirmasi Pesanan</h5>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Rincian Produk</h6>
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                        <tr>
                            <td class="fw-semibold">
                                <?php if (!empty($item['foto'])): ?>
                                    <img src="<?= base_url('uploads/'.$item['foto']) ?>" style="width:36px;height:36px;object-fit:cover;border-radius:6px;margin-right:8px;">
                                <?php endif; ?>
                                <?= esc($item['nama_produk']) ?>
                            </td>
                            <td class="text-center"><?= (int)$item['qty'] ?></td>
                            <td class="text-end text-muted">Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="text-end fw-bold">Rp<?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Ringkasan</h6>
                <div class="d-flex justify-content-between mb-2 text-muted small">
                    <span>Subtotal</span>
                    <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total</span>
                    <span class="text-success fs-5">Rp<?= number_format($total, 0, ',', '.') ?></span>
                </div>
                <form action="<?= base_url('customer/checkout/process') ?>" method="POST">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-1"></i> Konfirmasi Pesanan
                    </button>
                </form>
                <a href="<?= base_url('customer/cart') ?>" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
