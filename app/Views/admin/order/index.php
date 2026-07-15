<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Manajemen Order</h4>
        <p class="text-muted small mb-0">Kelola dan lacak semua pesanan sablon.</p>
    </div>
    <a href="<?= base_url('admin/order/tambah') ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Order
    </a>
</div>

<!-- Filter Status -->
<?php
$statuses = [
    'semua'      => ['Semua', 'secondary'],
    'pending'    => ['Pending', 'warning'],
    'dibayar'    => ['Verifikasi', 'info'],
    'didesain'   => ['Desain', 'primary'],
    'diproduksi' => ['Produksi', 'primary'],
    'qc'         => ['QC', 'primary'],
    'packing'    => ['Packing', 'secondary'],
    'dikirim'    => ['Dikirim', 'info'],
    'selesai'    => ['Selesai', 'success'],
    'dibatalkan' => ['Dibatalkan', 'danger'],
];
$aktif = $status_aktif ?? 'semua';
?>
<div class="d-flex flex-wrap gap-2 mb-4">
    <?php foreach ($statuses as $key => [$label, $color]): ?>
        <a href="<?= base_url('admin/order' . ($key !== 'semua' ? '/'.$key : '')) ?>"
           class="btn btn-sm <?= $aktif === $key ? 'btn-'.$color : 'btn-outline-'.$color ?>">
            <?= $label ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-4 py-3">No. Order</th>
                    <th class="py-3">Pelanggan</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Total</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $o):
                    $s = $o['status_order'] ?? 'pending';
                    [$slabel, $scolor] = $statuses[$s] ?? [ucfirst($s), 'secondary'];
                ?>
                <tr>
                    <td class="px-4 fw-semibold">CA<?= str_pad($o['id'], 6, '0', STR_PAD_LEFT) ?></td>
                    <td><?= esc($o['nama_pelanggan'] ?? '-') ?></td>
                    <td class="text-muted small"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                    <td class="fw-semibold">Rp <?= number_format($o['total_harga'] ?? 0) ?></td>
                    <td><span class="badge bg-<?= $scolor ?>"><?= $slabel ?></span></td>
                    <td>
                        <a href="<?= base_url('admin/order/edit/'.$o['id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="<?= base_url('admin/order/delete/'.$o['id']) ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus order CA<?= str_pad($o['id'],6,'0',STR_PAD_LEFT) ?>?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada order.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
