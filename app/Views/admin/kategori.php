<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h4 class="fw-bold mb-1">Daftar Kategori</h4>
        <p class="text-muted mb-0">Kelola kategori produk sablon Anda.</p>
    </div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#1e293b; color:#fff;">
                <tr>
                    <th class="ps-3">No</th>
                    <th>Nama Kategori</th>
                    <th class="pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($kategori as $k): ?>
                <tr>
                    <td class="ps-3"><?= $no++ ?></td>
                    <td class="fw-semibold"><?= esc($k['nama_kategori']) ?></td>
                    <td class="pe-3">
                        <button type="button" class="btn btn-sm btn-warning text-white"
                                data-bs-toggle="modal" data-bs-target="#editModal<?= $k['id'] ?>">
                            Edit
                        </button>
                        <form action="<?= base_url('admin/kategori/delete/' . $k['id']) ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal<?= $k['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="<?= base_url('admin/kategori/update/' . $k['id']) ?>" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" class="form-control"
                                           value="<?= esc($k['nama_kategori']) ?>" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center p-3 border-top">
        <span class="text-muted small">Menampilkan <?= count($kategori) ?> kategori</span>
        <span class="badge bg-light text-dark border">Total Kategori: <?= count($kategori) ?></span>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/kategori/store') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
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