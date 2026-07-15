<?= $this->extend('produksi/layout') ?>
<?= $this->section('title') ?>Dashboard Produksi<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php
$orders = $orders ?? [];

$dummyOrders = !empty($orders) ? array_map(function($o) {
    return array_merge([
        'nama_produk'  => 'Produk #'.$o['id'],
        'foto'         => '',
        'mesin'        => 'A',
        'estimasi'     => '-',
        'status_order' => 'pending',
    ], $o);
}, $orders) : [
    [
        'id'           => '5511',
        'nama_produk'  => 'T-shirt Polos Combed 30s',
        'status_order' => 'diproduksi',
        'mesin'        => 'A',
        'estimasi'     => '14:30',
        'foto_url'     => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=200',
    ],
    [
        'id'           => '5512',
        'nama_produk'  => 'Hoodie Fleece Premium',
        'status_order' => 'qc',
        'mesin'        => 'B',
        'estimasi'     => '15:15',
        'foto_url'     => 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=200',
    ],
    [
        'id'           => '5513',
        'nama_produk'  => 'T-shirt Polos Combed 30s',
        'status_order' => 'pending',
        'mesin'        => 'A',
        'estimasi'     => 'Pending',
        'foto_url'     => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200',
    ],
];

$statusMap = [
    'diproduksi' => ['label'=>'Produksi',  'bg'=>'#16a34a','icon'=>'bi-printer-fill'],
    'qc'         => ['label'=>'QC',        'bg'=>'#2563eb','icon'=>'bi-moisture'],
    'packing'    => ['label'=>'Packing',   'bg'=>'#d97706','icon'=>'bi-box-seam'],
    'dikirim'    => ['label'=>'Dikirim',   'bg'=>'#7c3aed','icon'=>'bi-truck'],
    'selesai'    => ['label'=>'Selesai',   'bg'=>'#6b7280','icon'=>'bi-check-circle'],
    'pending'    => ['label'=>'Pending',   'bg'=>'#dc2626','icon'=>'bi-hourglass-split'],
];
?>

<div style="display:grid; grid-template-columns:1fr 280px; gap:20px;">

    <!-- KIRI -->
    <div>
        <div style="font-size:16px; font-weight:700; color:#111827; margin-bottom:16px;">
            Daftar Pesanan Masuk
        </div>

        <?php foreach ($orders as $o):
            $sm = $statusMap[$o['status_order']] ?? ['label'=>ucfirst($o['status_order']),'bg'=>'#6b7280','icon'=>'bi-circle'];
            $fotoUrl = !empty($o['foto']) ? base_url('uploads/'.$o['foto']) : '';
        ?>
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:16px 20px; margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                <div style="font-size:13px; font-weight:700; color:#111827;">ORD-<?= str_pad($o['id'],4,'0',STR_PAD_LEFT) ?></div>
                <div style="display:flex; gap:8px; font-size:12px; font-weight:600; color:#6b7280;">
                    <span>Status</span><span style="width:80px;text-align:center;">Aksi</span>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:14px;">
                <div style="width:80px; height:80px; border-radius:10px; overflow:hidden; flex-shrink:0; background:#f3f4f6;">
                    <?php if ($fotoUrl): ?>
                        <img src="<?= $fotoUrl ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-image" style="font-size:28px;color:#d1d5db;"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:600;color:#111827;"><?= esc($o['nama_produk'] ?? '-') ?></div>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;"><?= esc($o['nama_pelanggan'] ?? '-') ?></div>
                    <div style="font-size:12px;color:#6b7280;">Rp <?= number_format($o['total_harga']) ?></div>
                </div>
                <div style="text-align:center;flex-shrink:0;">
                    <span style="font-size:11px;font-weight:600;color:<?= $sm['bg'] ?>;"><?= $sm['label'] ?></span>
                </div>
                <div style="flex-shrink:0;">
                    <a href="<?= base_url('production/detail/'.$o['id']) ?>"
                       style="display:block;padding:7px 14px;background:#16a34a;color:#fff;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;text-align:center;">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Tips -->
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:12px 16px; display:flex; align-items:center; gap:10px; margin-top:4px;">
            <i class="bi bi-info-circle-fill" style="color:#2563eb; font-size:18px; flex-shrink:0;"></i>
            <div style="font-size:13px; color:#1d4ed8; font-weight:500;">
                Tip Efisiensi: Optimalkan Penjadwalan Mesin A untuk meningkatkan output harian.
            </div>
        </div>
    </div>

    <!-- KANAN: Stats -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <div style="background:#16a34a; border-radius:12px; padding:20px; color:#fff;">
            <div style="font-size:14px; font-weight:700; margin-bottom:16px;">Ringkasan Produksi</div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; text-align:center;">
                <div>
                    <div style="font-size:32px; font-weight:800; line-height:1;"><?= $stats['antri'] ?></div>
                    <div style="font-size:11px; opacity:0.85; margin-top:4px;">Antrian</div>
                </div>
                <div>
                    <div style="font-size:32px; font-weight:800; line-height:1;"><?= $stats['qc'] ?></div>
                    <div style="font-size:11px; opacity:0.85; margin-top:4px;">QC</div>
                </div>
                <div>
                    <div style="font-size:32px; font-weight:800; line-height:1;"><?= $stats['packing'] ?></div>
                    <div style="font-size:11px; opacity:0.85; margin-top:4px;">Packing</div>
                </div>
                <div>
                    <div style="font-size:32px; font-weight:800; line-height:1;"><?= $stats['selesai'] ?></div>
                    <div style="font-size:11px; opacity:0.85; margin-top:4px;">Selesai</div>
                </div>
            </div>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px;">
            <div style="font-size:14px; font-weight:700; color:#111827; margin-bottom:14px;">Aksi Cepat</div>
            <a href="<?= base_url('production/antrian') ?>" style="display:block; padding:10px 14px; background:#f0fdf4; color:#16a34a; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:8px;">
                <i class="bi bi-list-check me-2"></i> Antrian Produksi
            </a>
            <a href="<?= base_url('production/qc') ?>" style="display:block; padding:10px 14px; background:#eff6ff; color:#2563eb; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:8px;">
                <i class="bi bi-patch-check me-2"></i> Quality Control
            </a>
            <a href="<?= base_url('production/packing') ?>" style="display:block; padding:10px 14px; background:#fffbeb; color:#d97706; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
                <i class="bi bi-box-seam me-2"></i> Packing
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>