<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?: 'Dashboard Produksi' ?> - CetakApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand-green: #16a34a; }
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }

        .topbar {
            height: 64px; background: #fff; border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
        }
        .topbar .brand { font-weight: 800; color: var(--brand-green); font-size: 1.15rem; }
        .topbar .page-title { font-weight: 700; color: #111827; font-size: 1rem; position:absolute; left:50%; transform:translateX(-50%); }
        .avatar-circle {
            width: 38px; height: 38px; border-radius: 50%; background: var(--brand-green);
            color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700;
        }

        .sidebar {
            position: fixed; top: 64px; left: 0; bottom: 0; width: 230px;
            background: #fff; border-right: 1px solid #e5e7eb; padding-top: 18px;
        }
        .sidebar a { display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: #475569; text-decoration: none; font-size: 0.93rem; }
        .sidebar a:hover { background: #f1f5f9; }
        .sidebar a.active { background: #e9f8ef; color: var(--brand-green); font-weight: 600; border-right: 3px solid var(--brand-green); }
        .sidebar a.logout { color: #ef4444; position: absolute; bottom: 20px; width: 100%; }

        .main-content { margin-left: 230px; margin-top: 64px; padding: 28px; }
    </style>
</head>
<body>

    <div class="topbar">
        <span class="brand"><i class="bi bi-printer-fill"></i> CetakApp</span>
        <span class="page-title"><?= $this->renderSection('title') ?: 'Dashboard Produksi' ?> - Antrian Cetak</span>
        <div class="avatar-circle">P</div>
    </div>

    <div class="sidebar">
        <a href="<?= base_url('production/dashboard') ?>" class="<?= uri_string() == 'production/dashboard' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="<?= base_url('production/antrian') ?>" class="<?= uri_string() == 'production/antrian' ? 'active' : '' ?>">
            <i class="bi bi-list-check"></i> Antrian Pesanan
        </a>
        <a href="<?= base_url('production/qc') ?>" class="<?= uri_string() == 'production/qc' ? 'active' : '' ?>">
            <i class="bi bi-patch-check"></i> Quality Control
        </a>
        <a href="<?= base_url('production/packing') ?>" class="<?= uri_string() == 'production/packing' ? 'active' : '' ?>">
            <i class="bi bi-box-seam"></i> Packing
        </a>
        <a href="<?= base_url('production/selesai') ?>" class="<?= uri_string() == 'production/selesai' ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i> Riwayat Produksi
        </a>
        <a href="<?= base_url('logout') ?>" class="logout"><i class="bi bi-box-arrow-left"></i> Keluar</a>
    </div>

    <div class="main-content">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>