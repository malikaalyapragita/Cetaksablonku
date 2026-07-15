<?= $this->extend('designer/layout') ?>
<?= $this->section('title') ?>Riwayat Desain<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Riwayat Hasil Pekerjaan</h5>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-3">Order</th>
                    <th>Pelanggan</th>
                    <th>Tgl Order</th>
                    <th>Total</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada riwayat desain selesai.</td></tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                    <?php $ket = !empty($r['keterangan']) ? json_decode($r['keterangan'], true) : null; ?>
                    <tr>
                        <td class="px-3 fw-semibold">ORD-<?= str_pad($r['order_id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td><?= esc($r['nama_pelanggan'] ?? '-') ?></td>
                        <td><?= $r['tgl_order'] ? date('d M Y', strtotime($r['tgl_order'])) : '-' ?></td>
                        <td>
                            <?= ($r['total_harga'] ?? 0) > 0
                                ? 'Rp ' . number_format($r['total_harga'], 0, ',', '.')
                                : '<span class="text-muted">-</span>' ?>
                        </td>
                        <td>
                            <?php if ($ket): ?>
                                <span class="text-muted small">
                                    <?= esc($ket['jenis_pakaian'] ?? '') ?>
                                    <?= !empty($ket['warna']) ? '· ' . esc($ket['warna']) : '' ?>
                                    <?= !empty($ket['jumlah']) ? '· ' . esc($ket['jumlah']) . ' pcs' : '' ?>
                                </span>
                                <?php if (!empty($ket['instruksi'])): ?>
                                    <br><small class="text-muted"><?= esc($ket['instruksi']) ?></small>
                                <?php endif; ?>
                            <?php elseif (!empty($r['catatan_desain'])): ?>
                                <small class="text-muted"><?= esc($r['catatan_desain']) ?></small>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-success">Selesai</span>
                        </td>
                        <td>
                            <?php if (!empty($r['file_hasil_desain'])): ?>
                                <a href="<?= base_url('uploads/hasil_desain/' . $r['file_hasil_desain']) ?>"
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Buka
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
