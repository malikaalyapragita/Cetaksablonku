<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'CetakApp Admin' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brand-green: #16a34a; }
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }

        .topbar {
            height: 60px; background: #fff; border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
        }
        .topbar .brand { font-weight: 700; color: var(--brand-green); font-size: 1.1rem; }
        .topbar nav a { color: #444; text-decoration: none; margin-left: 24px; font-size: 0.92rem; }
        .topbar nav a:hover { color: var(--brand-green); }
        .avatar-circle {
            width: 34px; height: 34px; border-radius: 50%; background: var(--brand-green);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: 600; margin-left: 24px;
        }

        .sidebar {
            position: fixed; top: 60px; left: 0; bottom: 0; width: 230px;
            background: #fff; border-right: 1px solid #e5e7eb; padding-top: 16px;
        }
        .sidebar a { display: flex; align-items: center; gap: 10px; padding: 11px 22px; color: #475569; text-decoration: none; font-size: 0.93rem; }
        .sidebar a:hover { background: #f1f5f9; }
        .sidebar a.active { background: #e9f8ef; color: var(--brand-green); font-weight: 600; border-right: 3px solid var(--brand-green); }
        .sidebar a.logout { color: #ef4444; position: absolute; bottom: 16px; width: 100%; }

        .main-content { margin-left: 230px; margin-top: 60px; padding: 28px; }

        /* Tombol & elemen tabel kategori */
        .btn-edit-kategori {
            background: #f0ad4e; border: none; color: #fff; border-radius: 20px;
            padding: 4px 16px; font-size: 0.82rem; text-decoration: none; display: inline-block;
        }
        .btn-edit-kategori:hover { background: #ec971f; color: #fff; }

        .btn-hapus-kategori {
            background: #dc3545; border: none; color: #fff; border-radius: 20px;
            padding: 4px 16px; font-size: 0.82rem;
        }
        .btn-hapus-kategori:hover { background: #bb2d3b; color: #fff; }

        .stat-box {
            border: 1px solid #d1d5db; border-radius: 6px;
            padding: 5px 14px; font-size: 0.85rem; color: #374151; background: #fff;
        }

        .table-kategori thead { background: #1e293b; color: #fff; }
        .table-kategori thead th { font-weight: 500; padding: 14px 16px; border: none; }
        .table-kategori tbody td { padding: 16px; vertical-align: middle; border-color: #f1f1f1; }

        /* Order */
        .btn-tambah-order {
            background: #2563eb; border: none; color: #fff; border-radius: 8px;
            padding: 10px 20px; font-weight: 500; text-decoration: none; display: inline-block;
        }
        .btn-tambah-order:hover { background: #1d4ed8; color: #fff; }

        .badge-status {
            padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; color: #fff;
        }
        .badge-selesai { background: #16a34a; }
        .badge-proses { background: #f0ad4e; }
        .badge-pending { background: #dc3545; }
        .badge-validasi { background: #2563eb; }

        .table-order thead { background: #1e293b; color: #fff; }
        .table-order thead th { font-weight: 500; padding: 14px 12px; border: none; font-size: 0.85rem; }
        .table-order tbody td { padding: 14px 12px; vertical-align: middle; border-color: #f1f1f1; }
    </style>
</head>
<body>

    <div class="topbar">
        <span class="brand"><i class="bi bi-printer-fill"></i> CetakApp</span>
        <div class="d-flex align-items-center">
            <nav>
                <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('admin/produk') ?>">Produk</a>
                <a href="<?= base_url('admin/order') ?>">Order</a>
                <a href="<?= base_url('admin/pembayaran') ?>">Pembayaran</a>
                <a href="<?= base_url('logout') ?>">Keluar</a>
            </nav>
            <div class="avatar-circle">A</div>
        </div>
    </div>

    <div class="sidebar">
        <a href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="<?= base_url('admin/produk') ?>"><i class="bi bi-box-seam"></i> Manajemen Produk</a>
        <a href="<?= base_url('admin/kategori') ?>" class="<?= uri_string() == 'admin/kategori' ? 'active' : '' ?>">
            <i class="bi bi-tags-fill"></i> Kategori
        </a>
        <a href="<?= base_url('admin/order') ?>" class="<?= uri_string() == 'admin/order' ? 'active' : '' ?>">
            <i class="bi bi-receipt"></i> Manajemen Order
        </a>
        <a href="<?= base_url('admin/pembayaran') ?>" class="<?= uri_string() == 'admin/pembayaran' ? 'active' : '' ?>">
            <i class="bi bi-credit-card"></i> Pembayaran
        </a>
        <a href="<?= base_url('admin/order') ?>"><i class="bi bi-list-check"></i> Daftar Order</a>
        <a href="<?= base_url('logout') ?>" class="logout"><i class="bi bi-box-arrow-left"></i> Keluar</a>
    </div>

    <div class="main-content">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>