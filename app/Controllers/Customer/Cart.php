<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;

class Cart extends BaseController
{
    public function add()
    {
        $id           = $this->request->getPost('id');
        $nama_produk  = $this->request->getPost('nama_produk');
        $harga        = $this->request->getPost('harga');
        $qty          = (int) $this->request->getPost('qty') ?: 1;
        $ukuran       = $this->request->getPost('ukuran') ?? '-';
        $warna        = $this->request->getPost('warna') ?? '-';
        $foto         = $this->request->getPost('foto') ?? '';

        $cart = session()->get('cart') ?? [];

        $key = $id . '_' . $ukuran . '_' . $warna;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'id'          => $id,
                'nama_produk' => $nama_produk,
                'harga'       => $harga,
                'qty'         => $qty,
                'ukuran'      => $ukuran,
                'warna'       => $warna,
                'foto'        => $foto,
            ];
        }

        session()->set('cart', $cart);

        // Kirim data produk yang baru ditambah sebagai JSON untuk modal
        return $this->response->setJSON([
            'success'     => true,
            'nama_produk' => $nama_produk,
            'ukuran'      => $ukuran,
            'warna'       => $warna,
            'harga'       => 'Rp ' . number_format($harga, 0, ',', '.'),
            'qty'         => $qty,
            'foto'        => $foto ? base_url('uploads/' . $foto) : '',
            'total_cart'  => array_sum(array_column($cart, 'qty')),
        ]);
    }

    public function remove($key)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$key]);
        session()->set('cart', $cart);
        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }
}