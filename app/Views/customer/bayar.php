<?= $this->extend('customer/customer_template') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-credit-card fs-3 text-primary me-3"></i>
        <h2 class="fw-bold mb-0">Pembayaran Pesanan #<?= esc($order['id']) ?></h2>
    </div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
            <p class="mb-1"><span class="text-muted">Status:</span> <span class="badge bg-warning text-dark text-capitalize"><?= esc($order['status_order']) ?></span></p>
            <p class="mb-0"><span class="text-muted">Total Pembayaran:</span> <strong class="text-success fs-5">Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></strong></p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Upload Bukti Transfer</h5>
            <p class="text-muted small mb-4">Silakan transfer ke rekening toko, lalu upload foto/screenshot bukti transfer di bawah ini.</p>

            <form action="<?= base_url('customer/bayar/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="form-label fw-semibold">File Bukti Transfer</label>
                    <input type="file" name="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                    <div class="form-text">Format: JPG, PNG, atau PDF. Maks 10MB.</div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                    <i class="bi bi-upload me-2"></i> Kirim Bukti Pembayaran
                </button>
            </form>
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="<?= base_url('customer/riwayat') ?>" class="text-muted small">← Kembali ke Riwayat Pesanan</a>
    </div>
</div>
<?= $this->endSection() ?>
