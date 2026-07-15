<?php namespace App\Models; use CodeIgniter\Model;
class PembayaranModel extends Model {
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'metode_pembayaran', 'bukti_transfer', 'jumlah_bayar', 'status_pembayaran', 'catatan_admin'];
}