<?= $this->extend('designer/layout') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .welcome-box { background:#fff; border-radius:12px; padding:24px 28px; margin-bottom:20px; border:1px solid #e5e7eb; }
    .welcome-box h5 { font-size:20px; font-weight:700; color:#16a34a; margin:0 0 4px; }
    .welcome-box p { color:#6b7280; font-size:14px; margin:0; }
    .stat-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
    .stat-card { background:#fff; border-radius:12px; padding:22px 24px; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; }
    .stat-card.kuning { background:#fefce8; border-color:#fde68a; }
    .stat-card.hijau  { background:#f0fdf4; border-color:#bbf7d0; }
    .stat-card .stat-label { font-size:15px; font-weight:700; color:#1f2937; }
    .stat-card .stat-icons { display:flex; gap:6px; }
    .stat-card .stat-icons i { font-size:20px; }
    .stat-card.kuning .stat-icons i { color:#d97706; }
    .stat-card.hijau  .stat-icons i { color:#16a34a; }
    .section-card { background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; margin-bottom:20px; }
    .section-card .card-head { padding:16px 20px; border-bottom:1px solid #f3f4f6; }
    .section-card .card-head h6 { font-size:15px; font-weight:700; color:#1f2937; margin:0; }
    .badge-aktif { background:#dcfce7; color:#15803d; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
    .bottom-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
    .bottom-card { background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; }
    .bottom-card h6 { font-size:14px; font-weight:700; color:#1f2937; margin-bottom:16px; }
    .aset-icons { display:flex; gap:12px; }
    .aset-icon { width:52px; height:52px; border-radius:10px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; font-size:22px; color:#16a34a; }
    .pendapatan-val { font-size:24px; font-weight:800; color:#1f2937; margin-bottom:12px; }
    .btn-lihat { width:100%; padding:8px; border-radius:8px; border:1.5px solid #16a34a; background:transparent; color:#16a34a; font-size:13px; font-weight:600; cursor:pointer; }
    .kabar-card { background:#16a34a; border-radius:12px; padding:20px; color:#fff; position:relative; overflow:hidden; }
    .kabar-card h6 { font-size:15px; font-weight:700; margin-bottom:6px; }
    .kabar-card p  { font-size:12px; opacity:0.85; margin-bottom:12px; }
    .btn-kabar { background:#fff; color:#16a34a; border:none; border-radius:8px; padding:7px 16px; font-size:12px; font-weight:700; cursor:pointer; }
    .deco-circle { position:absolute; width:80px; height:80px; border-radius:50%; background:rgba(255,255,255,0.08); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="welcome-box">
    <h5>Halo, <?= esc(session()->get('username') ?? 'Desainer') ?>! 👋</h5>
    <p>Siap berkarya? Periksa daftar antrean proyek Anda.</p>
</div>

<div class="stat-row">
    <div class="stat-card kuning">
        <span class="stat-label"><?= $stats['didesain'] ?? 0 ?> Proyek Menunggu</span>
        <div class="stat-icons"><i class="bi bi-palette"></i><i class="bi bi-pencil"></i></div>
    </div>
    <div class="stat-card hijau">
        <span class="stat-label"><?= $stats['total'] ?? 0 ?> Proyek Selesai</span>
        <div class="stat-icons"><i class="bi bi-check-circle-fill"></i><i class="bi bi-check-circle-fill"></i></div>
    </div>
</div>

<div class="section-card">
    <div class="card-head"><h6>Proyek Terakhir</h6></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead style="background:#f9fafb;">
                <tr>
                    <th class="px-3">ID Proyek</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td class="px-3 fw-semibold">ORD-<?= str_pad($o['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td><?= esc($o['customer_id']) ?></td>
                        <td>Rp <?= number_format($o['total_harga']) ?></td>
                        <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                        <td><span class="badge-aktif">Aktif</span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada proyek masuk</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="bottom-grid">
    <div class="bottom-card">
        <h6>Aset Favorit</h6>
        <div class="aset-icons">
            <div class="aset-icon"><i class="bi bi-palette-fill"></i></div>
            <div class="aset-icon"><i class="bi bi-fonts"></i></div>
            <div class="aset-icon"><i class="bi bi-shirt"></i></div>
        </div>
    </div>
    <div class="bottom-card">
        <h6>Pendapatan Bulan Ini</h6>
        <div class="pendapatan-val">Rp <?= number_format($stats['pendapatan'] ?? 0, 0, ',', '.') ?></div>
        <button class="btn-lihat">Lihat Detail</button>
    </div>
    <div class="kabar-card">
        <div class="deco-circle" style="bottom:-20px;right:-20px"></div>
        <span style="position:absolute;top:16px;right:16px;font-size:20px;color:#fde68a;">★</span>
        <h6>Kabar CetakApp</h6>
        <p>Aset Baru Tersedia! Unduh template mockup terbaru.</p>
        <button class="btn-kabar">Lihat Sekarang</button>
    </div>
</div>

<?= $this->endSection() ?>
