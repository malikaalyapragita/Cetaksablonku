<?= $this->extend('owner/layout') ?>
<?= $this->section('title') ?>Laporan Penjualan<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Laporan Penjualan</h5>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 text-center">
            <div style="font-size:1.8rem;font-weight:800;color:#16a34a;">Rp <?= number_format($total_omset) ?></div>
            <div class="text-muted small mt-1">Total Omset (Order Selesai)</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 text-center">
            <div style="font-size:1.8rem;font-weight:800;color:#2563eb;"><?= $total_order ?></div>
            <div class="text-muted small mt-1">Total Order Selesai</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 text-center">
            <div style="font-size:1.8rem;font-weight:800;color:#d97706;">
                Rp <?= $total_order > 0 ? number_format($total_omset / $total_order) : 0 ?>
            </div>
            <div class="text-muted small mt-1">Rata-rata per Order</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-3">No. Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($laporan)): ?>
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada order selesai.</td></tr>
                <?php else: ?>
                    <?php foreach ($laporan as $l): ?>
                    <tr>
                        <td class="px-3 fw-semibold">ORD-<?= str_pad($l['id'],4,'0',STR_PAD_LEFT) ?></td>
                        <td><?= esc($l['username']) ?></td>
                        <td>Rp <?= number_format($l['total_harga']) ?></td>
                        <td><?= date('d M Y', strtotime($l['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
