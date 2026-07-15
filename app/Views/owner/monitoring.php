<?= $this->extend('owner/layout') ?>
<?= $this->section('title') ?>Monitoring<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Monitoring Workflow</h5>

<div class="row g-3 mb-4">
    <?php
    $statConfig = [
        'pending'    => ['Pending',    '#dc2626', 'bi-hourglass-split'],
        'dibayar'    => ['Dibayar',    '#2563eb', 'bi-credit-card'],
        'didesain'   => ['Desain',     '#7c3aed', 'bi-palette'],
        'diproduksi' => ['Produksi',   '#d97706', 'bi-printer'],
        'qc'         => ['QC',         '#0891b2', 'bi-patch-check'],
        'packing'    => ['Packing',    '#d97706', 'bi-box-seam'],
        'dikirim'    => ['Dikirim',    '#16a34a', 'bi-truck'],
        'selesai'    => ['Selesai',    '#16a34a', 'bi-check-circle'],
    ];
    foreach ($statConfig as $key => [$label, $color, $icon]): ?>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <i class="bi <?= $icon ?>" style="font-size:1.5rem;color:<?= $color ?>;"></i>
            <div style="font-size:1.6rem;font-weight:800;color:<?= $color ?>;" class="mt-1"><?= $stats[$key] ?? 0 ?></div>
            <div class="text-muted small"><?= $label ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-3">No. Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o):
                    [$label, $color] = $statConfig[$o['status_order']] ?? [ucfirst($o['status_order']), '#6b7280', ''];
                ?>
                <tr>
                    <td class="px-3 fw-semibold">ORD-<?= str_pad($o['id'],4,'0',STR_PAD_LEFT) ?></td>
                    <td><?= esc($o['nama_pelanggan'] ?? '-') ?></td>
                    <td>Rp <?= number_format($o['total_harga']) ?></td>
                    <td><span class="badge" style="background:<?= $color ?>"><?= $label ?></span></td>
                    <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
