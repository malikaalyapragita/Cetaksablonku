<?= $this->extend('customer/layout') ?>

<?= $this->section('title') ?>Dashboard Pelanggan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-success">Selamat Datang, <?= session()->get('username'); ?>!</h2>
                <p class="text-muted">Senang melihat Anda kembali.</p>
                <hr>
                <div class="d-flex gap-3">
                    <a href="<?= base_url('customer/katalog'); ?>" class="btn btn-primary">Lihat Katalog</a>
                    <a href="<?= base_url('customer/riwayat'); ?>" class="btn btn-outline-secondary">Riwayat Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>