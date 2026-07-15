<?php namespace App\Controllers\Designer;

use App\Models\OrderModel;
use App\Models\DesainTugasModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Designer extends \App\Controllers\BaseController
{
    private function requireDesigner(): void
    {
        if (session()->get('role') !== 'designer') {
            throw new \RuntimeException('Akses ditolak.', 403);
        }
    }

    public function dashboard()
{
    $this->requireDesigner();

    $oModel = new OrderModel();
    $tModel = new DesainTugasModel();
    $designerId = session()->get('id');

    $data['orders'] = $oModel
        ->where('status_order', 'didesain')
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->findAll();

    $data['stats'] = [
        'didesain' => $oModel
            ->where('status_order', 'didesain')
            ->countAllResults(),

        'total' => $tModel
            ->where('designer_id', $designerId)
            ->countAllResults(),

        // ↓ HAPUS query created_at, ganti jadi hitung semua yang selesai
        'selesai_hari_ini' => $tModel
            ->where('designer_id', $designerId)
            ->where('status_desain', 'selesai')
            ->countAllResults(),

        'revisi' => $tModel
            ->where('designer_id', $designerId)
            ->where('status_desain', 'revisi')
            ->countAllResults(),
    ];

    return view('designer/dashboard', $data);
}

    public function desain_masuk()
    {
        $this->requireDesigner();

        $model = new OrderModel();
        $data['orders'] = $model
            ->where('status_order', 'didesain')
            ->findAll();

        return view('designer/desain_masuk', $data);
    }

    public function detail(int $id)
    {
        $this->requireDesigner();
        $order = (new OrderModel())->find($id);
        if (!$order) return redirect()->to('/designer/desain_masuk');

        $db = \Config\Database::connect();
        $items = $db->table('order_detail')
            ->select('order_detail.*, produk.nama_produk, produk.foto')
            ->join('produk', 'produk.id = order_detail.produk_id', 'left')
            ->where('order_detail.order_id', $id)
            ->get()->getResultArray();

        return view('designer/detail', ['order' => $order, 'items' => $items]);
    }

    public function upload_hasil(int $id)
    {
        $this->requireDesigner();

        $oModel = new OrderModel();
        $order  = $oModel->find($id);

        if (!$order || $order['status_order'] !== 'didesain') {
            throw PageNotFoundException::forPageNotFound('Order tidak ditemukan.');
        }

        $file = $this->request->getFile('file_hasil_desain');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->withInput()
                ->with('error', 'File tidak valid atau tidak ditemukan.');
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'ai', 'svg'];
        $maxSizeKB         = 10_240;

        if (!in_array(strtolower($file->getClientExtension()), $allowedExtensions, true)) {
            return redirect()->back()->withInput()
                ->with('error', 'Tipe file tidak diizinkan.');
        }

        if ($file->getSize() > $maxSizeKB * 1024) {
            return redirect()->back()->withInput()
                ->with('error', 'Ukuran file melebihi 10 MB.');
        }

        $uploadPath = FCPATH . 'uploads/hasil_desain/';
        $fileName   = $file->getRandomName();
        $file->move($uploadPath, $fileName);

        $tModel = new DesainTugasModel();
        $db     = \Config\Database::connect();

        $db->transStart();

        $existing = $tModel->where('order_id', $id)->first();
        $payload  = [
            'order_id'          => $id,
            'designer_id'       => session()->get('id'),
            'file_hasil_desain' => $fileName,
            'catatan_desain'    => $this->request->getPost('catatan_desain'),
            'status_desain'     => 'selesai',
        ];
        if ($existing) {
            $tModel->update($existing['id'], $payload);
        } else {
            $tModel->insert($payload);
        }

        $oModel->update($id, ['status_order' => 'diproduksi']);

        $db->transComplete();

        if (!$db->transStatus()) {
            if (is_file($uploadPath . $fileName)) {
                unlink($uploadPath . $fileName);
            }
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }

        return redirect()->to('/designer/desain_masuk')
            ->with('success', 'Hasil desain berhasil dikirim.');
    }

    public function riwayat()
    {
        $this->requireDesigner();

        $db = \Config\Database::connect();
        $data['riwayat'] = $db->table('desain_tugas')
            ->select('desain_tugas.*, orders.created_at as tgl_order, orders.total_harga, orders.keterangan,
                      users.username as nama_pelanggan')
            ->join('orders', 'orders.id = desain_tugas.order_id', 'left')
            ->join('users',  'users.id = orders.customer_id', 'left')
            ->where('desain_tugas.designer_id', session()->get('id'))
            ->where('desain_tugas.status_desain', 'selesai')
            ->orderBy('desain_tugas.id', 'DESC')
            ->get()->getResultArray();

        return view('designer/riwayat', $data);
    }
}