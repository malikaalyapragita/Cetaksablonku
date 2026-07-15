<?= $this->extend('admin/admin') ?>
<?= $this->section('content') ?>
<h3>Konfirmasi Dana Masuk</h3>
<table class="table table-bordered bg-white mt-3">
    <thead><tr><th>ID Order</th><th>Metode</th><th>Nominal</th><th>Bukti</th><th>Status</th><th>Validasi</th></tr></thead>
    <tbody>
        <?php foreach($pembayaran as $p): ?>
        <tr>
            <td>#<?= $p['order_id'] ?></td>
            <td><?= $p['metode_pembayaran'] ?? 'Transfer Bank' ?></td>
            <td>Rp<?= number_format($p['jumlah_bayar']) ?></td>
            <td><a href="<?= base_url('uploads/bukti_bayar/' . $p['bukti_transfer']) ?>" target="_blank">Buka Bukti</a></td>
            <td><span class="badge bg-warning"><?= $p['status_pembayaran'] ?></span></td>
            <td>
                <?php if($p['status_pembayaran'] == 'pending'): ?>
                <form action="<?= base_url('admin/pembayaran/verifikasi/' . $p['id']) ?>" method="POST" class="d-inline">
                    <button name="status_pembayaran" value="valid" class="btn btn-sm btn-success">Valid</button>
                    <button name="status_pembayaran" value="ditolak" class="btn btn-sm btn-danger">Tolak</button>
                </form>
                <?php else: ?><span class="text-muted small">Selesai diperiksa</span><?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>