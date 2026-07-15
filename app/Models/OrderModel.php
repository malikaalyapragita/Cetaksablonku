<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    // TODO: ganti nama tabel ini kalau di database Anda namanya beda (misal 'pesanan')
    protected $table      = 'orders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'customer_id',
        'total_harga',
        'status_order',
        'no_resi',
        'file_custom',
        'keterangan',
        'created_at',
    ];

    // Ganti true kalau tabel sudah punya kolom created_at/updated_at standar CI4
    protected $useTimestamps = false;

    /**
     * Hitung jumlah pesanan customer berdasarkan satu status
     */
    public function hitungByStatus($customerId, $status)
    {
        return $this->where('customer_id', $customerId)
                    ->where('status_order', $status)
                    ->countAllResults();
    }

    /**
     * Hitung jumlah pesanan customer berdasarkan beberapa status sekaligus
     */
    public function hitungByStatuses($customerId, array $statuses)
    {
        return $this->where('customer_id', $customerId)
                    ->whereIn('status_order', $statuses)
                    ->countAllResults();
    }

    /**
     * Ambil pesanan terbaru milik customer
     */
    public function pesananTerbaru($customerId, $limit = 5)
    {
        return $this->where('customer_id', $customerId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}