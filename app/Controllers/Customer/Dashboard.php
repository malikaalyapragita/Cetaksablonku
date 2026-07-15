<?php
// app/Controllers/DashboardController.php
namespace App\Controllers;

use App\Models\ProdukModel;

class DashboardController extends BaseController
{
    public function index()
    {
        // Ambil filter dari URL
        $kategori_aktif = $this->request->getGet('kategori') ?? 'Semua';
        $sort           = $this->request->getGet('sort')     ?? 'populer';

        // --- Ganti bagian ini dengan Model jika sudah ada database ---
        $semua_produk = [
            ['nama'=>'Sablon Kaos Cotton Combed 30s Custom','harga'=>89000, 'rating'=>4.8,'terjual'=>120,'emoji'=>'👕','kategori'=>'Kaos'],
            ['nama'=>'Sablon Hoodie Fleece Premium Custom',  'harga'=>175000,'rating'=>4.6,'terjual'=>85, 'emoji'=>'🧥','kategori'=>'Hoodie'],
            ['nama'=>'Cetak Sablon Tote Bag Kanvas Drill',   'harga'=>35000, 'rating'=>4.9,'terjual'=>210,'emoji'=>'👜','kategori'=>'Tas'],
            ['nama'=>'Sablon Kemeja Oxford Premium',          'harga'=>120000,'rating'=>4.7,'terjual'=>64, 'emoji'=>'👔','kategori'=>'Kemeja'],
            ['nama'=>'Kaos Polos Cotton 24s Custom',          'harga'=>65000, 'rating'=>4.5,'terjual'=>188,'emoji'=>'👕','kategori'=>'Kaos'],
            ['nama'=>'Hoodie Zipper Fleece Custom Print',     'harga'=>195000,'rating'=>4.8,'terjual'=>47, 'emoji'=>'🧥','kategori'=>'Hoodie'],
        ];

        // Filter kategori
        $filtered = [];
        foreach ($semua_produk as $p) {
            if ($kategori_aktif === 'Semua' || $p['kategori'] === $kategori_aktif) {
                $filtered[] = $p;
            }
        }

        // Sort
        usort($filtered, function ($a, $b) use ($sort) {
            if ($sort === 'harga_asc')  return $a['harga'] - $b['harga'];
            if ($sort === 'harga_desc') return $b['harga'] - $a['harga'];
            if ($sort === 'rating')     return $b['rating'] > $a['rating'] ? 1 : -1;
            return $b['terjual'] - $a['terjual']; // default: populer
        });

        $data = [
            'user'            => ['name' => 'Customer3', 'saldo' => 0],
            'produk'          => $filtered,
            'kategori_aktif'  => $kategori_aktif,
            'sort'            => $sort,
            'kategori_list'   => ['Semua', 'Kaos', 'Kemeja', 'Tas', 'Hoodie'],
        ];

        return view('customer/dashboard', $data);
    }
}