<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?: 'Designer' ?> - CetakApp</title>
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
        .topnav .brand { font-weight: 800; font-size: 20px; color: #16a34a; letter-spacing: -0.5px; }
        .topnav .nav-links { display: flex; gap: 28px; }
        .topnav .nav-links a { text-decoration: none; color: #374151; font-size: 14px; font-weight: 500; }
        .topnav .nav-links a:hover { color: #16a34a; }
        .topnav .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #16a34a; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
        }
        .sidebar {
            width: 200px; position: fixed; top: 56px; left: 0; bottom: 0;
            background: #fff; border-right: 1px solid #e5e7eb;
            padding: 16px 0; overflow-y: auto;
        }
        .sidebar .nav-item a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px; color: #374151; text-decoration: none;
            font-size: 13.5px; font-weight: 500; transition: all 0.15s;
        }
        .sidebar .nav-item a:hover,
        .sidebar .nav-item a.active { background: #f0fdf4; color: #16a34a; }
        .sidebar .nav-item a.active { border-left: 3px solid #16a34a; }
        .sidebar .nav-item a i { font-size: 16px; width: 18px; }
        .main { margin-left: 200px; margin-top: 56px; padding: 28px 32px; min-height: calc(100vh - 56px); }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<?php $uri = uri_string(); ?>

<nav class="topnav">
    <div class="brand">CetakApp</div>
    <div class="nav-links">
        <a href="<?= base_url('designer/dashboard') ?>">Home</a>
        <a href="<?= base_url('designer/desain-masuk') ?>">Antrean</a>
        <a href="<?= base_url('designer/riwayat') ?>">Riwayat</a>
        <a href="<?= base_url('logout') ?>">Keluar</a>
    </div>
    <div class="avatar"><?= strtoupper(substr(session()->get('username') ?? 'D', 0, 1)) ?></div>
</nav>

<div class="sidebar">
    <ul class="list-unstyled mb-0">
        <li class="nav-item">
            <a href="<?= base_url('designer/dashboard') ?>" class="<?= $uri == 'designer/dashboard' ? 'active' : '' ?>">
                <i class="bi bi-house-fill"></i> Beranda
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('designer/desain-masuk') ?>" class="<?= str_contains($uri, 'desain') ? 'active' : '' ?>">
                <i class="bi bi-list-task"></i> Antrean Desain
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('designer/riwayat') ?>" class="<?= $uri == 'designer/riwayat' ? 'active' : '' ?>">
                <i class="bi bi-folder2-open"></i> Riwayat Proyek
            </a>
        </li>
        <li class="nav-item" style="margin-top:auto;">
            <a href="<?= base_url('logout') ?>" style="color:#ef4444;">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
        </li>
    </ul>
</div>

<div class="main">
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
