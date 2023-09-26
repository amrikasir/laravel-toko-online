<?php
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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// route untuk simple program
Route::get('/sederhana/lihat',[\App\Http\Controllers\SimpleController::class, 'index'])->name('sederhana');
// route simpan data simple program
Route::post('/sederhana/simpan',[\App\Http\Controllers\SimpleController::class, 'simpan'])->name('sederhana.simpan');

Auth::routes();
Route::get('/',[\App\Http\Controllers\user\WelcomeController::class, 'index'])->name('home');
Route::get('/home',[\App\Http\Controllers\user\WelcomeController::class, 'index'])->name('home2');
Route::get('/kontak',[\App\Http\Controllers\user\WelcomeController::class, 'kontak'])->name('kontak');
Route::get('/produk',[\App\Http\Controllers\user\ProdukController::class, 'index'])->name('user.produk');
Route::get('/produk/cari',[\App\Http\Controllers\user\ProdukController::class, 'cari'])->name('user.produk.cari');
Route::get('/kategori/{id}',[\App\Http\Controllers\KategoriController::class, 'produkByKategori'])->name('user.kategori');
Route::get('/produk/{id}',[\App\Http\Controllers\user\ProdukController::class, 'detail'])->name('user.produk.detail');

Route::group(['middleware' => ['auth','checkRole:admin']],function(){    
    Route::get('/admin',[\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/pengaturan/alamat',[\App\Http\Controllers\admin\PengaturanController::class, 'aturalamat'])->name('admin.pengaturan.alamat');
    Route::get('/pengaturan/ubahalamat/{id}',[\App\Http\Controllers\admin\PengaturanController::class, 'ubahalamat'])->name('admin.pengaturan.ubahalamat');
    Route::get('/pengaturan/alamat/getcity/{id}',[\App\Http\Controllers\admin\PengaturanController::class, 'getCity'])->name('admin.pengaturan.getCity');
    Route::post('pengaturan/simpanalamat',[\App\Http\Controllers\admin\PengaturanController::class, 'simpanalamat'])->name('admin.pengaturan.simpanalamat');
    Route::post('pengaturan/updatealamat/{id}',[\App\Http\Controllers\admin\PengaturanController::class, 'updatealamat'])->name('admin.pengaturan.updatealamat');

    Route::get('/admin/categories',[\App\Http\Controllers\admin\CategoriesController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/tambah',[\App\Http\Controllers\admin\CategoriesController::class, 'tambah'])->name('admin.categories.tambah');
    Route::post('/admin/categories/store',[\App\Http\Controllers\admin\CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::post('/admin/categories/update/{id}',[\App\Http\Controllers\admin\CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::get('/admin/categories/edit/{id}',[\App\Http\Controllers\admin\CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::get('/admin/categories/delete/{id}',[\App\Http\Controllers\admin\CategoriesController::class, 'delete'])->name('admin.categories.delete');

    Route::get('/admin/product',[\App\Http\Controllers\admin\ProductController::class, 'index'])->name('admin.product');
    Route::get('/admin/product/tambah',[\App\Http\Controllers\admin\ProductController::class, 'tambah'])->name('admin.product.tambah');
    Route::post('/admin/product/store',[\App\Http\Controllers\admin\ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}',[\App\Http\Controllers\admin\ProductController::class, 'edit'])->name('admin.product.edit');
    Route::get('/admin/product/delete/{id}',[\App\Http\Controllers\admin\ProductController::class, 'delete'])->name('admin.product.delete');
    Route::post('/admin/product/update/{id}',[\App\Http\Controllers\admin\ProductController::class, 'update'])->name('admin.product.update');

    Route::get('/admin/transaksi',[\App\Http\Controllers\admin\TransaksiController::class, 'index'])->name('admin.transaksi');
    Route::get('/admin/transaksi/perludicek',[\App\Http\Controllers\admin\TransaksiController::class, 'perludicek'])->name('admin.transaksi.perludicek');
    Route::get('/admin/transaksi/perludikirim',[\App\Http\Controllers\admin\TransaksiController::class, 'perludikirim'])->name('admin.transaksi.perludikirim');
    Route::get('/admin/transaksi/dikirim',[\App\Http\Controllers\admin\TransaksiController::class, 'dikirim'])->name('admin.transaksi.dikirim');
    Route::get('/admin/transaksi/detail/{id}',[\App\Http\Controllers\admin\TransaksiController::class, 'detail'])->name('admin.transaksi.detail');
    Route::get('/admin/transaksi/konfirmasi/{id}',[\App\Http\Controllers\admin\TransaksiController::class, 'konfirmasi'])->name('admin.transaksi.konfirmasi');
    Route::post('/admin/transaksi/inputresi/{id}',[\App\Http\Controllers\admin\TransaksiController::class, 'inputresi'])->name('admin.transaksi.inputresi');
    Route::get('/admin/transaksi/selesai',[\App\Http\Controllers\admin\TransaksiController::class, 'selesai'])->name('admin.transaksi.selesai');
    Route::get('/admin/transaksi/dibatalkan',[\App\Http\Controllers\admin\TransaksiController::class, 'dibatalkan'])->name('admin.transaksi.dibatalkan');

    Route::get('/admin/rekening',[\App\Http\Controllers\admin\RekeningController::class, 'index'])->name('admin.rekening');
    Route::get('/admin/rekening/edit/{id}',[\App\Http\Controllers\admin\RekeningController::class, 'edit'])->name('admin.rekening.edit');
    Route::get('/admin/rekening/tambah',[\App\Http\Controllers\admin\RekeningController::class, 'tambah'])->name('admin.rekening.tambah');
    Route::post('/admin/rekening/store',[\App\Http\Controllers\admin\RekeningController::class, 'store'])->name('admin.rekening.store');
    Route::get('/admin/rekening/delete/{id}',[\App\Http\Controllers\admin\RekeningController::class, 'delete'])->name('admin.rekening.delete');
    Route::post('/admin/rekening/update/{id}',[\App\Http\Controllers\admin\RekeningController::class, 'update'])->name('admin.rekening.update');

    Route::get('/admin/history',[\App\Http\Controllers\admin\TransaksiController::class, 'history'])->name('admin.history');

    Route::get('/admin/pelanggan',[\App\Http\Controllers\admin\PelangganController::class, 'index'])->name('admin.pelanggan');

    Route::get('/admin/ulasan',[\App\Http\Controllers\admin\ProductController::class, 'ulasan'])->name('admin.ulasan');
});

Route::group(['middleware' => ['auth','checkRole:customer']],function(){
    Route::post('/keranjang/simpan',[\App\Http\Controllers\user\KeranjangController::class, 'simpan'])->name('user.keranjang.simpan');
    Route::get('/keranjang',[\App\Http\Controllers\user\KeranjangController::class, 'index'])->name('user.keranjang');
    Route::post('/keranjang/update',[\App\Http\Controllers\user\KeranjangController::class, 'update'])->name('user.keranjang.update');
    Route::get('/keranjang/delete/{id}',[\App\Http\Controllers\user\KeranjangController::class, 'delete'])->name('user.keranjang.delete');
    Route::get('/alamat',[\App\Http\Controllers\user\AlamatController::class, 'index'])->name('user.alamat');
    Route::get('/getcity/{id}',[\App\Http\Controllers\user\AlamatController::class, 'getCity'])->name('user.alamat.getCity');
    Route::post('/alamat/simpan',[\App\Http\Controllers\user\AlamatController::class, 'simpan'])->name('user.alamat.simpan');
    Route::post('/alamat/update/{id}',[\App\Http\Controllers\user\AlamatController::class, 'update'])->name('user.alamat.update');
    Route::get('/alamat/ubah/{id}',[\App\Http\Controllers\user\AlamatController::class, 'ubah'])->name('user.alamat.ubah');
    Route::get('/checkout',[\App\Http\Controllers\user\CheckoutController::class, 'index'])->name('user.checkout');
    Route::post('/order/simpan',[\App\Http\Controllers\user\OrderController::class, 'simpan'])->name('user.order.simpan');
    Route::get('/order/sukses',[\App\Http\Controllers\user\OrderController::class, 'sukses'])->name('user.order.sukses');
    Route::get('/order',[\App\Http\Controllers\user\OrderController::class, 'index'])->name('user.order');
    Route::get('/order/detail/{id}',[\App\Http\Controllers\user\OrderController::class, 'detail'])->name('user.order.detail');
    Route::get('/order/pesananditerima/{id}',[\App\Http\Controllers\user\OrderController::class, 'pesananditerima'])->name('user.order.pesananditerima');
    Route::get('/order/pesanandibatalkan/{id}',[\App\Http\Controllers\user\OrderController::class, 'pesanandibatalkan'])->name('user.order.pesanandibatalkan');
    Route::get('/order/pembayaran/{id}',[\App\Http\Controllers\user\OrderController::class, 'pembayaran'])->name('user.order.pembayaran');
    Route::post('/order/kirimbukti/{id}',[\App\Http\Controllers\user\OrderController::class, 'kirimbukti'])->name('user.order.kirimbukti');

    Route::get('/order/invoice/{id}',[\App\Http\Controllers\user\OrderController::class, 'invoice'])->name('user.order.invoice');

    Route::post('/ulasan/simpan',[\App\Http\Controllers\user\ProdukController::class, 'ulasan'])->name('user.ulasan.simpan');
    Route::get('/ulasan/get/{id?}',[\App\Http\Controllers\user\ProdukController::class, 'ulasanproduk'])->name('user.ulasan.get');
});

