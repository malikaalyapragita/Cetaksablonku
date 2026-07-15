<?= $this->extend('customer/layout') ?>

<?= $this->section('content') ?>
<h3>Buat Pesanan Baru</h3>
<div class="row mt-3">
    <?php if(!empty($produk)): ?>
        <?php foreach($produk as $p): ?>
            <div class="col-md-3">
                <div class="card p-2 shadow-sm">
                    <img src="<?= base_url('uploads/'.$p['foto']) ?>" class="card-img-top" style="height:150px;object-fit:cover;">
                    <h5 class="mt-2"><?= $p['nama_produk'] ?></h5>
                    <p class="text-success fw-bold">Rp<?= number_format($p['harga'], 0, ',', '.') ?></p>
                    <form action="<?= base_url('customer/cart/add') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="nama_produk" value="<?= $p['nama_produk'] ?>">
                        <input type="hidden" name="harga" value="<?= $p['harga'] ?>">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Produk tidak ditemukan.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>