<?= $this->extend('designer/layout') ?>
<?= $this->section('title') ?>Kerjakan Order<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Detail Order ORD-<?= str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?></h5>

<div class="card border-0 shadow-sm p-4" style="max-width:720px;">
    <table class="table table-sm mb-4">
        <tr><th style="width:140px">Customer ID</th><td><?= $order['customer_id'] ?></td></tr>
        <tr><th>Total</th><td>Rp <?= number_format($order['total_harga']) ?></td></tr>
        <tr><th>Tanggal</th><td><?= date('d M Y', strtotime($order['created_at'])) ?></td></tr>
        <tr><th>Status</th><td><?= ucfirst($order['status_order']) ?></td></tr>
    </table>

    <?php if (!empty($items)): ?>
    <h6 class="fw-bold mb-2">Item Produk</h6>
    <table class="table table-sm mb-4">
        <?php foreach ($items as $item): ?>
        <tr>
            <td style="width:110px;">
                <?php if (!empty($item['foto'])): ?>
                    <a href="<?= base_url('uploads/' . $item['foto']) ?>" target="_blank">
                        <img src="<?= base_url('uploads/' . $item['foto']) ?>" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                    </a>
                <?php endif; ?>
            </td>
            <td><?= esc($item['nama_produk'] ?? '-') ?></td>
            <td class="text-end">Qty <?= $item['qty'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <?php if (!empty($order['file_custom'])):
        $ext = strtolower(pathinfo($order['file_custom'], PATHINFO_EXTENSION));
        $fileUrl = base_url('uploads/desain/' . $order['file_custom']);
    ?>
    <h6 class="fw-bold mb-2">File Desain Customer</h6>
    <div class="mb-4">
        <?php if (in_array($ext, ['png', 'jpg', 'jpeg'])): ?>
            <a href="<?= $fileUrl ?>" target="_blank">
                <img src="<?= $fileUrl ?>" class="img-fluid rounded border">
            </a>
            <div class="small text-muted mt-1">Klik gambar untuk lihat ukuran penuh</div>
        <?php else: ?>
            <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-file-earmark-arrow-down"></i> Download File Desain
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div id="kerjakan-btn">
        <button type="button" class="btn btn-success" onclick="document.getElementById('kerjakan-btn').style.display='none';document.getElementById('upload-form').style.display='block';">Kerjakan</button>
        <a href="<?= base_url('designer/desain-masuk') ?>" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <form id="upload-form" style="display:none;" action="<?= base_url('designer/upload/' . $order['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label fw-semibold">Upload Hasil Desain</label>
            <input type="file" name="file_hasil_desain" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.ai,.svg" required>
            <small class="text-muted">Format: JPG, PNG, PDF, AI, SVG — maks 10MB</small>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Catatan Desain</label>
            <textarea name="catatan_desain" class="form-control" rows="3" placeholder="Opsional..."></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Upload & Selesai</button>
            <a href="<?= base_url('designer/desain-masuk') ?>" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
