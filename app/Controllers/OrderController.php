<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProdukModel;

class OrderController extends BaseController
{
    public function index($status = 'pending')
    {
        $model = new OrderModel();
        $data['orders']       = $model->where('status_order', $status)->findAll();
        $data['status_aktif'] = $status;
        return view('admin/order/index', $data);
    }

    public function tambah()
    {
        $produkModel    = new ProdukModel();
        $data['produk'] = $produkModel->findAll();
        return view('admin/order/tambah', $data);
    }

    public function store()
    {
        $model = new OrderModel();
        $model->save([
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'produk_id'      => $this->request->getPost('produk_id'),
            'jumlah'         => $this->request->getPost('jumlah'),
            'catatan'        => $this->request->getPost('catatan'),
            'status_order'   => 'pending',
        ]);
        return redirect()->to('/admin/order')->with('message', 'Order berhasil ditambahkan.');
    }

    public function updateStatus($id)
    {
        $model      = new OrderModel();
        $statusBaru = $this->request->getPost('status_order');

        $data = ['status_order' => $statusBaru];
        if ($statusBaru === 'dikirim') {
            $data['no_resi'] = $this->request->getPost('no_resi');
        }

        $model->update($id, $data);
        return redirect()->to('/admin/order')->with('message', 'Status pesanan berhasil diupdate ke: ' . $statusBaru);
    }

    public function delete($id)
    {
        $model = new OrderModel();
        $model->delete($id);
        return redirect()->to('/admin/order')->with('message', 'Order berhasil dihapus.');
    }
}