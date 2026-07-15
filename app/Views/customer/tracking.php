<?= $this->extend('customer/customer_template') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h2 class="fw-bold mb-4">Tracking Pesanan</h2>

    <?php if (empty($pesanan)): ?>
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body text-muted">Tidak ada pesanan yang sedang berjalan.</div>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Item</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pesanan as $p): ?>
                            <tr>
                                <td><?= esc($p['id_order']) ?></td>
                                <td><?= esc($p['tanggal']) ?></td>
                                <td><?= esc($p['item']) ?></td>
                                <td><span class="badge bg-warning text-dark"><?= esc($p['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>