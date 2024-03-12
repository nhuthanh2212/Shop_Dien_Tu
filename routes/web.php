<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//frontend
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/trang-chu', [HomeController::class, 'index'])->name('home');

//send email
Route::get('/send-email', [HomeController::class, 'send_email']);

//login facebook
Route::get('/login-facebook', [AdminController::class, 'login_facebook']);
Route::get('/admin/callback', [AdminController::class, 'callback_facebook']);

//tim kiem

Route::post('/tim-kiem', [HomeController::class, 'search']);


//danh muc san pham trang chu
Route::get('/danh-muc/{id}', [HomeController::class, 'show']);

//thuong hieu san pham trang chu
Route::get('/thuong-hieu/{id}', [HomeController::class, 'show_brand']);

//chi tiet san pham trang chu
Route::get('/chi-tiet/{id}', [HomeController::class, 'show_details_product']);

//Gio Hang
Route::post('/save-cart', [CartController::class, 'create']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);

Route::get('/show-cart', [CartController::class, 'index']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);

Route::get('/delete-to-cart/{rowID}', [CartController::class, 'destroy']);
Route::post('/update-cart-qty', [CartController::class, 'edit']);

Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::get('/deleted-product/{session_id}', [CartController::class, 'deleted_product']);

Route::get('/delete-all-product', [CartController::class, 'delete_all_product']);

//checkout
Route::post('/login-customer', [CheckoutController::class, 'login']);

Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);

Route::post('/add-customer', [CheckoutController::class, 'store']);

Route::get('/checkout', [CheckoutController::class, 'checkout']);

Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);

Route::get('/payment', [CheckoutController::class, 'payment']);

Route::post('/order-place', [CheckoutController::class, 'order_place']);

Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);

//phi van chuyen home

Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);

Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee']);

Route::get('/delete-fee', [CheckoutController::class, 'delete_fee']);


//Coupon Mã Giảm Giá
Route::post('/check-coupon', [CouponController::class, 'check_coupon']);
Route::get('/add-coupon', [CouponController::class, 'add_coupon']);
Route::post('/save-coupon', [CouponController::class, 'store_coupon']);

Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
Route::get('/delete-coupon/{id}',[CouponController::class, 'destroy']);
Route::get('/unset-coupon',[CouponController::class, 'unset_coupon']);


//Admin
Route::get('/admin', [AdminController::class, 'login']);
Route::get('/dashboard', [AdminController::class, 'index']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

//category
Route::get('/add-category', [CategoryController::class, 'create']);
Route::get('/list-category', [CategoryController::class, 'index']);
Route::post('/save-category',[CategoryController::class, 'store']);
Route::get('/edit-category/{id}',[CategoryController::class, 'edit']);
Route::post('/update-category/{id}',[CategoryController::class, 'update']);
Route::get('/delete-category/{id}',[CategoryController::class, 'destroy']);

Route::get('/unactive-category/{id}', [CategoryController::class, 'unactive']);
Route::get('/active-category/{id}', [CategoryController::class, 'active']);

Route::post('/import-csv',[CategoryController::class, 'import_csv']);
Route::post('/export-csv',[CategoryController::class, 'export_csv']);

//brand
Route::get('/add-brand', [BrandController::class, 'create']);
Route::get('/list-brand', [BrandController::class, 'index']);
Route::post('/save-brand',[BrandController::class, 'store']);
Route::get('/edit-brand/{id}',[BrandController::class, 'edit']);
Route::post('/update-brand/{id}',[BrandController::class, 'update']);
Route::get('/delete-brand/{id}',[BrandController::class, 'destroy']);

Route::get('/unactive-brand/{id}', [BrandController::class, 'unactive']);
Route::get('/active-brand/{id}', [BrandController::class, 'active']);

//product
Route::get('/add-product', [ProductController::class, 'create']);
Route::get('/list-product', [ProductController::class, 'index']);
Route::post('/save-product',[ProductController::class, 'store']);
Route::get('/edit-product/{id}',[ProductController::class, 'edit']);
Route::post('/update-product/{id}',[ProductController::class, 'update']);
Route::get('/delete-product/{id}',[ProductController::class, 'destroy']);

Route::get('/unactive-product/{id}', [ProductController::class, 'unactive']);
Route::get('/active-product/{id}', [ProductController::class, 'active']);

//Đơn hàng

Route::get('/manage-order', [OrderController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);

// Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
// Route::get('/view-order/{id}', [CheckoutController::class, 'show']);

//QL vận chuyển delivery
Route::get('/delivery', [DeliveryController::class, 'add_delivery']);

Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
Route::post('/list-delivery', [DeliveryController::class, 'list_delivery']);
Route::post('/update-feeship', [DeliveryController::class, 'update_feeship']);

//banner

Route::get('/list-banner', [BannerController::class, 'list_banner']);

Route::get('/manade-banner', [BannerController::class, 'manade_banner']);
Route::post('/save-slider', [BannerController::class, 'save_slider']);

Route::get('/unactive-slider/{id}', [BannerController::class, 'unactive']);
Route::get('/active-slider/{id}', [BannerController::class, 'active']);

Route::get('/delete-slider/{id}',[BannerController::class, 'delete_slider']);
