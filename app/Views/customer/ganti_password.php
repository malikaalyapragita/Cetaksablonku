<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<?php
$customerName = session()->get('username') ?? session()->get('nama') ?? 'Customer';
?>

<div style="margin-bottom:20px;">
    <h4 style="font-size:20px; font-weight:700; color:#111827; margin:0;">🔒 Ganti Password</h4>
    <p style="font-size:13px; color:#6b7280; margin:4px 0 0;">Pastikan password baru kamu kuat dan mudah diingat</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
    ✓ <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
    ✕ <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:32px; max-width:520px;">

    <form action="<?= base_url('customer/ganti-password/proses') ?>" method="POST">
        <?= csrf_field() ?>

        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                Password Lama
            </label>
            <div style="position:relative;">
                <input type="password" name="password_lama" id="pass_lama"
                       placeholder="Masukkan password lama"
                       required
                       style="width:100%; padding:10px 40px 10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit;"
                       onfocus="this.style.borderColor='#16a34a'"
                       onblur="this.style.borderColor='#d1d5db'">
                <span onclick="togglePass('pass_lama', this)"
                      style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#6b7280; font-size:16px; user-select:none;">
                    👁
                </span>
            </div>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                Password Baru
            </label>
            <div style="position:relative;">
                <input type="password" name="password_baru" id="pass_baru"
                       placeholder="Minimal 8 karakter"
                       required minlength="8"
                       style="width:100%; padding:10px 40px 10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit;"
                       onfocus="this.style.borderColor='#16a34a'"
                       onblur="this.style.borderColor='#d1d5db'"
                       oninput="cekKekuatan(this.value)">
                <span onclick="togglePass('pass_baru', this)"
                      style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#6b7280; font-size:16px; user-select:none;">
                    👁
                </span>
            </div>
            <!-- Indikator kekuatan -->
            <div style="margin-top:8px; display:flex; gap:4px;">
                <div id="bar1" style="flex:1; height:4px; border-radius:2px; background:#e5e7eb;"></div>
                <div id="bar2" style="flex:1; height:4px; border-radius:2px; background:#e5e7eb;"></div>
                <div id="bar3" style="flex:1; height:4px; border-radius:2px; background:#e5e7eb;"></div>
            </div>
            <div id="strength-label" style="font-size:11px; color:#9ca3af; margin-top:4px;"></div>
        </div>

        <div style="margin-bottom:28px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                Konfirmasi Password Baru
            </label>
            <div style="position:relative;">
                <input type="password" name="konfirmasi_password" id="pass_konfirm"
                       placeholder="Ulangi password baru"
                       required
                       style="width:100%; padding:10px 40px 10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; outline:none; font-family:inherit;"
                       onfocus="this.style.borderColor='#16a34a'"
                       onblur="this.style.borderColor='#d1d5db'">
                <span onclick="togglePass('pass_konfirm', this)"
                      style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#6b7280; font-size:16px; user-select:none;">
                    👁
                </span>
            </div>
            <div id="match-label" style="font-size:11px; margin-top:4px;"></div>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit"
                    style="flex:1; padding:11px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">
                Ganti Password
            </button>
            <a href="<?= base_url('customer/profil') ?>"
               style="flex:1; padding:11px; background:#fff; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:600; text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center;">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function togglePass(id, el) {
    const input = document.getElementById(id);
    input.type  = input.type === 'password' ? 'text' : 'password';
    el.textContent = input.type === 'password' ? '👁' : '🙈';
}

function cekKekuatan(val) {
    const bars   = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    const label  = document.getElementById('strength-label');
    const colors = ['#ef4444','#f59e0b','#16a34a'];
    const labels = ['Lemah','Sedang','Kuat'];

    let score = 0;
    if (val.length >= 8)                        score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val))               score++;

    bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score - 1] : '#e5e7eb';
    });
    label.textContent  = val.length ? labels[score - 1] || 'Lemah' : '';
    label.style.color  = score > 0 ? colors[score - 1] : '#9ca3af';
}

document.getElementById('pass_konfirm').addEventListener('input', function() {
    const baru     = document.getElementById('pass_baru').value;
    const label    = document.getElementById('match-label');
    if (this.value === '') { label.textContent = ''; return; }
    if (this.value === baru) {
        label.textContent = '✓ Password cocok';
        label.style.color = '#16a34a';
    } else {
        label.textContent = '✕ Password tidak cocok';
        label.style.color = '#ef4444';
    }
});
</script>

<?= $this->endSection() ?>