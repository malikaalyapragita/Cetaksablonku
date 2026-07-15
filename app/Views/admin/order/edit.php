<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>

<?php $ket = !empty($order['keterangan']) ? json_decode($order['keterangan'], true) : null; ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= base_url('admin/order') ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    <h5 class="fw-bold mb-0">Detail Order CA<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h5>
    <?php
    $statusColor = [
        'pending' => 'warning',
        'dibayar' => 'info',
        'didesain' => 'primary',
        'diproduksi' => 'primary',
        'qc' => 'primary',
        'packing' => 'secondary',
        'dikirim' => 'info',
        'selesai' => 'success',
        'dibatalkan' => 'danger'
    ];
    $sc = $statusColor[$order['status_order']] ?? 'secondary';
    ?>
    <span class="badge bg-<?= $sc ?>"><?= ucfirst($order['status_order']) ?></span>
</div>

<div class="row g-4">

    <!-- KIRI: Info + Items + Pembayaran -->
    <div class="col-lg-8">

        <!-- Info Pelanggan -->
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h6 class="fw-bold mb-3">Informasi Pelanggan</h6>
            <div class="row g-2">
                <div class="col-sm-4 text-muted small">Nama</div>
                <div class="col-sm-8 fw-semibold"><?= esc($order['nama_pelanggan'] ?? '-') ?></div>
                <div class="col-sm-4 text-muted small">Email</div>
                <div class="col-sm-8"><?= esc($order['email'] ?? '-') ?></div>
                <div class="col-sm-4 text-muted small">No. Telepon</div>
                <div class="col-sm-8"><?= esc($order['no_telp'] ?? '-') ?></div>
                <div class="col-sm-4 text-muted small">Tanggal Order</div>
                <div class="col-sm-8"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></div>
                <div class="col-sm-4 text-muted small">Total Harga</div>
                <div class="col-sm-8 fw-bold text-success">Rp <?= number_format($order['total_harga']) ?></div>
                <?php if ($order['no_resi']): ?>
                    <div class="col-sm-4 text-muted small">No. Resi</div>
                    <div class="col-sm-8"><?= esc($order['no_resi']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Item Produk (order normal) -->
        <?php if (!empty($items)): ?>
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3">Item Produk</h6>
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item['foto'])): ?>
                                        <img src="<?= base_url('uploads/' . $item['foto']) ?>"
                                            style="width:32px;height:32px;object-fit:cover;border-radius:4px;margin-right:6px;">
                                    <?php endif; ?>
                                    <?= esc($item['nama_produk'] ?? '-') ?>
                                </td>
                                <td class="text-center"><?= $item['qty'] ?></td>
                                <td class="text-end">Rp <?= number_format($item['subtotal']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Detail Pesanan Custom -->
        <?php if ($ket): ?>
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3">Detail Pesanan Custom</h6>
                <?php if (!empty($order['file_custom'])): ?>
                    <div class="mb-3">
                        <div class="text-muted small mb-1">File Desain</div>
                        <?php
                        $ext = strtolower(pathinfo($order['file_custom'], PATHINFO_EXTENSION));
                        $fileUrl = base_url('uploads/desain/' . $order['file_custom']);
                        ?>
                        <?php if (in_array($ext, ['png', 'jpg', 'jpeg'])): ?>
                            <img src="<?= $fileUrl ?>" class="img-fluid rounded" style="max-height:180px;">
                        <?php else: ?>
                            <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-arrow-down"></i> Download File Desain
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="row g-2">
                    <?php $fields = ['jenis_pakaian' => 'Jenis Pakaian', 'warna' => 'Warna', 'jumlah' => 'Jumlah', 'metode_kirim' => 'Metode Kirim', 'ekspedisi' => 'Ekspedisi', 'alamat' => 'Alamat', 'instruksi' => 'Instruksi']; ?>
                    <?php foreach ($fields as $key => $label): ?>
                        <?php if (!empty($ket[$key])): ?>
                            <div class="col-sm-4 text-muted small"><?= $label ?></div>
                            <div class="col-sm-8 fw-semibold"><?= esc($ket[$key]) ?><?= $key === 'jumlah' ? ' pcs' : '' ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Bukti Pembayaran -->
        <?php if (!empty($pembayaran)): ?>
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold mb-3">Bukti Pembayaran</h6>
                <div class="row g-2 mb-3">
                    <div class="col-sm-4 text-muted small">Status</div>
                    <div class="col-sm-8">
                        <?php $pc = ['pending' => 'warning', 'valid' => 'success', 'ditolak' => 'danger']; ?>
                        <span class="badge bg-<?= $pc[$pembayaran['status_pembayaran']] ?? 'secondary' ?>">
                            <?= ucfirst($pembayaran['status_pembayaran']) ?>
                        </span>
                    </div>
                    <div class="col-sm-4 text-muted small">Jumlah Bayar</div>
                    <div class="col-sm-8 fw-semibold">Rp <?= number_format($pembayaran['jumlah_bayar']) ?></div>
                </div>
                <?php if (!empty($pembayaran['bukti_transfer'])): ?>
                    <?php $bExt = strtolower(pathinfo($pembayaran['bukti_transfer'], PATHINFO_EXTENSION)); ?>
                    <?php if (in_array($bExt, ['jpg', 'jpeg', 'png'])): ?>
                        <img src="<?= base_url('uploads/bukti_bayar/' . $pembayaran['bukti_transfer']) ?>" class="img-fluid rounded"
                            style="max-height:220px;">
                    <?php else: ?>
                        <a href="<?= base_url('uploads/bukti_bayar/' . $pembayaran['bukti_transfer']) ?>" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-arrow-down"></i> Download Bukti
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- KANAN: Form Update -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 sticky-top" style="top:80px;">
            <h6 class="fw-bold mb-3">Update Order</h6>
            <form action="<?= base_url('admin/order/update/' . $order['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Status Order</label>
                    <select name="status_order" class="form-select form-select-sm">
                        <?php foreach (['pending', 'dibayar', 'didesain', 'diproduksi', 'qc', 'packing', 'dikirim', 'selesai', 'dibatalkan'] as $s): ?>
                            <option value="<?= $s ?>" <?= $order['status_order'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($ket): ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Total Harga (Rp)</label>
                        <input type="number" name="total_harga" class="form-control form-control-sm"
                            value="<?= (int) ($order['total_harga'] ?? 0) ?>" min="0" step="1">
                        <div class="form-text">Isi untuk konfirmasi harga ke customer.</div>
                    </div>
                <?php endif; ?>


                <div class="mb-4">
                    <label class="form-label fw-semibold small">No. Resi (opsional)</label>
                    <input type="text" name="no_resi" class="form-control form-control-sm"
                        value="<?= esc($order['no_resi'] ?? '') ?>" placeholder="Isi saat status Dikirim">
                </div>

                <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
            </form>


            <?php if (!empty($pembayaran)): ?>
                <hr>
                <h6 class="fw-semibold mb-2 small">Verifikasi Pembayaran</h6>
                <?php $sp = $pembayaran['status_pembayaran']; ?>
                <?php if ($sp === 'pending'): ?>
                    <form action="<?= base_url('admin/pembayaran/verifikasi/'.$pembayaran['id']) ?>" method="POST" class="d-flex gap-2">
                        <?= csrf_field() ?>
                        <button name="status_pembayaran" value="valid" class="btn btn-sm btn-success flex-fill">✓ Valid</button>
                        <button name="status_pembayaran" value="ditolak" class="btn btn-sm btn-danger flex-fill">✗ Tolak</button>
                    </form>
                <?php elseif ($sp === 'valid'): ?>
                    <div class="alert alert-success py-2 mb-0 small">✓ Pembayaran sudah diverifikasi valid.</div>
                <?php elseif ($sp === 'ditolak'): ?>
                    <div class="alert alert-danger py-2 mb-0 small">✗ Pembayaran ditolak. Menunggu upload ulang customer.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>