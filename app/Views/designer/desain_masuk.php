<?= $this->extend('designer/layout') ?>
<?= $this->section('title') ?>Antrean Desain<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Antrean Desain Masuk</h5>

<?php if (empty($orders)): ?>
    <div class="text-center text-muted py-5">Tidak ada order yang perlu didesain saat ini.</div>
<?php else: ?>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-3">No. Order</th>
                    <th>Customer ID</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td class="px-3 fw-semibold">ORD-<?= str_pad($o['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td><?= $o['customer_id'] ?></td>
                    <td>Rp <?= number_format($o['total_harga']) ?></td>
                    <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                    <td>
                        <a href="<?= base_url('designer/detail/' . $o['id']) ?>"
                           class="btn btn-sm btn-outline-success">Kerjakan</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
