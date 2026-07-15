<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Pengguna</h4>
        <p class="text-muted mb-0">Kelola akun admin, designer, dan produksi.</p>
    </div>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="bi bi-plus-lg"></i> Tambah Akun
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#1e293b; color:#fff;">
                <tr>
                    <th class="ps-3">No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th class="pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pengguna as $u): ?>
                <tr>
                    <td class="ps-3"><?= $no++ ?></td>
                    <td class="fw-semibold"><?= esc($u['username']) ?></td>
                    <td><?= esc($u['email']) ?></td>
                    <td><span class="badge bg-secondary"><?= esc($u['role']) ?></span></td>
                    <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                    <td class="pe-3 d-flex gap-1">
                        <button class="btn btn-sm btn-warning text-white"
                                data-bs-toggle="modal" data-bs-target="#editModal<?= $u['id'] ?>">Edit</button>
                        <form action="<?= base_url('admin/pengguna/delete/' . $u['id']) ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus akun <?= esc($u['username']) ?>?')">
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal<?= $u['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?= base_url('admin/pengguna/update/' . $u['id']) ?>" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Akun: <?= esc($u['username']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="<?= esc($u['username']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?= esc($u['email']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                                        <input type="password" name="password" class="form-control" minlength="6">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select name="role" class="form-select">
                                            <option value="admin" <?= $u['role']==='admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="designer" <?= $u['role']==='designer' ? 'selected' : '' ?>>Designer</option>
                                            <option value="production" <?= $u['role']==='production' ? 'selected' : '' ?>>Produksi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/pengguna/store') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="designer">Designer</option>
                            <option value="production">Produksi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
