<?php namespace App\Controllers\Produksi;
use App\Controllers\BaseController;
use App\Models\OrderModel;

class Produksi extends BaseController
{
    public function dashboard()
    {
        $m = new OrderModel();
        $db = \Config\Database::connect();
        $data['orders'] = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->whereIn('orders.status_order', ['diproduksi', 'qc', 'packing'])
            ->orderBy('orders.created_at', 'DESC')
            ->limit(10)->get()->getResultArray();
        $data['stats'] = [
            'antri'   => $m->where('status_order','diproduksi')->countAllResults(),
            'qc'      => $m->where('status_order','qc')->countAllResults(),
            'packing' => $m->where('status_order','packing')->countAllResults(),
            'selesai' => $m->where('status_order','selesai')->countAllResults(),
        ];
        return view('produksi/dashboard', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        $data['order'] = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->where('orders.id', $id)
            ->get()->getRowArray();

        if (!$data['order']) {
            return redirect()->to(base_url('production/dashboard'))->with('error', 'Order tidak ditemukan.');
        }

        $data['items'] = $db->table('order_detail')
            ->select('order_detail.*, produk.nama_produk, produk.foto')
            ->join('produk', 'produk.id = order_detail.produk_id', 'left')
            ->where('order_detail.order_id', $id)
            ->get()->getResultArray();

        return view('produksi/detail', $data);
    }

    private function getOrders(array|string $status): array
    {
        $db = \Config\Database::connect();
        $b  = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->orderBy('orders.created_at', 'DESC');
        is_array($status) ? $b->whereIn('orders.status_order', $status) : $b->where('orders.status_order', $status);
        return $b->get()->getResultArray();
    }

    public function antrian()
    {
        return view('produksi/antrian', ['orders' => $this->getOrders('diproduksi')]);
    }

    public function qc()
    {
        return view('produksi/qc', ['orders' => $this->getOrders('qc')]);
    }

    public function packing()
    {
        return view('produksi/packing', ['orders' => $this->getOrders('packing')]);
    }

    public function selesai()
    {
        return view('produksi/selesai', ['orders' => $this->getOrders(['dikirim', 'selesai'])]);
    }

    public function update_status($id)
    {
        $orderModel  = new OrderModel();
        $statusBaru  = $this->request->getPost('status_order');

        $allowedStatus = ['pending', 'diproduksi', 'qc', 'packing', 'dikirim', 'selesai', 'dibatalkan'];
        if (!in_array($statusBaru, $allowedStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $orderModel->update($id, ['status_order' => $statusBaru]);
        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }
}