<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<?php
$customerName  = $customerName  ?? session()->get('username') ?? 'Customer';
$customerEmail = $customerEmail ?? session()->get('email')    ?? '-';
?>

<div style="margin-bottom:20px;">
    <h4 style="font-size:20px; font-weight:700; color:#111827; margin:0;">👤 Profil Saya</h4>
    <p style="font-size:13px; color:#6b7280; margin:4px 0 0;">Informasi akun kamu</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
    ✓ <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:32px; max-width:520px;">

    <!-- Avatar + Info -->
    <div style="display:flex; align-items:center; gap:20px; margin-bottom:28px; padding-bottom:24px; border-bottom:1px solid #f3f4f6;">
        <div style="width:72px; height:72px; border-radius:50%; background:#dbeafe; color:#1d4ed8; font-size:28px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <?= strtoupper(substr($customerName, 0, 1)) ?>
        </div>
        <div>
            <div style="font-size:18px; font-weight:700; color:#111827;"><?= esc($customerName) ?></div>
            <div style="font-size:13px; color:#6b7280; margin-top:2px;"><?= esc($customerEmail) ?></div>
            <span style="display:inline-block; margin-top:6px; background:#d1fae5; color:#065f46; font-size:11px; font-weight:600; padding:2px 10px; border-radius:20px;">
                Customer
            </span>
        </div>
    </div>

    <!-- Info Rows -->
    <div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px dashed #f0f0f0; font-size:14px;">
            <span style="color:#888;">Username</span>
            <span style="color:#1a1a1a; font-weight:500;"><?= esc($customerName) ?></span>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px dashed #f0f0f0; font-size:14px;">
            <span style="color:#888;">Email</span>
            <span style="color:#1a1a1a; font-weight:500;"><?= esc($customerEmail) ?></span>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px dashed #f0f0f0; font-size:14px;">
            <span style="color:#888;">Role</span>
            <span style="color:#1a1a1a; font-weight:500;">Customer</span>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; font-size:14px;">
            <span style="color:#888;">Status</span>
            <span style="color:#16a34a; font-weight:600;">✓ Aktif</span>
        </div>
    </div>

    <!-- Tombol -->
    <div style="margin-top:24px; display:flex; gap:10px;">
        <a href="<?= base_url('customer/profil/edit') ?>"
           style="flex:1; padding:11px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center;">
            Edit Profil
        </a>
        <a href="<?= base_url('customer/ganti-password') ?>"
           style="flex:1; padding:11px; background:#fff; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:600; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center;">
            Ganti Password
        </a>
    </div>
</div>

<?= $this->endSection() ?>