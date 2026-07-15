<?= $this->extend('admin/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Tambah Produk Baru</h3>
    
    <form action="<?= base_url('admin/produk/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach($kategori as $k): ?>
                    <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Foto Produk</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
        <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?>