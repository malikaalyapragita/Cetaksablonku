<?= $this->extend('customer/layout') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <h2>❓ Pusat Bantuan</h2>
    <p class="subtext">Ada pertanyaan? Kami siap membantu</p>
</div>

<div class="faq-list">

    <div class="faq-card">
        <div class="faq-q">Bagaimana cara memesan?</div>
        <div class="faq-a">Pilih produk di Katalog Layanan → klik "Tambah ke Keranjang" → lakukan Checkout → selesaikan pembayaran.</div>
    </div>

    <div class="faq-card">
        <div class="faq-q">Berapa lama proses produksi?</div>
        <div class="faq-a">Rata-rata 3–7 hari kerja tergantung jenis produk dan jumlah pesanan.</div>
    </div>

    <div class="faq-card">
        <div class="faq-q">Bagaimana cara melakukan pembayaran?</div>
        <div class="faq-a">Setelah checkout, kamu akan diarahkan ke halaman pembayaran. Upload bukti transfer sesuai nominal yang tertera.</div>
    </div>

    <div class="faq-card">
        <div class="faq-q">Bisa lacak status pesanan?</div>
        <div class="faq-a">Bisa. Lihat di menu Riwayat Pesanan — status akan diperbarui setiap tahap produksi.</div>
    </div>

    <div class="faq-card">
        <div class="faq-q">Butuh bantuan lebih lanjut?</div>
        <div class="faq-a">
            Hubungi kami via WhatsApp: 
            <a href="https://wa.me/6281234567890" target="_blank" style="color:#16a34a; font-weight:500;">
                0812-3456-7890
            </a>
        </div>
    </div>

</div>

<style>
.faq-list { display: flex; flex-direction: column; gap: 12px; max-width: 640px; }

.faq-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 10px; padding: 18px 20px;
}
.faq-q {
    font-size: 15px; font-weight: 600; color: #1a1a1a;
    margin-bottom: 8px;
}
.faq-a {
    font-size: 14px; color: #555; line-height: 1.6;
}
</style>

<?= $this->endSection() ?>