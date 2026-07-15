<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= base_url('admin/order') ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    <h5 class="fw-bold mb-0">Tambah Order Manual</h5>
</div>

<div class="card border-0 shadow-sm p-4" style="max-width:560px;">
    <form action="<?= base_url('admin/order/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold small">Pelanggan <span class="text-danger">*</span></label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php foreach ($customers ?? [] as $c): ?>
                <option value="<?= $c['id'] ?>" <?= old('customer_id') == $c['id'] ? 'selected' : '' ?>>
                    <?= esc($c['username']) ?> — <?= esc($c['email']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small">Produk <span class="text-danger">*</span></label>
            <select name="produk_id" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                <?php foreach ($produk ?? [] as $p): ?>
                <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga'] ?>" <?= old('produk_id') == $p['id'] ? 'selected' : '' ?>>
                    <?= esc($p['nama_produk']) ?> — Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small">Jumlah <span class="text-danger">*</span></label>
            <input type="number" name="jumlah" class="form-control" value="<?= old('jumlah', 1) ?>" min="1" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold small">Total Harga (Rp)</label>
            <input type="number" name="total_harga" id="totalHarga" class="form-control" value="<?= old('total_harga', 0) ?>" min="0" step="1">
            <div class="form-text">Otomatis terhitung, atau isi manual untuk override.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success flex-fill">
                <i class="bi bi-check-lg me-1"></i>Simpan Order
            </button>
            <a href="<?= base_url('admin/order') ?>" class="btn btn-outline-secondary flex-fill">Batal</a>
        </div>
    </form>
</div>

<script>
const produkSelect = document.querySelector('[name="produk_id"]');
const jumlahInput  = document.querySelector('[name="jumlah"]');
const totalInput   = document.getElementById('totalHarga');

function hitungTotal() {
    const harga  = parseInt(produkSelect.selectedOptions[0]?.dataset.harga || 0);
    const jumlah = parseInt(jumlahInput.value || 1);
    totalInput.value = harga * jumlah;
}

produkSelect.addEventListener('change', hitungTotal);
jumlahInput.addEventListener('input', hitungTotal);
</script>

<?= $this->endSection() ?>
