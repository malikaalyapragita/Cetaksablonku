<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<style>
    .form-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #eee; max-width: 720px; }
    .upload-box {
        border: 2px dashed #d1d5db; border-radius: 10px; padding: 28px;
        text-align: center; background: #f9fafb; cursor: pointer;
    }
    .upload-box:hover { border-color: var(--brand-green); }
    .color-swatch {
        width: 32px; height: 32px; border-radius: 50%; border: 2px solid #e5e7eb;
        cursor: pointer; display: inline-block;
    }
    .color-swatch.active { border-color: var(--brand-green); box-shadow: 0 0 0 2px var(--brand-green); }
    .qty-control {
        display: inline-flex; align-items: center; border: 1px solid #d1d5db;
        border-radius: 8px; overflow: hidden;
    }
    .qty-control button { background: #f1f5f9; border: none; width: 36px; height: 38px; font-size: 1rem; }
    .qty-control input { width: 50px; border: none; text-align: center; font-weight: 600; }
    .delivery-option {
        border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 16px;
        cursor: pointer; text-align: center;
    }
    .delivery-option.active { background: #e9f8ef; border-color: var(--brand-green); color: var(--brand-green); font-weight: 600; }
</style>

<h4 class="fw-bold mb-1">Halo, <?= session()->get('username') ?? 'Customer' ?>!</h4>
<h5 class="fw-bold mb-4">Silakan Buat Pesanan Baru</h5>

<div class="row">
    <div class="col-lg-8">
        <form action="<?= base_url('customer/pesanan/baru/process') ?>" method="POST" enctype="multipart/form-data" class="form-card">
            <?= csrf_field() ?>

            <label class="form-label fw-semibold">Unggah Desain Sablon</label>
            <div class="upload-box mb-2" onclick="document.getElementById('fileDesain').click()">
                <i class="bi bi-cloud-arrow-up fs-3 text-secondary"></i>
                <div class="fw-semibold mt-1" id="fileLabel">Pilih File</div>
            </div>
            <input type="file" id="fileDesain" name="desain" accept=".ai,.psd,.pdf,.png" hidden
                   onchange="document.getElementById('fileLabel').innerText = this.files[0]?.name || 'Pilih File'">
            <p class="text-muted small mb-4">Jenis file: AI, PSD, PDF, PNG (min 300dpi)</p>

            <label class="form-label fw-semibold">Detail Pesanan</label>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Jenis Pakaian</label>
                    <select name="jenis_pakaian" class="form-select">
                        <option>T-Shirt</option>
                        <option>Hoodie</option>
                        <option>Tote Bag</option>
                        <option>Kemeja</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted d-block">Warna Pakaian</label>
                    <div class="d-flex gap-2 pt-1">
                        <span class="color-swatch active" style="background:#fff;" data-color="putih"></span>
                        <span class="color-swatch" style="background:#1d4ed8;" data-color="biru"></span>
                        <span class="color-swatch" style="background:#16a34a;" data-color="hijau"></span>
                        <span class="color-swatch" style="background:#dc2626;" data-color="merah"></span>
                    </div>
                    <input type="hidden" name="warna" id="warnaInput" value="putih">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">Jumlah Pesanan (Pcs)</label>
                    <div class="qty-control">
                        <button type="button" onclick="ubahQty(-1)">−</button>
                        <input type="number" name="jumlah" id="qtyInput" value="1" min="1" readonly>
                        <button type="button" onclick="ubahQty(1)">+</button>
                    </div>
                </div>
            </div>

            <label class="form-label fw-semibold">Tambahan Instruksi</label>
            <textarea name="instruksi" class="form-control mb-4" rows="3" placeholder="Berikan catatan atau instruksi khusus untuk kami..."></textarea>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Metode Pengiriman</label>
                    <div class="delivery-option active" id="opsiKurir" onclick="pilihKirim('kurir')">Kurir Lokal</div>
                    <input type="hidden" name="metode_kirim" id="metodeKirimInput" value="kurir">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold d-block">&nbsp;</label>
                    <select name="ekspedisi" class="form-select">
                        <option>Ekspedisi Nasional</option>
                        <option>JNE</option>
                        <option>J&T</option>
                        <option>SiCepat</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Detail Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Detail Alamat" required>
                </div>
            </div>

            <button type="submit" class="btn w-100 text-white" style="background:#2563eb; border-radius:8px; padding:12px;">
                <i class="bi bi-download"></i> Lanjutkan ke Konfirmasi Pesanan
            </button>
        </form>
    </div>

    <div class="col-lg-4">
        <div style="background:#fff;border-radius:12px;padding:18px;border:1px solid #eee;">
            <p class="text-muted mb-1 small">Saldo Saya</p>
            <div style="font-size:1.6rem;font-weight:700;">Rp. <?= number_format(0) ?></div>
            <a class="btn w-100 mt-2 disabled" style="background:#d1d5db;color:#6b7280;border-radius:8px;cursor:not-allowed;">
                Isi Ulang
            </a>
        </div>
    </div>
</div>

<script>
    function ubahQty(delta) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
    }

    document.querySelectorAll('.color-swatch').forEach(el => {
        el.addEventListener('click', () => {
            document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('warnaInput').value = el.dataset.color;
        });
    });

    function pilihKirim(val) {
        document.getElementById('metodeKirimInput').value = val;
    }
</script>

<?= $this->endSection() ?>