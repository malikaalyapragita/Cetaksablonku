<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CetakApp - Designer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* TOPNAV */
        .topnav {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 32px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 200;
        }
        .topnav .brand {
            font-weight: 800; font-size: 20px; color: #16a34a;
            letter-spacing: -0.5px;
        }
        .topnav .nav-links { display: flex; gap: 28px; }
        .topnav .nav-links a {
            text-decoration: none; color: #374151;
            font-size: 14px; font-weight: 500;
        }
        .topnav .nav-links a:hover { color: #16a34a; }
        .topnav .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #16a34a; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
        }

        /* SIDEBAR */
        .sidebar {
            width: 200px;
            position: fixed; top: 56px; left: 0; bottom: 0;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            padding: 16px 0;
            overflow-y: auto;
        }
        .sidebar .nav-item a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px;
            color: #374151; text-decoration: none;
            font-size: 13.5px; font-weight: 500;
            border-radius: 0;
            transition: all 0.15s;
        }
        .sidebar .nav-item a:hover,
        .sidebar .nav-item a.active {
            background: #f0fdf4;
            color: #16a34a;
        }
        .sidebar .nav-item a.active {
            border-left: 3px solid #16a34a;
        }
        .sidebar .nav-item a i { font-size: 16px; width: 18px; }

        /* MAIN */
        .main {
            margin-left: 200px;
            margin-top: 56px;
            padding: 28px 32px;
            min-height: calc(100vh - 56px);
        }
    </style>
</head>
<body>

<?php
// Path URL saat ini, dipakai untuk menandai menu sidebar mana yang aktif.
$currentPath = service('request')->getUri()->getPath();

function isActiveMenuDesigner(string $needle, string $currentPath): bool
{
    return str_contains($currentPath, $needle);
}
?>

<!-- TOPNAV -->
<nav class="topnav">
    <div class="brand">CetakApp</div>
    <div class="nav-links">
        <a href="<?= base_url('designer/dashboard') ?>">Home</a>
        <a href="<?= base_url('designer/desain-masuk') ?>">Katalog</a>
        <a href="<?= base_url('logout') ?>">Keluar</a>
    </div>
    <div class="avatar">
        <?= strtoupper(substr(session()->get('nama') ?? 'D', 0, 1)) ?>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar">
    <ul class="nav-item list-unstyled mb-0">
        <li class="nav-item">
            <a href="<?= base_url('designer/dashboard') ?>"
               class="<?= isActiveMenuDesigner('designer/dashboard', $currentPath) ? 'active' : '' ?>">
                <i class="bi bi-house-fill"></i> Beranda
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('designer/desain-masuk') ?>"
               class="<?= isActiveMenuDesigner('desain-masuk', $currentPath) ? 'active' : '' ?>">
                <i class="bi bi-list-task"></i> Antrean Desain
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('designer/desain-masuk') ?>"
               class="<?= isActiveMenuDesigner('desain-masuk', $currentPath) ? 'active' : '' ?>">
                <i class="bi bi-cloud-upload"></i> Upload Desain Baru
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('designer/riwayat') ?>"
               class="<?= isActiveMenuDesigner('designer/riwayat', $currentPath) ? 'active' : '' ?>">
                <i class="bi bi-folder2-open"></i> Riwayat Proyek
            </a>
        </li>
        <li class="nav-item">
            <!-- TODO: belum ada route 'designer/profil' -->
            <a href="#">
                <i class="bi bi-person"></i> Profil Designer
            </a>
        </li>
        <li class="nav-item">
            <!-- TODO: belum ada route 'designer/panduan' -->
            <a href="#">
                <i class="bi bi-book"></i> Panduan & Aset
            </a>
        </li>
    </ul>
</div>

<!-- MAIN -->
<div class="main">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>