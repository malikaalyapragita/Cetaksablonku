<?= $this->extend('admin/admin') ?>
<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php
$adminName = session()->get('nama') ?? session()->get('username') ?? 'Admin';
?>

<!-- Baris Atas: Greeting + Stats -->
<div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:16px; margin-bottom:24px;">

    <!-- Greeting -->
    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:22px 24px;">
        <div style="font-size:20px; font-weight:700; color:#111827; margin-bottom:6px;">
            Selamat Datang, <?= esc($adminName) ?>! 👋
        </div>
        <div style="font-size:13px; color:#6b7280; margin-bottom:16px;">
            Kelola operasional sablon Anda dengan mudah.
        </div>
        <span style="background:#1f2937; color:#fff; padding:5px 14px; border-radius:8px; font-size:12px; font-weight:600;">
            <?= date('d F Y') ?>
        </span>
    </div>

    <!-- Stat: Produk -->
    <div style="background:#2563eb; border-radius:12px; padding:20px; color:#fff; display:flex; flex-direction:column; justify-content:space-between; min-height:110px;">
        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; opacity:0.85;">
            Produk Tersedia
        </div>
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:8px;">
            <div style="font-size:32px; font-weight:800; line-height:1;">
                <?= $stats['produk'] ?? 0 ?>
            </div>
            <span style="font-size:28px; opacity:0.5;">📦</span>
        </div>
    </div>

    <!-- Stat: Pesanan -->
    <div style="background:#d97706; border-radius:12px; padding:20px; color:#fff; display:flex; flex-direction:column; justify-content:space-between; min-height:110px;">
        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; opacity:0.85;">
            Pesanan Baru
        </div>
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:8px;">
            <div style="font-size:32px; font-weight:800; line-height:1;">
                <?= $stats['pesanan'] ?? 0 ?>
            </div>
            <span style="font-size:28px; opacity:0.5;">📝</span>
        </div>
    </div>

    <!-- Stat: Pembayaran -->
    <div style="background:#16a34a; border-radius:12px; padding:20px; color:#fff; display:flex; flex-direction:column; justify-content:space-between; min-height:110px;">
        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; opacity:0.85;">
            Pembayaran Masuk
        </div>
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:8px;">
            <div style="font-size:32px; font-weight:800; line-height:1;">
                <?= $stats['pembayaran'] ?? 0 ?>
            </div>
            <span style="font-size:28px; opacity:0.5;">💰</span>
        </div>
    </div>

</div>

<!-- Body: Tabel + Sidebar -->
<div style="display:grid; grid-template-columns:3fr 1fr; gap:20px;">

    <!-- Kiri -->
    <div style="display:flex; flex-direction:column; gap:20px;">

        <!-- Aktivitas Terbaru -->
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
            <div style="padding:16px 20px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
                <div style="font-size:15px; font-weight:700; color:#111827;">
                    <i class="bi bi-activity" style="color:#16a34a; margin-right:6px;"></i>Aktivitas Terbaru
                </div>
            </div>
            <div style="padding:0 4px;">
                <?php
                $statusIcon = [
                    'pending'    => ['icon'=>'📝','color'=>'#d97706'],
                    'dibayar'    => ['icon'=>'💳','color'=>'#2563eb'],
                    'didesain'   => ['icon'=>'🎨','color'=>'#7c3aed'],
                    'diproduksi' => ['icon'=>'⚙️','color'=>'#0891b2'],
                    'qc'         => ['icon'=>'🔍','color'=>'#0891b2'],
                    'packing'    => ['icon'=>'📦','color'=>'#2563eb'],
                    'dikirim'    => ['icon'=>'🚚','color'=>'#16a34a'],
                    'selesai'    => ['icon'=>'✅','color'=>'#16a34a'],
                    'dibatalkan' => ['icon'=>'❌','color'=>'#dc2626'],
                ];
                if (!empty($aktivitas)):
                    foreach ($aktivitas as $a):
                        $si = $statusIcon[$a['status_order']] ?? ['icon'=>'📋','color'=>'#6b7280'];
                ?>
                <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; border-bottom:1px solid #f9fafb;">
                    <div style="width:36px; height:36px; border-radius:50%; background:#f3f4f6; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0;">
                        <?= $si['icon'] ?>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13.5px; color:#374151;">
                            Order #<?= $a['id'] ?> — <strong><?= esc($a['username'] ?? '-') ?></strong> — <?= ucfirst($a['status_order']) ?>
                        </div>
                        <div style="font-size:11px; color:#9ca3af; margin-top:2px;">
                            <?= date('d M Y, H:i', strtotime($a['created_at'])) ?>
                        </div>
                    </div>
                    <div style="width:8px; height:8px; border-radius:50%; background:<?= $si['color'] ?>; flex-shrink:0;"></div>
                </div>
                <?php endforeach; else: ?>
                <div style="padding:32px; text-align:center; color:#9ca3af; font-size:13px;">Belum ada aktivitas.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Terbaru -->
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
            <div style="padding:16px 20px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
                <div style="font-size:15px; font-weight:700; color:#111827;">
                    <i class="bi bi-bag-check" style="color:#16a34a; margin-right:6px;"></i>Order Terbaru
                </div>
                <a href="<?= base_url('admin/order') ?>"
                   style="font-size:12px; color:#16a34a; text-decoration:none; font-weight:600;">
                    Lihat semua →
                </a>
            </div>
            <div class="table-responsive">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9fafb;">
                            <th style="padding:10px 16px; font-size:11px; font-weight:600; color:#6b7280; text-align:left;">#</th>
                            <th style="padding:10px 16px; font-size:11px; font-weight:600; color:#6b7280; text-align:left;">Pelanggan</th>
                            <th style="padding:10px 16px; font-size:11px; font-weight:600; color:#6b7280; text-align:left;">Produk</th>
                            <th style="padding:10px 16px; font-size:11px; font-weight:600; color:#6b7280; text-align:left;">Total</th>
                            <th style="padding:10px 16px; font-size:11px; font-weight:600; color:#6b7280; text-align:left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php
                            $statusColor = [
                                'pending'    => ['bg'=>'#fff3cd','color'=>'#856404'],
                                'dibayar'    => ['bg'=>'#cfe2ff','color'=>'#0a58ca'],
                                'didesain'   => ['bg'=>'#e2d9f3','color'=>'#6f42c1'],
                                'diproduksi' => ['bg'=>'#d1ecf1','color'=>'#0c5460'],
                                'selesai'    => ['bg'=>'#d1e7dd','color'=>'#0f5132'],
                                'dibatalkan' => ['bg'=>'#f8d7da','color'=>'#842029'],
                            ];
                            foreach ($orders as $i => $o):
                                $sc = $statusColor[$o['status_order']] ?? ['bg'=>'#f3f4f6','color'=>'#555'];
                            ?>
                            <tr style="border-bottom:1px solid #f9fafb;">
                                <td style="padding:12px 16px; font-size:13px; color:#9ca3af;">#<?= $o['id'] ?></td>
                                <td style="padding:12px 16px; font-size:13px; font-weight:600; color:#111827;"><?= esc($o['nama_pelanggan'] ?? '-') ?></td>
                                <td style="padding:12px 16px; font-size:13px; color:#374151;"><?= esc($o['nama_produk'] ?? '-') ?></td>
                                <td style="padding:12px 16px; font-size:13px; font-weight:600; color:#16a34a;">
                                    Rp <?= number_format($o['total_harga'] ?? 0, 0, ',', '.') ?>
                                </td>
                                <td style="padding:12px 16px;">
                                    <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:99px; background:<?= $sc['bg'] ?>; color:<?= $sc['color'] ?>;">
                                        <?= ucfirst($o['status_order']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="padding:32px; text-align:center; color:#9ca3af; font-size:13px;">
                                    Belum ada order masuk.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Kanan: Widget -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Kontrol Cepat -->
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px;">
            <div style="font-size:14px; font-weight:700; color:#1f2937; margin-bottom:14px;">
                ⚡ Kontrol Cepat
            </div>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <a href="<?= base_url('admin/produk/tambah') ?>"
                   style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; text-decoration:none; color:#166534; font-size:13px; font-weight:600;">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>
                <a href="<?= base_url('admin/order') ?>"
                   style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; text-decoration:none; color:#1d4ed8; font-size:13px; font-weight:600;">
                    <i class="bi bi-bag-check"></i> Lihat Order
                </a>
                <a href="<?= base_url('admin/pembayaran') ?>"
                   style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#fefce8; border:1px solid #fde68a; border-radius:8px; text-decoration:none; color:#92400e; font-size:13px; font-weight:600;">
                    <i class="bi bi-credit-card"></i> Cek Pembayaran
                </a>
                <a href="<?= base_url('admin/kategori') ?>"
                   style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:#f5f3ff; border:1px solid #ddd6fe; border-radius:8px; text-decoration:none; color:#6d28d9; font-size:13px; font-weight:600;">
                    <i class="bi bi-tags"></i> Kelola Kategori
                </a>
            </div>
        </div>

        <!-- Antrian Produksi -->
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px;">
            <div style="font-size:14px; font-weight:700; color:#1f2937; margin-bottom:12px;">
                ⚙️ Antrian Produksi
            </div>
            <div style="font-size:32px; font-weight:800; color:#111827; margin-bottom:4px;">
                <?= $stats['antrian'] ?? 0 ?>
            </div>
            <div style="font-size:12px; color:#6b7280; margin-bottom:14px;">order sedang diproduksi</div>
            <a href="<?= base_url('admin/order') ?>"
               style="display:block; width:100%; padding:9px; background:#16a34a; color:#fff; border-radius:8px; font-size:13px; font-weight:600; text-align:center; text-decoration:none;">
                Lihat Antrian
            </a>
        </div>

        <!-- Promo / Info -->
        <div style="background:#1f2937; color:#fff; border-radius:12px; padding:18px; position:relative; overflow:hidden;">
            <span style="position:absolute; top:12px; right:12px; color:#fde047; font-size:16px;">⭐</span>
            <div style="font-size:11px; background:rgba(255,255,255,0.15); padding:2px 10px; border-radius:20px; width:max-content; margin-bottom:10px; font-weight:500;">
                🔔 Info
            </div>
            <div style="font-size:14px; font-weight:700; line-height:1.5;">
                Pantau semua aktivitas sablon dari satu dashboard.
            </div>
            <span style="position:absolute; bottom:-10px; right:-10px; font-size:72px; opacity:0.08;">⚙️</span>
        </div>

    </div>
</div>

<?= $this->endSection() ?>