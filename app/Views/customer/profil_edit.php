<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<?php
$user = $user ?? [];
$customerName  = $customerName  ?? session()->get('username') ?? 'Customer';
$customerEmail = $customerEmail ?? session()->get('email')    ?? '-';
?>

<div style="margin-bottom:20px;">
    <h4 style="font-size:20px; font-weight:700; color:#111827; margin:0;">✏️ Edit Profil</h4>
    <p style="font-size:13px; color:#6b7280; margin:4px 0 0;">Perbarui informasi akun kamu</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
    ✓ <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:32px; max-width:520px;">

    <!-- Avatar -->
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:24px; border-bottom:1px solid #f3f4f6;">
        <div style="width:64px; height:64px; border-radius:50%; background:#dbeafe; color:#1d4ed8; font-size:24px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <?= strtoupper(substr($customerName, 0, 1)) ?>
        </div>
        <div>
            <div style="font-size:16px; font-weight:700; color:#111827;"><?= esc($customerName) ?></div>
            <div style="font-size:12px; color:#6b7280; margin-top:2px;">Customer</div>
        </div>
    </div>

    <!-- Form Edit -->
    <form action="<?= base_url('customer/profil/update') ?>" method="POST">
        <?= csrf_field() ?>

        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                Username
            </label>
            <input type="text" name="username"
                   value="<?= esc($customerName) ?>"
                   style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit;"
                   onfocus="this.style.borderColor='#16a34a'"
                   onblur="this.style.borderColor='#d1d5db'">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                Email
            </label>
            <input type="email" name="email"
                   value="<?= esc($customerEmail) ?>"
                   style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit;"
                   onfocus="this.style.borderColor='#16a34a'"
                   onblur="this.style.borderColor='#d1d5db'">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                No. Telepon
            </label>
            <input type="text" name="no_telp"
                   value="<?= esc($user['no_telp'] ?? '') ?>"
                   placeholder="08xxxxxxxxxx"
                   style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit;"
                   onfocus="this.style.borderColor='#16a34a'"
                   onblur="this.style.borderColor='#d1d5db'">
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                Alamat
            </label>
            <textarea name="alamat" rows="3"
                      placeholder="Masukkan alamat lengkap..."
                      style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit; resize:vertical;"
                      onfocus="this.style.borderColor='#16a34a'"
                      onblur="this.style.borderColor='#d1d5db'"><?= esc($user['alamat'] ?? '') ?></textarea>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit"
                    style="flex:1; padding:11px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">
                Simpan Perubahan
            </button>
            <a href="<?= base_url('customer/profil') ?>"
               style="flex:1; padding:11px; background:#fff; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:600; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center;">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>