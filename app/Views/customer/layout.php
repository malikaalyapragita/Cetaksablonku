<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'CetakApp' ?></title>
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
        .topbar .brand { font-weight: 800; color: var(--brand-green); font-size: 1.2rem; }
        .topbar .greeting { font-weight: 600; color: #1f2937; margin-right: auto; margin-left: 28px; }
        .topbar nav a { color: #444; text-decoration: none; margin-left: 22px; font-size: 0.92rem; }
        .topbar nav a:hover { color: var(--brand-green); }
        .avatar-circle {
            width: 36px; height: 36px; border-radius: 50%; background: #2563eb;
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: 600; margin-left: 24px;
        }
        .cart-btn {
            position: relative; display: flex; align-items: center; gap: 6px;
            background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 10px;
            padding: 7px 14px; color: #374151; text-decoration: none; font-size: 0.88rem;
            font-weight: 600; margin-left: 16px; transition: background .15s;
        }
        .cart-btn:hover { background: #e2e8f0; color: #111; }
        .cart-badge {
            position: absolute; top: -6px; right: -6px; background: #ef4444;
            color: #fff; font-size: 10px; font-weight: 700; border-radius: 50%;
            width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;
        }

        .sidebar {
            position: fixed; top: 64px; left: 0; bottom: 0; width: 240px;
            background: #fff; border-right: 1px solid #e5e7eb; padding-top: 18px;
        }
        .sidebar a {
            display: flex; align-items: center; gap: 12px; padding: 12px 24px;
            color: #475569; text-decoration: none; font-size: 0.93rem;
        }
        .sidebar a:hover { background: #f1f5f9; }
        .sidebar a.active { background: #e9f8ef; color: var(--brand-green); font-weight: 600; }
        .sidebar a.logout { color: #ef4444; position: absolute; bottom: 20px; width: 100%; }

        .main-content { margin-left: 240px; margin-top: 64px; padding: 28px; }
    </style>
</head>
<body>

    <div class="topbar">
        <span class="brand"><i class="bi bi-printer-fill"></i> CetakApp</span>
        <span class="greeting">Halo, <?= esc(session()->get('username') ?? 'Customer') ?>!</span>
        <div class="d-flex align-items-center">
            <nav>
                <a href="<?= base_url('customer/dashboard') ?>">Beranda</a>
                <a href="<?= base_url('customer/katalog') ?>">Katalog</a>
                <a href="<?= base_url('logout') ?>">Keluar</a>
            </nav>
            <?php $cartCount = count(session()->get('cart') ?? []); ?>
            <a href="<?= base_url('customer/cart') ?>" class="cart-btn">
                <i class="bi bi-cart3"></i> Keranjang
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
            <div class="avatar-circle"><?= strtoupper(substr(session()->get('username') ?? 'C', 0, 1)) ?></div>
        </div>
    </div>

    <div class="sidebar">
        <?php $uri = uri_string(); ?>
        <a href="<?= base_url('customer/dashboard') ?>" class="<?= $uri == 'customer/dashboard' ? 'active' : '' ?>">
            <i class="bi bi-house-door-fill"></i> Beranda
        </a>
        <a href="<?= base_url('customer/katalog') ?>" class="<?= $uri == 'customer/katalog' ? 'active' : '' ?>">
            <i class="bi bi-grid-3x3-gap-fill"></i> Katalog Layanan
        </a>
        <a href="<?= base_url('customer/pesanan/baru') ?>" class="<?= $uri == 'customer/pesanan/baru' ? 'active' : '' ?>">
            <i class="bi bi-pencil-square"></i> Buat Pesanan Baru
        </a>
        <a href="<?= base_url('customer/riwayat') ?>" class="<?= $uri == 'customer/riwayat' ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i> Riwayat Pesanan
        </a>
        <a href="<?= base_url('customer/profil') ?>" class="<?= str_starts_with($uri, 'customer/profil') ? 'active' : '' ?>">
            <i class="bi bi-person-fill"></i> Profil Saya
        </a>
        <a href="<?= base_url('customer/bantuan') ?>" class="<?= $uri == 'customer/bantuan' ? 'active' : '' ?>">
            <i class="bi bi-question-circle"></i> Pusat Bantuan
        </a>
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