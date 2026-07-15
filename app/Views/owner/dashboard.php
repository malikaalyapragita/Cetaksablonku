<?= $this->extend('owner/layout') ?>
<?= $this->section('title') ?>Dashboard Owner<?= $this->endSection() ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Dashboard Owner</h5>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Total Omset</div>
                    <div style="font-size:1.4rem;font-weight:800;color:#16a34a;">Rp <?= number_format($total_omset) ?></div>
                </div>
                <i class="bi bi-cash-stack" style="font-size:1.8rem;color:#16a34a;opacity:.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Total Order</div>
                    <div style="font-size:1.4rem;font-weight:800;color:#2563eb;"><?= $total_order ?></div>
                </div>
                <i class="bi bi-bag-check" style="font-size:1.8rem;color:#2563eb;opacity:.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Sedang Diproses</div>
                    <div style="font-size:1.4rem;font-weight:800;color:#d97706;"><?= $order_proses ?></div>
                </div>
                <i class="bi bi-arrow-repeat" style="font-size:1.8rem;color:#d97706;opacity:.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small mb-1">Order Selesai</div>
                    <div style="font-size:1.4rem;font-weight:800;color:#16a34a;"><?= $order_selesai ?></div>
                </div>
                <i class="bi bi-check-circle" style="font-size:1.8rem;color:#16a34a;opacity:.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body border-bottom py-3 px-4">
        <h6 class="fw-bold mb-0">Order Terbaru</h6>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-4">No. Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_terbaru as $o):
                    $statusColor = [
                        'pending'=>'#dc2626','dibayar'=>'#2563eb','didesain'=>'#7c3aed',
                        'diproduksi'=>'#d97706','qc'=>'#0891b2','packing'=>'#d97706',
                        'dikirim'=>'#16a34a','selesai'=>'#16a34a','dibatalkan'=>'#6b7280',
                    ][$o['status_order']] ?? '#6b7280';
                ?>
                <tr>
                    <td class="px-4 fw-semibold">ORD-<?= str_pad($o['id'],4,'0',STR_PAD_LEFT) ?></td>
                    <td><?= esc($o['nama_pelanggan'] ?? '-') ?></td>
                    <td>Rp <?= number_format($o['total_harga']) ?></td>
                    <td><span class="badge" style="background:<?= $statusColor ?>"><?= ucfirst($o['status_order']) ?></span></td>
                    <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
