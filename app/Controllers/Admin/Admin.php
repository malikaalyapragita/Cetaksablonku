<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\OrderModel;
use App\Models\PembayaranModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    // --- DASHBOARD ---
    public function dashboard()
    {
        $db          = \Config\Database::connect();
        $produkModel = new ProdukModel();
        $orderModel  = new OrderModel();

        $data['stats'] = [
            'produk'     => $produkModel->countAll(),
            'pesanan'    => $orderModel->where('status_order', 'pending')->countAllResults(),
            'pembayaran' => $orderModel->where('status_order', 'dibayar')->countAllResults(),
            'antrian'    => $orderModel->where('status_order', 'diproduksi')->countAllResults(),
        ];

        $data['orders'] = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan, produk.nama_produk')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->join('order_detail', 'order_detail.order_id = orders.id', 'left')
            ->join('produk', 'produk.id = order_detail.produk_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $data['aktivitas'] = $db->table('orders')
            ->select('orders.id, orders.status_order, orders.created_at, users.username')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->limit(4)
            ->get()->getResultArray();

        return view('admin/dashboard', $data);
    }

    // --- PRODUK ---
    public function produk_index()
    {
        $db = \Config\Database::connect();
        $data['produk'] = $db->table('produk')
            ->select('produk.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id', 'left')
            ->get()->getResultArray();

        return view('admin/produk', $data);
    }

    public function produk_tambah()
    {
        $kModel           = new KategoriModel();
        $data['kategori'] = $kModel->findAll();
        return view('admin/produk_tambah', $data);
    }

    public function produk_store()
    {
        $model = new ProdukModel();
        $file  = $this->request->getFile('foto');

        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'foto'        => null,
        ];

        if (!empty($file) && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $name);
            $data['foto'] = $name;
        }

        $model->insert($data);

        return redirect()->to('/admin/produk')->with('message', 'Produk berhasil ditambahkan!');
    }

    public function produk_edit($id)
    {
        $model            = new ProdukModel();
        $kModel           = new KategoriModel();
        $data['produk']   = $model->find($id);
        $data['kategori'] = $kModel->findAll();
        return view('admin/produk_edit', $data);
    }

    public function produk_update($id)
    {
        $model = new ProdukModel();
        $file  = $this->request->getFile('foto');

        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
        ];

        if (!empty($file) && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $name);
            $data['foto'] = $name;
        }

        $model->update($id, $data);

        return redirect()->to('/admin/produk')->with('message', 'Produk berhasil diperbarui!');
    }

    public function produk_delete($id)
    {
        $model = new ProdukModel();
        $model->delete($id);
        return redirect()->to('/admin/produk')->with('message', 'Produk berhasil dihapus!');
    }

    // --- KATEGORI ---
    public function kategori_index()
    {
        $model            = new KategoriModel();
        $data['kategori'] = $model->findAll();
        return view('admin/kategori', $data);
    }

    public function kategori_store()
    {
        $model = new KategoriModel();
        $model->insert(['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->to('/admin/kategori')->with('message', 'Kategori berhasil ditambahkan!');
    }

    public function kategori_update($id)
    {
        (new KategoriModel())->update($id, ['nama_kategori' => $this->request->getPost('nama_kategori')]);
        return redirect()->to('/admin/kategori')->with('message', 'Kategori berhasil diupdate!');
    }

    public function kategori_delete($id)
    {
        (new KategoriModel())->delete($id);
        return redirect()->to('/admin/kategori')->with('message', 'Kategori berhasil dihapus!');
    }

    // --- ORDER ---
    public function order($status = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->orderBy('orders.id', 'DESC');
        if ($status) {
            $builder->where('orders.status_order', $status);
        }
        $data['orders']       = $builder->get()->getResultArray();
        $data['status_aktif'] = $status ?? 'semua';
        return view('admin/order/index', $data);
    }

    public function order_tambah()
    {
        $produkModel      = new ProdukModel();
        $data['produk']   = $produkModel->findAll();
        $db               = \Config\Database::connect();
        $data['customers'] = $db->table('users')->where('role', 'customer')->get()->getResultArray();
        return view('admin/order/tambah', $data);
    }

    public function order_store()
    {
        $produkModel = new ProdukModel();
        $produk      = $produkModel->find($this->request->getPost('produk_id'));
        $jumlah      = (int) $this->request->getPost('jumlah');
        $totalHarga  = ($produk['harga'] ?? 0) * $jumlah;

        $orderModel = new OrderModel();
        $orderModel->insert([
            'customer_id'  => $this->request->getPost('customer_id'),
            'total_harga'  => $totalHarga,
            'status_order' => 'pending',
        ]);
        $orderId = $orderModel->getInsertID();

        (new \App\Models\OrderDetailModel())->insert([
            'order_id'  => $orderId,
            'produk_id' => $produk['id'],
            'qty'       => $jumlah,
            'subtotal'  => $totalHarga,
        ]);

        return redirect()->to('/admin/order')->with('message', 'Order berhasil ditambahkan.');
    }

    public function update_status($id)
    {
        $model      = new OrderModel();
        $statusBaru = $this->request->getPost('status_order');

        $data = ['status_order' => $statusBaru];
        if ($statusBaru === 'dikirim') {
            $data['no_resi'] = $this->request->getPost('no_resi');
        }

        $model->update($id, $data);
        return redirect()->to('/admin/order')->with('message', 'Status berhasil diupdate ke: ' . $statusBaru);
    }

    public function order_edit($id)
    {
        $db = \Config\Database::connect();
        $data['order'] = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan, users.email, users.no_telp')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->where('orders.id', $id)
            ->get()->getRowArray();
        if (!$data['order']) {
            return redirect()->to('/admin/order')->with('error', 'Order tidak ditemukan.');
        }
        $data['items'] = $db->table('order_detail')
            ->select('order_detail.*, produk.nama_produk, produk.foto')
            ->join('produk', 'produk.id = order_detail.produk_id', 'left')
            ->where('order_detail.order_id', $id)
            ->get()->getResultArray();
        $data['pembayaran'] = $db->table('pembayaran')
            ->where('order_id', $id)
            ->get()->getRowArray();
        return view('admin/order/edit', $data);
    }

    public function order_update($id)
    {
        $model = new OrderModel();
        $update = ['status_order' => $this->request->getPost('status_order')];
        $noResi = $this->request->getPost('no_resi');
        $totalHarga = $this->request->getPost('total_harga');
        if ($noResi) $update['no_resi'] = $noResi;
        if ($totalHarga !== null && $totalHarga !== '') $update['total_harga'] = (int) $totalHarga;
        $model->update($id, $update);
        return redirect()->to('/admin/order')->with('success', 'Order berhasil diupdate.');
    }

    public function order_delete($id)
    {
        $model = new OrderModel();
        $model->delete($id);
        return redirect()->to('/admin/order')->with('message', 'Order berhasil dihapus.');
    }

    // --- PEMBAYARAN ---
    public function pembayaran_index()
    {
        $db = \Config\Database::connect();
        $data['pembayaran'] = $db->table('pembayaran')
            ->join('orders', 'orders.id = pembayaran.order_id')
            ->select('pembayaran.*, orders.total_harga')
            ->get()->getResultArray();

        return view('admin/pembayaran', $data);
    }

    public function pembayaran_verifikasi($id)
    {
        $pModel = new PembayaranModel();
        $oModel = new OrderModel();
        $status = $this->request->getPost('status_pembayaran');

        $pModel->update($id, ['status_pembayaran' => $status]);
        $pembayaran = $pModel->find($id);

        if ($status === 'valid') {
            $oModel->update($pembayaran['order_id'], ['status_order' => 'didesain']);
        }

        return redirect()->back();
    }

    public function pengguna_index()
    {
        $data['pengguna'] = (new UserModel())
            ->whereIn('role', ['admin', 'designer', 'production'])
            ->findAll();
        return view('admin/pengguna', $data);
    }

    public function pengguna_store()
    {
        $password = $this->request->getPost('password');
        (new UserModel())->insert([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);
        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Akun berhasil ditambahkan.');
    }

    public function pengguna_update($id)
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        (new UserModel())->update($id, $data);
        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Akun berhasil diupdate.');
    }

    public function pengguna_delete($id)
    {
        if ((int)$id === (int)session()->get('id')) {
            return redirect()->to(base_url('admin/pengguna'))->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        (new UserModel())->delete($id);
        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Akun berhasil dihapus.');
    }
}