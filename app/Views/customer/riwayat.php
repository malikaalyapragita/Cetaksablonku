<?= $this->extend('customer/layout') ?>
<?= $this->section('title') ?>Riwayat Pesanan<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Riwayat Pesanan</h5>

<?php if (!empty($pesanan)): ?>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-4 py-3">No. Pesanan</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Total</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $r):
                    $statusMap = [
                        'pending'    => ['Menunggu Pembayaran', '#f59e0b', '#fffbeb'],
                        'dibayar'    => ['Diverifikasi',        '#2563eb', '#eff6ff'],
                        'didesain'   => ['Sedang Didesain',     '#8b5cf6', '#f5f3ff'],
                        'diproduksi' => ['Diproduksi',          '#0891b2', '#ecfeff'],
                        'qc'         => ['Quality Control',     '#0891b2', '#ecfeff'],
                        'packing'    => ['Packing',             '#0891b2', '#ecfeff'],
                        'dikirim'    => ['Dikirim',             '#2563eb', '#eff6ff'],
                        'selesai'    => ['Selesai',             '#16a34a', '#f0fdf4'],
                        'dibatalkan' => ['Dibatalkan',          '#dc2626', '#fef2f2'],
                    ];
                    if ($r['status_order'] === 'pending' && ($r['status_pembayaran'] ?? null) === 'pending') {
                        [$label, $color, $bg] = ['Menunggu Persetujuan', '#f59e0b', '#fffbeb'];
                    } else {
                        [$label, $color, $bg] = $statusMap[$r['status_order']] ?? ['Dalam Proses', '#6b7280', '#f9fafb'];
                    }
                ?>
                <tr>
                    <td class="px-4 fw-semibold">CA<?= str_pad($r['id'], 6, '0', STR_PAD_LEFT) ?></td>
                    <td class="text-muted" style="font-size:0.88rem;"><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                    <td class="fw-semibold">Rp <?= number_format($r['total_harga'] ?? 0) ?></td>
                    <td>
                        <span style="background:<?= $bg ?>;color:<?= $color ?>;padding:4px 12px;border-radius:20px;font-size:0.8rem;font-weight:600;">
                            <?= $label ?>
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <a href="<?= base_url('customer/faktur/'.$r['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                            <?php if ($r['status_pembayaran'] === 'ditolak'): ?>
                                <div>
                                    <div style="font-size:11px;color:#dc2626;font-weight:600;margin-bottom:2px;">⚠ Ditolak</div>
                                    <a href="<?= base_url('customer/bayar/'.$r['id']) ?>" class="btn btn-sm btn-warning">Upload Ulang</a>
                                </div>
                            <?php elseif ($r['status_order'] === 'pending' && ($r['total_harga'] ?? 0) > 0 && empty($r['pembayaran_id'])): ?>
                                <a href="<?= base_url('customer/bayar/'.$r['id']) ?>" class="btn btn-sm btn-success">Bayar</a>
                            <?php elseif ($r['status_order'] === 'dikirim'): ?>
                                <form action="<?= base_url('customer/konfirmasi-terima/'.$r['id']) ?>" method="POST"
                                      onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-success">Pesanan Diterima</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>
<div class="card border-0 shadow-sm text-center py-5">
    <div class="card-body">
        <i class="bi bi-clock-history" style="font-size:3rem;color:#d1d5db;"></i>
        <h5 class="text-muted mt-3">Belum ada pesanan</h5>
        <p class="text-muted mb-4">Yuk mulai belanja dan buat pesanan pertamamu!</p>
        <a href="<?= base_url('customer/katalog') ?>" class="btn btn-primary">Lihat Katalog</a>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
