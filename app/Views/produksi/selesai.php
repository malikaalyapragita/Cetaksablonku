<?= $this->extend('produksi/layout') ?>
<?= $this->section('title') ?>Selesai<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Riwayat Produksi — Dikirim & Selesai</h5>

<?php if (!empty($orders)): ?>
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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o):
                    $ket = !empty($o['keterangan']) ? json_decode($o['keterangan'], true) : null;
                    $isDikirim = $o['status_order'] === 'dikirim';
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
                        <?php if ($isDikirim): ?>
                            <span class="badge" style="background:#0891b2;">🚚 Dikirim</span>
                        <?php else: ?>
                            <span class="badge bg-success">✓ Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
    <div style="text-align:center; padding:48px; background:#fff; border-radius:12px; border:1px solid #e5e7eb; color:#9ca3af;">
        <div style="font-size:36px; margin-bottom:8px;">🎉</div>
        Belum ada order yang dikirim atau selesai.
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
