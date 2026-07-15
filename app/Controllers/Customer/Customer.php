<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Customer extends BaseController
{
    public function dashboard()
    {
        $produkModel = new ProdukModel();
        $orderModel  = new OrderModel();
        $customerId  = session()->get('id');

        $data = [
            'username'       => session()->get('username') ?? session()->get('nama') ?? 'Customer',
            'totalPending'   => $orderModel->where('customer_id', $customerId)->where('status_order', 'pending')->countAllResults(),
            'totalAktif'     => $orderModel->where('customer_id', $customerId)->whereIn('status_order', ['dibayar','didesain','diproduksi','packing','qc'])->countAllResults(),
            'totalSelesai'   => $orderModel->where('customer_id', $customerId)->where('status_order', 'selesai')->countAllResults(),
            'produk'         => $produkModel->findAll(),
            'pesananTerbaru' => $orderModel->where('customer_id', $customerId)->orderBy('created_at','DESC')->limit(5)->findAll(),
            'kategori'       => [],
        ];

        return view('customer/dashboard', $data);
    }

    public function home()
    {
        return redirect()->to(base_url('customer/dashboard'));
    }

    public function katalog()
    {
        $db = \Config\Database::connect();
        $data['produk']   = $db->table('produk')
            ->select('produk.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id', 'left')
            ->get()->getResultArray();
        $data['kategori'] = $db->table('kategori')->get()->getResultArray();
        return view('customer/katalog', $data);
    }

    public function productDetail($id)
    {
        $produkModel    = new ProdukModel();
        $data['produk'] = $produkModel->find((int) $id);

        if (!$data['produk']) {
            return redirect()->to(base_url('customer/katalog'))
                             ->with('error', 'Produk tidak ditemukan.');
        }

        return view('customer/product_detail', $data);
    }

    public function cart_view()
    {
        $data['cart'] = session()->get('cart') ?? [];
        return view('customer/cart', $data);
    }

    public function cart_update()
    {
        $id  = $this->request->getPost('id');
        $qty = (int) $this->request->getPost('qty');
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {
            if ($qty < 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            session()->set('cart', $cart);
        }
        return redirect()->to(base_url('customer/cart'));
    }

    public function pesananBaru()
    {
        $produkModel    = new ProdukModel();
        $data['produk'] = $produkModel->findAll();
        return view('customer/pesanan_baru', $data);
    }

    public function pesananBaruProcess()
    {
        $file = $this->request->getFile('desain');
        $fileName = null;

        if ($file && $file->isValid()) {
            $allowedExt = ['ai', 'psd', 'pdf', 'png'];
            if (!in_array(strtolower($file->getClientExtension()), $allowedExt)) {
                return redirect()->back()->with('error', 'Format file desain harus AI, PSD, PDF, atau PNG.');
            }
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/desain/', $fileName);
        }

        $keterangan = json_encode([
            'jenis_pakaian' => $this->request->getPost('jenis_pakaian'),
            'warna'         => $this->request->getPost('warna'),
            'jumlah'        => $this->request->getPost('jumlah'),
            'instruksi'     => $this->request->getPost('instruksi'),
            'metode_kirim'  => $this->request->getPost('metode_kirim'),
            'ekspedisi'     => $this->request->getPost('ekspedisi'),
            'alamat'        => $this->request->getPost('alamat'),
        ], JSON_UNESCAPED_UNICODE);

        $orderModel = new OrderModel();
        $orderModel->insert([
            'customer_id'  => session()->get('id'),
            'total_harga'  => 0,
            'status_order' => 'pending',
            'file_custom'  => $fileName,
            'keterangan'   => $keterangan,
        ]);

        return redirect()->to(base_url('customer/riwayat'))
                         ->with('success', 'Pesanan custom berhasil dikirim! Admin akan menghubungi Anda untuk konfirmasi harga.');
    }

    public function checkout_view()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(base_url('customer/cart'))
                             ->with('error', 'Keranjang Anda masih kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return view('customer/checkout', ['cart' => $cart, 'total' => $total]);
    }

    public function checkout_process()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(base_url('customer/cart'))
                             ->with('error', 'Keranjang Anda masih kosong.');
        }

        $total = array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart));

        $orderModel = new OrderModel();
        $orderModel->insert([
            'customer_id'  => session()->get('id'),
            'total_harga'  => $total,
            'status_order' => 'pending',
        ]);
        $orderId = $orderModel->getInsertID();

        $detailModel = new \App\Models\OrderDetailModel();
        $produkModel = new ProdukModel();
        foreach ($cart as $item) {
            $detailModel->insert([
                'order_id'  => $orderId,
                'produk_id' => $item['id'],
                'qty'       => $item['qty'],
                'subtotal'  => $item['harga'] * $item['qty'],
            ]);
            $produkModel->set('stok', "stok - {$item['qty']}", false)
                        ->where('id', $item['id'])
                        ->where('stok >=', $item['qty'])
                        ->update();
        }

        session()->remove('cart');

        return redirect()->to(base_url('customer/bayar/' . $orderId))
                         ->with('success', 'Pesanan dibuat! Silakan lakukan pembayaran.');
    }

    public function tracking()
    {
        $orderModel      = new OrderModel();
        $customerId      = session()->get('id');
        $data['pesanan'] = $orderModel->where('customer_id', $customerId)
                                      ->whereNotIn('status_order', ['selesai','dibatalkan'])
                                      ->findAll();
        return view('customer/tracking', $data);
    }

    public function riwayat()
    {
        $customerId = session()->get('id');
        $db = \Config\Database::connect();
        $data['pesanan'] = $db->table('orders')
            ->select('orders.*, pembayaran.id as pembayaran_id, pembayaran.status_pembayaran')
            ->join('pembayaran', 'pembayaran.order_id = orders.id', 'left')
            ->where('orders.customer_id', $customerId)
            ->orderBy('orders.created_at', 'DESC')
            ->get()->getResultArray();
        return view('customer/riwayat', $data);
    }

    public function bayar_view($id)
    {
        $orderModel    = new OrderModel();
        $data['order'] = $orderModel->find($id);

        if (!$data['order']) {
            return redirect()->to(base_url('customer/riwayat'))
                             ->with('error', 'Order tidak ditemukan.');
        }

        return view('customer/bayar', $data);
    }

    public function bayar_process($id)
    {
        $orderModel = new OrderModel();
        $file       = $this->request->getFile('bukti_bayar');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File bukti pembayaran tidak valid.');
        }

        $allowedExt = ['jpg','jpeg','png','pdf'];
        if (!in_array(strtolower($file->getClientExtension()), $allowedExt)) {
            return redirect()->back()->with('error', 'Format file harus JPG, PNG, atau PDF.');
        }

        $fileName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/bukti_bayar/', $fileName);

        $order  = $orderModel->find($id);
        $pModel = new \App\Models\PembayaranModel();
        $existing = $pModel->where('order_id', $id)->first();

        if ($existing) {
            $pModel->update($existing['id'], [
                'bukti_transfer'    => $fileName,
                'jumlah_bayar'      => $order['total_harga'],
                'status_pembayaran' => 'pending',
            ]);
        } else {
            $pModel->insert([
                'order_id'          => $id,
                'bukti_transfer'    => $fileName,
                'jumlah_bayar'      => $order['total_harga'],
                'status_pembayaran' => 'pending',
            ]);
        }

        return redirect()->to(base_url('customer/riwayat'))
                         ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function konfirmasi_terima($id)
    {
        $orderModel = new OrderModel();
        $order      = $orderModel->find($id);

        if (!$order || (int) $order['customer_id'] !== (int) session()->get('id') || $order['status_order'] !== 'dikirim') {
            return redirect()->to(base_url('customer/riwayat'))->with('error', 'Pesanan tidak dapat dikonfirmasi.');
        }

        $orderModel->update($id, ['status_order' => 'selesai']);

        return redirect()->to(base_url('customer/riwayat'))->with('success', 'Terima kasih, pesanan dikonfirmasi selesai.');
    }

    public function faktur($id)
    {
        $db    = \Config\Database::connect();
        $order = $db->table('orders')
            ->select('orders.*, users.username as nama_pelanggan')
            ->join('users', 'users.id = orders.customer_id', 'left')
            ->where('orders.id', $id)
            ->where('orders.customer_id', session()->get('id'))
            ->get()->getRowArray();

        if (!$order) {
            return redirect()->to(base_url('customer/riwayat'))->with('error', 'Order tidak ditemukan.');
        }

        $details = $db->table('order_detail')
            ->select('order_detail.*, produk.nama_produk')
            ->join('produk', 'produk.id = order_detail.produk_id', 'left')
            ->where('order_detail.order_id', $id)
            ->get()->getResultArray();

        return view('customer/faktur', ['order' => $order, 'details' => $details]);
    }

    public function profil()
    {
        $data = [
            'customerName'  => session()->get('username') ?? session()->get('nama') ?? 'Customer',
            'customerEmail' => session()->get('email') ?? '-',
        ];
        return view('customer/profil', $data);
    }

    public function profil_edit()
    {
        $user = (new UserModel())->find(session()->get('id'));
        return view('customer/profil_edit', [
            'customerName'  => $user['username'],
            'customerEmail' => $user['email'],
            'user'          => $user,
        ]);
    }

    public function profil_update()
    {
        $userModel = new UserModel();
        $userId    = session()->get('id');

        if (!$userId) {
            return redirect()->to(base_url('login'))
                             ->with('error', 'Sesi tidak valid, silakan login ulang.');
        }

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');

        $userModel->where('id', $userId)
                  ->set([
                      'username' => $username,
                      'email'    => $email,
                      'no_telp'  => $this->request->getPost('no_telp'),
                      'alamat'   => $this->request->getPost('alamat'),
                  ])
                  ->update();

        session()->set('username', $username);
        session()->set('email', $email);

        return redirect()->to(base_url('customer/profil'))
                         ->with('success', 'Profil berhasil diperbarui.');
    }

    public function ganti_password()
    {
        return view('customer/ganti_password');
    }

    public function ganti_password_proses()
    {
        $userModel = new UserModel();
        $userId    = session()->get('id');

        if (!$userId) {
            return redirect()->to(base_url('login'))
                             ->with('error', 'Sesi tidak valid, silakan login ulang.');
        }

        $lama    = $this->request->getPost('password_lama');
        $baru    = $this->request->getPost('password_baru');
        $konfirm = $this->request->getPost('konfirmasi_password');

        if ($baru !== $konfirm) {
            return redirect()->back()
                             ->with('error', 'Konfirmasi password tidak cocok.');
        }

        $user = $userModel->find($userId);
        if (!$user || !password_verify($lama, $user['password'])) {
            return redirect()->back()
                             ->with('error', 'Password lama tidak sesuai.');
        }

        $userModel->where('id', $userId)
                  ->set([
                      'password' => password_hash($baru, PASSWORD_DEFAULT),
                  ])
                  ->update();

        return redirect()->to(base_url('customer/profil'))
                         ->with('success', 'Password berhasil diubah.');
    }

    public function bantuan()
    {
        return view('customer/bantuan');
    }
}