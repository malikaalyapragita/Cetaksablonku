<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Admin CetakApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .topnav {
            background: #fff; border-bottom: 1px solid #e5e7eb;
            padding: 0 32px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
        }
        .topnav .brand {
            font-weight: 800; font-size: 20px; color: #16a34a;
            letter-spacing: -0.5px; display: flex; align-items: center; gap: 8px;
            text-decoration: none;
        }
        .topnav .nav-links { display: flex; gap: 28px; align-items: center; }
        .topnav .nav-links a { text-decoration: none; color: #374151; font-size: 14px; font-weight: 500; }
        .topnav .nav-links a:hover { color: #16a34a; }
        .topnav .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #16a34a; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
        }
        .sidebar {
            width: 210px; position: fixed; top: 56px; left: 0; bottom: 0;
            background: #fff; border-right: 1px solid #e5e7eb;
            padding: 16px 0; overflow-y: auto; z-index: 100;
            display: flex; flex-direction: column;
        }
        .sidebar .nav-item a {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 22px; color: #374151; text-decoration: none;
            font-size: 13.5px; font-weight: 500; transition: all 0.15s;
        }
        .sidebar .nav-item a:hover,
        .sidebar .nav-item a.active { background: #f0fdf4; color: #16a34a; }
        .sidebar .nav-item a.active { border-left: 3px solid #16a34a; }
        .sidebar .nav-item a i { font-size: 17px; width: 20px; }
        .nav-divider { height: 1px; background: #f3f4f6; margin: 8px 16px; }
        .nav-bottom { margin-top: auto; border-top: 1px solid #f3f4f6; padding-top: 8px; }
        .sidebar .nav-item a.logout { color: #ef4444; }
        .sidebar .nav-item a.logout:hover { background: #fef2f2; }
        .main { margin-left: 210px; margin-top: 56px; padding: 24px 28px; min-height: calc(100vh - 56px); }
    </style>
</head>
<body>

<?php
$currentPath = service('request')->getUri()->getPath();
function isActiveAdmin(string $needle, string $path): string {
    return str_contains($path, $needle) ? 'active' : '';
}
$adminName = session()->get('nama') ?? session()->get('username') ?? 'Admin';
?>

<nav class="topnav">
    <a href="<?= base_url('admin/dashboard') ?>" class="brand">
        <i class="bi bi-printer-fill"></i> CetakApp
    </a>
    <div class="nav-links">
        <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('admin/produk') ?>">Produk</a>
        <a href="<?= base_url('admin/order') ?>">Order</a>
        <a href="<?= base_url('admin/pembayaran') ?>">Pembayaran</a>
        <a href="<?= base_url('logout') ?>">Keluar</a>
    </div>
    <div class="avatar"><?= strtoupper(substr($adminName, 0, 1)) ?></div>
</nav>

<div class="sidebar">
    <ul class="list-unstyled mb-0" style="flex:1">
        <li class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>"
               class="<?= isActiveAdmin('admin/dashboard', $currentPath) ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        <div class="nav-divider"></div>
        <li class="nav-item">
            <a href="<?= base_url('admin/produk') ?>"
               class="<?= isActiveAdmin('admin/produk', $currentPath) ?>">
                <i class="bi bi-box-seam"></i> Manajemen Produk
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/kategori') ?>"
               class="<?= isActiveAdmin('admin/kategori', $currentPath) ?>">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
        <div class="nav-divider"></div>
        <li class="nav-item">
            <a href="<?= base_url('admin/order') ?>"
               class="<?= isActiveAdmin('admin/order', $currentPath) ?>">
                <i class="bi bi-bag-check"></i> Manajemen Order
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/pembayaran') ?>"
               class="<?= isActiveAdmin('admin/pembayaran', $currentPath) ?>">
                <i class="bi bi-credit-card"></i> Pembayaran
            </a>
        </li>
        <div class="nav-divider"></div>
        <li class="nav-item">
            <a href="<?= base_url('admin/pengguna') ?>"
               class="<?= isActiveAdmin('admin/pengguna', $currentPath) ?>">
                <i class="bi bi-people"></i> Manajemen Pengguna
            </a>
        </li>
        <div class="nav-divider"></div>
    </ul>

    <div class="nav-bottom">
        <ul class="list-unstyled mb-0">
            <li class="nav-item">
                <a href="<?= base_url('logout') ?>" class="logout">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="main">
    <?php if (session()->getFlashdata('success')): ?>
        <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
            ✓ <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
            ✕ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('message')): ?>
        <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
            ✓ <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>