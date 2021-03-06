<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Home');
// $routes->setDefaultMethod('index');
// $routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('kasir', 'Cashier::index', ['filter' => 'accessRights:kasir']);

$routes->group('admin', ['filter' => 'accessRights:admin'], function($routes)
{
    $routes->get('', 'Admin::index');
    $routes->get('kategori_produk', 'CategoryProduct::index');
    $routes->get('buat_kategori_produk', 'CategoryProduct::createCategoryProduct');
    $routes->get('perbaharui_kategori_produk/(:segment)', 'CategoryProduct::updateCategoryProduct/$1');
    $routes->get('produk', 'Product::index');
    $routes->get('buat_produk', 'Product::createProduct');
    $routes->get('perbaharui_produk/(:segment)', 'Product::updateProduct/$1');
    $routes->get('transaksi', 'Transaction::index');
    $routes->get('pengguna', 'User::index');
    $routes->get('buat_pengguna', 'User::createUser');
    $routes->get('perbaharui_pengguna/(:segment)', 'User::updateUser/$1');
});

$routes->post('admin/simpan_pengguna_ke_db', 'User::saveUserToDB');
$routes->post('admin/perbaharui_pengguna_di_db', 'User::updateUserInDB');
$routes->post('admin/hapus_pengguna_di_db', 'User::removeUserInDB');
$routes->post('admin/simpan_kategori_produk_ke_db', 'CategoryProduct::saveCategoryProductToDB');
$routes->post('admin/perbaharui_kategori_produk_di_db', 'CategoryProduct::updateCategoryProductInDB');
$routes->post('admin/hapus_kategori_produk_di_db', 'CategoryProduct::removeCategoryProductInDB');
$routes->post('admin/simpan_produk_ke_db', 'Product::saveProductToDB');
$routes->post('admin/tampil_produk_detail', 'Product::showProductDetail');
$routes->post('admin/cari_produk', 'Product::showProductSearches');
$routes->post('admin/perbaharui_produk_di_db', 'Product::updateProductInDB');
$routes->post('admin/hapus_harga_produk', 'Product::removeProductPriceInDB');
$routes->post('admin/hapus_produk', 'Product::removeProductsInDB');

$routes->group('kasir', function($routes)
{
    $routes->post('cari_produk', 'Cashier::showProductSearches');
    $routes->post('beli_produk', 'Cashier::buyProduct');
    $routes->post('tampil_transaksi_detail', 'Cashier::showTransactionDetails');
    $routes->post('ubah_jumlah_produk', 'Cashier::updateProductQty');
    $routes->post('hapus_produk_dari_keranjang_belanja', 'Cashier::removeProductFromShoppingCart');
    $routes->post('transaksi_selesai', 'Cashier::finishTransaction');
    $routes->post('transaksi_batal', 'Cashier::cancelTransaction');
    $routes->post('tampil_transaksi_tiga_hari_yang_lalu', 'Cashier::showTransactionsThreeDaysAgo');
    $routes->post('tampil_transaksi_detail_tiga_hari_yang_lalu', 'Cashier::showTransactionDetailsThreeDaysAgo');
    $routes->post('rollback_transaksi_selesai', 'Cashier::finishRollbackTransaction');
    $routes->post('rollback_transaksi_batal', 'Cashier::cancelRollbackTransaction');
});

$routes->post('sign_in', 'SignIn::signIn');
$routes->get('sign_out', 'SignOut::index');

// Default Route, if each route above not match
$routes->get('(:any)', 'SignIn::index', ['filter' => 'hasSignedIn']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
