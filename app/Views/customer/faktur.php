<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm p-4" style="max-width:640px;">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-0">Faktur Pesanan</h4>
            <p class="text-muted mb-0">ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></p>
        </div>
        <span class="badge bg-success"><?= ucfirst($order['status_order']) ?></span>
    </div>

    <table class="table table-sm mb-3">
        <tr><th style="width:160px">Pelanggan</th><td><?= esc($order['nama_pelanggan'] ?? '-') ?></td></tr>
        <tr><th>Tanggal</th><td><?= date('d M Y', strtotime($order['created_at'])) ?></td></tr>
        <?php if ($order['no_resi']): ?>
        <tr><th>No. Resi</th><td><?= esc($order['no_resi']) ?></td></tr>
        <?php endif; ?>
    </table>

    <?php if (!empty($details)): ?>
    <table class="table table-bordered table-sm mb-3">
        <thead class="table-dark">
            <tr><th>Produk</th><th class="text-center">Qty</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr>
        </thead>
        <tbody>
            <?php foreach ($details as $d): ?>
            <tr>
                <td><?= esc($d['nama_produk'] ?? '-') ?></td>
                <td class="text-center"><?= $d['qty'] ?></td>
                <td class="text-end">Rp <?= number_format(($d['subtotal'] ?? 0) / ($d['qty'] ?: 1)) ?></td>
                <td class="text-end">Rp <?= number_format($d['subtotal'] ?? 0) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="3" class="text-end fw-bold">Total</td><td class="text-end fw-bold">Rp <?= number_format($order['total_harga']) ?></td></tr>
        </tfoot>
    </table>
    <?php elseif (!empty($order['keterangan'])): ?>
    <?php $ket = json_decode($order['keterangan'], true) ?? []; ?>
    <table class="table table-sm mb-3">
        <tr><th style="width:160px">Jenis Pakaian</th><td><?= esc($ket['jenis_pakaian'] ?? '-') ?></td></tr>
        <tr><th>Warna</th><td><?= esc($ket['warna'] ?? '-') ?></td></tr>
        <tr><th>Jumlah</th><td><?= esc($ket['jumlah'] ?? '-') ?> pcs</td></tr>
        <tr><th>Ekspedisi</th><td><?= esc($ket['ekspedisi'] ?? '-') ?></td></tr>
        <tr><th>Alamat</th><td><?= esc($ket['alamat'] ?? '-') ?></td></tr>
        <?php if (!empty($ket['instruksi'])): ?>
        <tr><th>Instruksi</th><td><?= esc($ket['instruksi']) ?></td></tr>
        <?php endif; ?>
        <tr><th class="fw-bold">Total Harga</th><td class="fw-bold">
            <?= ($order['total_harga'] ?? 0) > 0 ? 'Rp ' . number_format($order['total_harga']) : '<span class="text-warning">Menunggu konfirmasi admin</span>' ?>
        </td></tr>
    </table>
    <?php endif; ?>

    <div class="d-flex gap-2">
        <a href="<?= base_url('customer/riwayat') ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <?php if ($order['status_order'] === 'dikirim'): ?>
        <form action="<?= base_url('customer/konfirmasi-terima/'.$order['id']) ?>" method="POST"
              onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-success btn-sm">Pesanan Diterima</button>
        </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
