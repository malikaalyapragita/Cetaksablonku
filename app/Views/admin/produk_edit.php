<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>

<div class="mb-3">
    <h4 class="fw-bold">Edit Produk</h4>
</div>

<div class="card border-0 shadow-sm p-4" style="max-width:600px;">
    <form action="<?= base_url('admin/produk/update/' . $produk['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?= esc($produk['nama_produk']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= $k['id'] == $produk['kategori_id'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" value="<?= (int)$produk['harga'] ?>" min="0" step="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $produk['stok'] ?>" min="0" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= esc($produk['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Foto Produk</label>
            <?php if (!empty($produk['foto'])): ?>
                <div class="mb-2">
                    <img src="<?= base_url('uploads/' . $produk['foto']) ?>" alt="foto" style="height:100px; border-radius:8px; object-fit:cover;">
                </div>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
