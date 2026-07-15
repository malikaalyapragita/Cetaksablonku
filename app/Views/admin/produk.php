<?= $this->extend('admin/admin') ?>
<?= $this->section('title') ?>Data Produk<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php
$produk      = $produk ?? [];
$totalProduk = count($produk);
$stokMenipis = count(array_filter($produk, fn($p) => ($p['stok'] ?? 0) <= 10));
?>

<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h4 style="font-size:20px; font-weight:700; color:#111827; margin:0;">Daftar Produk</h4>
        <p style="font-size:13px; color:#6b7280; margin:4px 0 0;">Kelola semua produk sablon Anda.</p>
    </div>
    <a href="<?= base_url('admin/produk/tambah') ?>"
       style="display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#2563eb; color:#fff; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none;">
        + Tambah Produk
    </a>
</div>

<!-- Flash Message -->
<?php if (session()->getFlashdata('message')): ?>
<div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
    ✓ <?= session()->getFlashdata('message') ?>
</div>
<?php endif; ?>

<!-- Tabel -->
<div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
    <div class="table-responsive">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#111827;">
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">No</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">Gambar</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">SKU</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">Nama Produk</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">Kategori</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">Harga Dasar (Polos)</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">Stok</th>
                    <th style="padding:12px 16px; font-size:12px; font-weight:600; color:#fff; text-align:left;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produk)): ?>
                    <?php $no = 1; foreach ($produk as $item): ?>
                    <tr style="border-bottom:1px solid #f3f4f6;"
                        onmouseover="this.style.background='#f9fafb'"
                        onmouseout="this.style.background=''">

                        <td style="padding:14px 16px; font-size:13px; color:#6b7280;"><?= $no++ ?></td>

                        <!-- Gambar -->
                        <td style="padding:14px 16px;">
                            <?php if (!empty($item['foto'])): ?>
                                <img src="<?= base_url('uploads/'.$item['foto']) ?>"
                                     style="width:48px; height:48px; object-fit:cover; border-radius:8px; border:1px solid #e5e7eb;">
                            <?php else: ?>
                                <div style="width:48px; height:48px; background:#f3f4f6; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:20px;">
                                    👕
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- SKU -->
                        <td style="padding:14px 16px; font-size:13px; color:#374151; font-weight:500;">
                            <?= esc($item['sku'] ?? '-') ?>
                        </td>

                        <!-- Nama -->
                        <td style="padding:14px 16px; font-size:13px; font-weight:600; color:#111827; max-width:200px;">
                            <?= esc($item['nama_produk']) ?>
                        </td>

                        <!-- Kategori -->
                        <td style="padding:14px 16px; font-size:13px; color:#374151;">
                            <?= esc($item['nama_kategori'] ?? $item['kategori'] ?? '-') ?>
                        </td>

                        <!-- Harga -->
                        <td style="padding:14px 16px; font-size:13px; font-weight:600; color:#111827;">
                            Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                        </td>

                        <!-- Stok -->
                        <td style="padding:14px 16px;">
                            <span style="font-size:13px; font-weight:600;
                                color:<?= ($item['stok'] ?? 0) <= 10 ? '#dc2626' : '#111827' ?>;">
                                <?= $item['stok'] ?? 0 ?>
                            </span>
                            <?php if (($item['stok'] ?? 0) <= 10): ?>
                                <span style="font-size:10px; background:#fee2e2; color:#dc2626; padding:2px 6px; border-radius:4px; margin-left:4px; font-weight:600;">
                                    Menipis
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td style="padding:14px 16px;">
                            <div style="display:flex; gap:6px;">
                                <a href="<?= base_url('admin/produk/edit/'.$item['id']) ?>"
                                   style="padding:5px 14px; background:#d97706; color:#fff; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;">
                                    Edit
                                </a>
                                <a href="<?= base_url('admin/produk/delete/'.$item['id']) ?>"
                                   onclick="return confirm('Yakin hapus produk ini?')"
                                   style="padding:5px 14px; background:#dc2626; color:#fff; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="padding:48px; text-align:center; color:#9ca3af; font-size:14px;">
                            <div style="font-size:36px; margin-bottom:8px;">📦</div>
                            Belum ada data produk.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Tabel -->
    <?php if (!empty($produk)): ?>
    <div style="padding:14px 20px; border-top:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center; background:#f9fafb;">
        <div style="font-size:12px; color:#6b7280;">
            Menampilkan <b><?= count($produk) ?></b> produk
        </div>
        <div style="display:flex; gap:8px; align-items:center;">
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:8px 14px; font-size:12px; color:#374151;">
                <b>Total Produk: <?= $totalProduk ?></b>
            </div>
            <?php if ($stokMenipis > 0): ?>
            <div style="background:#fff; border:1px solid #fca5a5; border-radius:8px; padding:8px 14px; font-size:12px; color:#dc2626;">
                <b>Stok Menipis: <?= $stokMenipis ?></b>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>