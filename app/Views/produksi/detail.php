<?= $this->extend('produksi/layout') ?>
<?= $this->section('title') ?>Detail Pesanan<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php
$nextStatus = [
    'diproduksi' => ['status' => 'qc',      'label' => 'Lanjut ke QC'],
    'qc'         => ['status' => 'packing',  'label' => 'Lanjut ke Packing'],
    'packing'    => ['status' => 'dikirim',  'label' => 'Tandai Siap Kirim'],
];
$next = $nextStatus[$order['status_order']] ?? null;
$ket  = !empty($order['keterangan']) ? json_decode($order['keterangan'], true) : null;
?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= base_url('production/dashboard') ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    <h5 class="fw-bold mb-0">Detail Order ORD-<?= str_pad($order['id'],4,'0',STR_PAD_LEFT) ?></h5>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Informasi Pesanan</h6>
            <table class="table table-sm mb-0">
                <tr><th style="width:120px">Pelanggan</th><td><?= esc($order['nama_pelanggan'] ?? '-') ?></td></tr>
                <tr><th>Total</th><td>Rp <?= number_format($order['total_harga']) ?></td></tr>
                <tr><th>Tanggal</th><td><?= date('d M Y', strtotime($order['created_at'])) ?></td></tr>
                <tr><th>Status</th><td><span class="badge bg-success"><?= ucfirst($order['status_order']) ?></span></td></tr>
                <?php if ($order['no_resi']): ?>
                <tr><th>No. Resi</th><td><?= esc($order['no_resi']) ?></td></tr>
                <?php endif; ?>
                <?php if ($ket): ?>
                <tr><th>Jenis</th><td><?= esc($ket['jenis_pakaian'] ?? '-') ?></td></tr>
                <tr><th>Warna</th><td><?= esc($ket['warna'] ?? '-') ?></td></tr>
                <tr><th>Jumlah</th><td><?= esc($ket['jumlah'] ?? '-') ?> pcs</td></tr>
                <?php if (!empty($ket['instruksi'])): ?>
                <tr><th>Instruksi</th><td><?= esc($ket['instruksi']) ?></td></tr>
                <?php endif; ?>
                <?php endif; ?>
            </table>

            <?php if (!empty($items)): ?>
            <h6 class="fw-bold mt-4 mb-2">Item Produk</h6>
            <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr><th>Produk</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th></tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?php if (!empty($item['foto'])): ?>
                            <img src="<?= base_url('uploads/'.$item['foto']) ?>" style="width:32px;height:32px;object-fit:cover;border-radius:4px;margin-right:6px;">
                        <?php endif; ?>
                        <?= esc($item['nama_produk'] ?? '-') ?>
                    </td>
                    <td class="text-center"><?= $item['qty'] ?></td>
                    <td class="text-end">Rp <?= number_format($item['subtotal']) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
            <h6 class="fw-bold mb-3">Aksi</h6>
            <?php if ($next): ?>
                <form action="<?= base_url('production/update-status/'.$order['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status_order" value="<?= $next['status'] ?>">
                    <button class="btn btn-success w-100 mb-2"><?= $next['label'] ?></button>
                </form>
            <?php else: ?>
                <p class="text-muted">Order sudah dalam status <strong><?= $order['status_order'] ?></strong>.</p>
            <?php endif; ?>
            <a href="<?= base_url('production/dashboard') ?>" class="btn btn-outline-secondary w-100">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
