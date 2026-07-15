<?php namespace App\Controllers\Owner;
use App\Controllers\BaseController;
use App\Models\OrderModel;

class Owner extends BaseController {
    public function dashboard() {
        $m  = new OrderModel();
        $db = \Config\Database::connect();
        $data['total_omset']    = $db->table('orders')->selectSum('total_harga')->where('status_order','selesai')->get()->getRow()->total_harga ?? 0;
        $data['total_order']    = $m->countAll();
        $data['order_selesai']  = $m->where('status_order','selesai')->countAllResults();
        $data['order_proses']   = $m->whereIn('status_order',['dibayar','didesain','diproduksi','qc','packing','dikirim'])->countAllResults();
        $data['order_pending']  = $m->where('status_order','pending')->countAllResults();
        $data['order_terbaru']  = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users','users.id = orders.customer_id','left')
            ->orderBy('orders.created_at','DESC')->limit(5)->get()->getResultArray();
        return view('owner/dashboard', $data);
    }
    public function laporan_penjualan() {
        $db = \Config\Database::connect();
        $data['laporan'] = $db->table('orders')
            ->select('orders.*, users.username')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->where('status_order', 'selesai')
            ->orderBy('orders.created_at', 'DESC')
            ->get()->getResultArray();
        $data['total_omset']  = array_sum(array_column($data['laporan'], 'total_harga'));
        $data['total_order']  = count($data['laporan']);
        return view('owner/laporan_penjualan', $data);
    }
    public function monitoring() {
        $db = \Config\Database::connect();
        $data['orders'] = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->get()->getResultArray();
        $data['stats'] = [
            'pending'    => 0, 'dibayar' => 0, 'didesain' => 0,
            'diproduksi' => 0, 'qc'      => 0, 'packing'  => 0,
            'dikirim'    => 0, 'selesai' => 0,
        ];
        foreach ($data['orders'] as $o) {
            $s = $o['status_order'];
            if (isset($data['stats'][$s])) $data['stats'][$s]++;
        }
        return view('owner/monitoring', $data);
    }
}