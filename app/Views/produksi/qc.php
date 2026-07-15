<?= $this->extend('produksi/layout') ?>
<?= $this->section('title') ?>QC<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Quality Control</h5>

<?php if (empty($orders)): ?>
    <div class="text-center text-muted py-5">Tidak ada order dalam tahap QC.</div>
<?php else: ?>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-3">Order</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o):
                    $ket = !empty($o['keterangan']) ? json_decode($o['keterangan'], true) : null;
                ?>
                <tr>
                    <td class="px-3 fw-semibold">ORD-<?= str_pad($o['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td><?= esc($o['nama_pelanggan'] ?? '-') ?></td>
                    <td>Rp <?= number_format($o['total_harga']) ?></td>
                    <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                    <td class="text-muted small">
                        <?= $ket ? esc(($ket['jenis_pakaian'] ?? '') . ' · ' . ($ket['warna'] ?? '') . ' · ' . ($ket['jumlah'] ?? '') . ' pcs') : '-' ?>
                    </td>
                    <td>
                        <form action="<?= base_url('production/update-status/'.$o['id']) ?>" method="POST" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="status_order" value="packing">
                            <button class="btn btn-sm btn-success">→ Packing</button>
                        </form>
                        <a href="<?= base_url('production/detail/'.$o['id']) ?>" class="btn btn-sm btn-outline-secondary">Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
