<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --- Default ---
$routes->get('/', 'Auth::login');

// --- Auth ---
$routes->get('login',                  'Auth::login');
$routes->post('auth/login_process',    'Auth::loginProcess');
$routes->get('register',               'Auth::register');
$routes->get('auth/register',          'Auth::register'); // ← alias ditambahkan
$routes->post('auth/register_process', 'Auth::registerProcess');
$routes->get('logout',                 'Auth::logout');

// --- Admin ---
$routes->group('admin', ['filter' => 'roleCheck:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Admin::dashboard');

    $routes->get('order',                        'Admin\Admin::order');
    $routes->get('order/tambah',                 'Admin\Admin::order_tambah');
    $routes->post('order/store',                 'Admin\Admin::order_store');
    $routes->post('order/update-status/(:num)',  'Admin\Admin::update_status/$1');
    $routes->post('order/delete/(:num)',         'Admin\Admin::order_delete/$1');
    $routes->get('order/edit/(:num)',            'Admin\Admin::order_edit/$1');
    $routes->post('order/update/(:num)',         'Admin\Admin::order_update/$1');
    $routes->get('order/(:segment)',             'Admin\Admin::order/$1');

    $routes->get('produk',                  'Admin\Admin::produk_index');
    $routes->get('produk/tambah',           'Admin\Admin::produk_tambah');
    $routes->post('produk/store',           'Admin\Admin::produk_store');
    $routes->get('produk/edit/(:num)',      'Admin\Admin::produk_edit/$1');
    $routes->post('produk/update/(:num)',   'Admin\Admin::produk_update/$1');
    $routes->get('produk/delete/(:num)',    'Admin\Admin::produk_delete/$1');

    $routes->get('pembayaran',                    'Admin\Admin::pembayaran_index');
    $routes->post('pembayaran/verifikasi/(:num)', 'Admin\Admin::pembayaran_verifikasi/$1');

    $routes->get('kategori',                   'Admin\Admin::kategori_index');
    $routes->post('kategori/store',            'Admin\Admin::kategori_store');
    $routes->post('kategori/update/(:num)',    'Admin\Admin::kategori_update/$1');
    $routes->post('kategori/delete/(:num)',    'Admin\Admin::kategori_delete/$1');

    $routes->get('pengguna',                  'Admin\Admin::pengguna_index');
    $routes->post('pengguna/store',           'Admin\Admin::pengguna_store');
    $routes->post('pengguna/update/(:num)',   'Admin\Admin::pengguna_update/$1');
    $routes->post('pengguna/delete/(:num)',   'Admin\Admin::pengguna_delete/$1');
});

// --- Designer ---
$routes->group('designer', ['filter' => 'roleCheck:designer'], function($routes) {
    $routes->get('dashboard',            'Designer\Designer::dashboard');
    $routes->get('desain_masuk',         'Designer\Designer::desain_masuk');
    $routes->get('desain-masuk',         'Designer\Designer::desain_masuk');
    $routes->get('detail/(:num)',        'Designer\Designer::detail/$1');
    $routes->post('upload/(:num)',       'Designer\Designer::upload_hasil/$1');
    $routes->post('upload_hasil/(:num)', 'Designer\Designer::upload_hasil/$1');
    $routes->get('riwayat',              'Designer\Designer::riwayat');
});

// --- Produksi ---
$routes->group('production', ['filter' => 'roleCheck:production'], function($routes) {
    $routes->get('dashboard',             'Produksi\Produksi::dashboard');
    $routes->get('antrian',               'Produksi\Produksi::antrian');
    $routes->get('qc',                    'Produksi\Produksi::qc');
    $routes->get('packing',               'Produksi\Produksi::packing');
    $routes->get('selesai',               'Produksi\Produksi::selesai');
    $routes->get('detail/(:num)',         'Produksi\Produksi::detail/$1');
    $routes->post('update-status/(:num)', 'Produksi\Produksi::update_status/$1');
});

// --- Owner ---
$routes->group('owner', ['filter' => 'roleCheck:owner'], function($routes) {
    $routes->get('dashboard',         'Owner\Owner::dashboard');
    $routes->get('laporan_penjualan', 'Owner\Owner::laporan_penjualan');
    $routes->get('monitoring',        'Owner\Owner::monitoring');
});

// --- Customer ---
$routes->group('customer', ['filter' => 'roleCheck:customer'], function($routes) {
    $routes->get('dashboard',             'Customer\Customer::dashboard');
    $routes->get('home',                  'Customer\Customer::home');
    $routes->get('katalog',               'Customer\Customer::katalog');
    $routes->get('product-detail/(:num)', 'Customer\Customer::productDetail/$1');

    $routes->get('cart',                  'Customer\Customer::cart_view');
    $routes->post('cart/add',             'Customer\Cart::add');
    $routes->get('cart/remove/(:any)',    'Customer\Cart::remove/$1');
    $routes->post('cart/update',          'Customer\Customer::cart_update');

    $routes->get('checkout',              'Customer\Customer::checkout_view');
    $routes->post('checkout/process',     'Customer\Customer::checkout_process');

    $routes->get('bayar/(:num)',          'Customer\Customer::bayar_view/$1');
    $routes->post('bayar/(:num)',         'Customer\Customer::bayar_process/$1');

    $routes->get('tracking',              'Customer\Customer::tracking');
    $routes->get('riwayat',               'Customer\Customer::riwayat');
    $routes->get('faktur/(:num)',          'Customer\Customer::faktur/$1');
    $routes->post('konfirmasi-terima/(:num)', 'Customer\Customer::konfirmasi_terima/$1');
    $routes->get('pesanan/baru',           'Customer\Customer::pesananBaru');
    $routes->post('pesanan/baru/process',  'Customer\Customer::pesananBaruProcess');

    $routes->get('profil',                'Customer\Customer::profil');
    $routes->get('profil/edit',           'Customer\Customer::profil_edit');        // ← BARU
    $routes->post('profil/update',        'Customer\Customer::profil_update');      // ← BARU

    $routes->get('ganti-password',        'Customer\Customer::ganti_password');     // ← BARU
    $routes->post('ganti-password/proses','Customer\Customer::ganti_password_proses'); // ← BARU

    $routes->get('bantuan',               'Customer\Customer::bantuan');
});