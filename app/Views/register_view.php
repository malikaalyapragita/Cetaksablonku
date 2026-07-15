<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ERP Clothing Sablon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .register-container { margin-top: 50px; max-width: 500px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .toggle-password {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="register-container w-100 mb-5">
        <div class="card p-4">
            <div class="card-body">
                <h3 class="text-center mb-2 fw-bold text-dark">Daftar Akun Baru</h3>
                <p class="text-muted text-center mb-4">Sistem ERP Clothing Sablon</p>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/register_process') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan nama lengkap" value="<?= old('username') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="<?= old('email') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Buat password rahasia" required>
                            <span class="input-group-text toggle-password" data-target="password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_telp" class="form-control" placeholder="Contoh: 08123456789" value="<?= old('no_telp') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hak Akses (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="customer" <?= old('role') == 'customer' ? 'selected' : '' ?>>Customer (Pelanggan)</option>
                            <option value="designer" <?= old('role') == 'designer' ? 'selected' : '' ?>>Designer</option>
                            <option value="production" <?= old('role') == 'production' ? 'selected' : '' ?>>Bagian Produksi</option>
                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="owner" <?= old('role') == 'owner' ? 'selected' : '' ?>>Owner (Pemilik)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Tulis alamat rumah..." required><?= old('alamat') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Daftar Sekarang</button>
                </form>

                <div class="text-center mt-3">
                   <p class="mb-0 text-muted" style="font-size: 0.9rem;">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-decoration-none">Login disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>

</body>
</html>