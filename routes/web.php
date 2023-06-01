<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/regencies', 'CountryController@regencies');
Route::get('/districts', 'CountryController@districts');
Route::get('/village', 'CountryController@villages');

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'cache-clear';
});

Route::get('/maintenance-down', function () {
    Artisan::call('down');
    return 'maintenance down';
});


Route::get('/maintenance-up', function () {
    Artisan::call('up');
    return 'maintenance up';
});



Route::get('/','HomeController@index')->name('home.index');
Route::get('/kategori/{slug}','KategoriController@index')->name('kategori.index');
Route::get('/produk/{slug}','ProdukController@detail')->name('produk.detail');

Route::get('/shop','ShopController@index')->name('shop.index');

Route::get('/search','ProdukController@search')->name('search.index');


Route::middleware(['auth'])->group(function () {
    Route::get('transaksi','TransaksiController@index')->name('transaksi.index');
    Route::get('transaksi/detail/{id}','TransaksiController@detail')->name('transaksi.detail');

    Route::get('profil','ProfilController@index')->name('profil.index');
    Route::post('profil/update-password','ProfilController@updatePassword')->name('update.password');
    Route::post('profil/update','ProfilController@update')->name('update.profil');

    Route::get('cart','CartController@index')->name('cart.index');
    Route::post('add/cart/{id}/{variant}','CartController@addCart')->name('add.cart');
    Route::get('delete/cart/{id}','CartController@delete')->name('delete.cart');

    Route::get('/checkout','CheckoutController@index')->name('checkout.index');
    Route::get('/kota','CheckoutController@getKota')->name('fetch.kota');
    Route::post('/ongkir','CheckoutController@ongkir')->name('get.ongkir');

    Route::post('/checkout','CheckoutController@checkoutPost')->name('checkout.post');

    Route::get('/success','HomeController@success')->name('success.index');



});


Route::prefix('owner')->middleware(['owner','auth'])->group(function () {
    Route::get('dashboard','Owner\DashboardController@index')->name('owner.dashboard.index');

    // CRUD ADMIN
    Route::get('admin', 'Owner\AdminController@index')->name('owner.admin.index');
    Route::post('admin/create', 'Owner\AdminController@store')->name('owner.admin.store');
    Route::post('admin/update/{id}', 'Owner\AdminController@update')->name('owner.admin.update');
    Route::delete('admin/delete/{id}', 'Owner\AdminController@delete')->name('owner.admin.delete');
     // CRUD KURIR
     Route::get('kurir', 'Owner\KurirController@index')->name('owner.kurir.index');
     Route::post('kurir/create', 'Owner\KurirController@store')->name('owner.kurir.store');
     Route::post('kurir/update/{id}', 'Owner\KurirController@update')->name('owner.kurir.update');
     Route::delete('kurir/delete/{id}', 'Owner\KurirController@delete')->name('owner.kurir.delete');

    // CRUD CUSTOMER
    Route::get('customer', 'Owner\CustomerController@index')->name('owner.customer.index');
    Route::post('customer/create', 'Owner\CustomerController@store')->name('owner.customer.store');
    Route::post('customer/update/{id}', 'Owner\CustomerController@update')->name('owner.customer.update');
    Route::delete('customer/delete/{id}', 'Owner\CustomerController@delete')->name('owner.customer.delete');

    // CRUD KATEGORI
    Route::get('kategori', 'Owner\KategoriController@index')->name('owner.kategori.index');
    Route::post('kategori/create', 'Owner\KategoriController@store')->name('owner.kategori.store');
    Route::post('kategori/update/{id}', 'Owner\KategoriController@update')->name('owner.kategori.update');
    Route::delete('kategori/delete/{id}', 'Owner\KategoriController@delete')->name('owner.kategori.delete');


    // CRUD PRODUK
    // Route::get('produk/list-produk', 'Owner\ProdukController@listProduk')->name('admin.produk.list');
    Route::get('produk', 'Owner\ProdukController@index')->name('owner.produk.index');
    Route::post('produk/create', 'Owner\ProdukController@store')->name('owner.produk.store');
    Route::post('produk/update/{id}', 'Owner\ProdukController@update')->name('owner.produk.update');
    Route::delete('produk/delete/{id}', 'Owner\ProdukController@delete')->name('owner.produk.delete');

    // Transaksi
    Route::get('transaksi', 'Owner\TransaksiController@index')->name('owner.transaksi.index');
    Route::get('transaksi/detail/{id}', 'Owner\TransaksiController@detail')->name('owner.transaksi.detail');
    Route::post('transaksi/update/{id}', 'Owner\TransaksiController@update')->name('owner.transaksi.update');
    Route::post('transaksi/update/resi/{id}', 'Owner\TransaksiController@updateResi')->name('owner.transaksi.update.resi');


    Route::post('terima/order/{transaksi_id}','Owner\TransaksiController@terima')->name('owner.transaksi.terima.order');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('dashboard','Owner\DashboardController@index')->name('admin.dashboard.index');

    // CRUD CUSTOMER
    Route::get('customer', 'Owner\CustomerController@index')->name('admin.customer.index');
    Route::post('customer/create', 'Owner\CustomerController@store')->name('admin.customer.store');
    Route::post('customer/update/{id}', 'Owner\CustomerController@update')->name('admin.customer.update');
    Route::delete('customer/delete/{id}', 'Owner\CustomerController@delete')->name('admin.customer.delete');

    // CRUD KATEGORI
    Route::get('kategori', 'Owner\KategoriController@index')->name('admin.kategori.index');
    Route::post('kategori/create', 'Owner\KategoriController@store')->name('admin.kategori.store');
    Route::post('kategori/update/{id}', 'Owner\KategoriController@update')->name('admin.kategori.update');
    Route::delete('kategori/delete/{id}', 'Owner\KategoriController@delete')->name('admin.kategori.delete');


    // CRUD PRODUK
    // Route::get('produk/list-produk', 'Owner\ProdukController@listProduk')->name('admin.produk.list');
    Route::get('produk', 'Owner\ProdukController@index')->name('admin.produk.index');
    Route::post('produk/create', 'Owner\ProdukController@store')->name('admin.produk.store');
    Route::post('produk/update/{id}', 'Owner\ProdukController@update')->name('admin.produk.update');
    Route::delete('produk/delete/{id}', 'Owner\ProdukController@delete')->name('admin.produk.delete');

    // Transaksi
    Route::get('transaksi', 'Owner\TransaksiController@index')->name('admin.transaksi.index');
    Route::get('transaksi/detail/{id}', 'Owner\TransaksiController@detail')->name('admin.transaksi.detail');
    Route::post('transaksi/update/{id}', 'Owner\TransaksiController@update')->name('admin.transaksi.update');
    Route::post('transaksi/update/resi/{id}', 'Owner\TransaksiController@updateResi')->name('admin.transaksi.update.resi');

    Route::post('terima/order/{transaksi_id}','Owner\TransaksiController@terima')->name('admin.transaksi.terima.order');

    Route::post('transaksi/update/{id}', 'Owner\TransaksiController@update')->name('admin.transaksi.update');
});


Route::prefix('kurir')->middleware(['auth'])->group(function () {
    Route::get('dashboard','Kurir\DashboardController@index')->name('kurir.dashboard.index');
    Route::post('kirim/{transaksi_id}', 'Kurir\DashboardController@kirim')->name('kurir.kirim.barang');

});



Auth::routes();

Route::post('/midtrans/callback', 'MidtransController@callback')->name('midtrans.callback');
