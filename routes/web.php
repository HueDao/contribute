<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\ProductRecipientController;
use App\Http\Controllers\ShippersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoreController;

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
Route::get('/', [UserLoginController::class, 'index']);
Route::post('/contributor/login', [UserLoginController::class, 'login']);
Route::get('/logout', [UserLoginController::class, 'logout']);

Route::middleware(["owner"])->group(function () {
    Route::get('/contributor/index/{role}', [ContributorController::class, 'index']);
    Route::get('/contributor/edit/{id}', [ContributorController::class, 'edit']);
    Route::get('/contributor/delete/{id}', [ContributorController::class, 'delete']);
    Route::post('/contributor/update/{id}', [ContributorController::class, 'update']);
    Route::post('/contributor/destroy/{id}', [ContributorController::class, 'destroy']);

    Route::get('/admin/index', [AdminController::class, 'index']);
    Route::get('/admin/product', [AdminController::class, 'showProduct']);

    Route::get('/category/create', [CategoryController::class, 'create']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete']);
    // lưu danh mục
    Route::post('/category/store', [CategoryController::class, 'store']);
    // cập nhật danh mục
    Route::post('/category/update/{id}', [CategoryController::class, 'update']);
    // xóa danh mục
    Route::post('/category/destroy/{id}', [CategoryController::class, 'destroy']);
});
Route::get('/contributor/create', [ContributorController::class, 'create']);
Route::post('/contributor/store', [ContributorController::class, 'store']);

Route::middleware(["recipient", "owner"])->group(function () {
    Route::get('/recipients/home', [ContributorController::class, 'registerHome']);
    Route::get('/products/receive', [ProductsController::class, 'receive']);
    Route::get('/recipients/register_category', [ContributorController::class, 'registerCategory']);
    Route::post('/recipients/save_register_category', [ContributorController::class, 'saveRegisterCategory']);
    Route::post('/delete/categoryRegister', [ContributorController::class, 'deleteCategoryRegister']);
    Route::post('/change_status_receive', [ProductsController::class, 'changeStatusReceive']);
});

Route::middleware(["contributor", "owner"])->group(function () {
    
    Route::get('/product/index', [ProductsController::class, 'index']);
    Route::get('/product/create', [ProductsController::class, 'create']);
    Route::post('/product/store', [ProductsController::class, 'store']);
    Route::get('/product/edit/{id}', [ProductsController::class, 'edit']);
    Route::post('/product/update/{id}', [ProductsController::class, 'update']);
    Route::get('/product/delete/{id}', [ProductsController::class, 'delete']);
    Route::post('/product/destroy/{id}', [ProductsController::class, 'destroy']);
    
    Route::get('/category/contribute', [CategoryController::class, 'categoryContribute']);
    Route::get('/recipients/list/{id}', [ContributorController::class, 'listRecipient']);

    Route::get('/product/contribute/{category_id}/{recipient_id}', [ProductsController::class, 'productContribute']);
    Route::post('/contribute', [ProductRecipientController::class, 'store']);

    
});

Route::get('/contributor/infor', [ContributorController::class, 'infor']);


// // lưu sản phẩm
// Route::post('/product/store', [ProductsController::class, 'store']);
// // cập nhật sản phẩm
// Route::post('/product/update/{id}', [ProductsController::class, 'update']);
// // xóa sản phẩm




// Route::get('/category/contribute', [CategoryController::class, 'categoryContribute']);
// Route::get('/product/contribute/{category_id}/{recipient_id}', [ProductsController::class, 'productContribute']);
// Quyên góp sản phẩm
// Route::post('/contribute', [ProductRecipientController::class, 'store']);
//Hiển thị danh sách sản phẩm quyên góp cho người nhận
// Route::get('/products/receive', [ProductsController::class, 'receive']);
//xóa danh mục người nhận đã đăng kí
// Route::post('/delete/categoryRegister', [ContributorController::class, 'deleteCategoryRegister']);
//Chuyển trạng thái sản phẩm sang đã nhận
// Route::post('/change_status_receive', [ProductsController::class, 'changeStatusReceive']);

//Hiển thị danh sách sản phẩm quyên góp cho người nhận
Route::middleware(["ship"])->group(function () {
    Route::get('/ship/index', [ShippersController::class, 'index']);
    Route::post('/ship_receive_order', [ShippersController::class, 'shipReceiveOrder']);
    Route::get('/order_detail/{id}', [ShippersController::class, 'orderDetail']);
    Route::get('/ship/order_receive', [ShippersController::class, 'orderReceive']);
    Route::get('/ship/order_delivery_receive', [ShippersController::class, 'orderDeliveryReceive']);
    Route::get('/ship/list_wait_delivery', [ShippersController::class, 'getListOrderWaitDelivery']);
});

Route::get('/order/index', [StoreController::class, 'index']);
Route::post('/create_order/{type}', [StoreController::class, 'orderCreate']);
Route::get('/order/index_delivery', [StoreController::class, 'indexDelivery']);
// Route::post('/create_order/{type}', [StoreController::class, 'orderCreateDelivery']);
//Lấy danh sách đơn lấy hàng
Route::get('/list_order_contributor', [StoreController::class, 'listOrderContribute']);
//Lấy danh sách đơn nhận hàng
Route::get('/list_order_delivery', [StoreController::class, 'listOrderDelivery']);
//Chi tiết đơn nhận hàng
Route::get('/store/order_detail_contributor/{id}', [StoreController::class, 'orderDetailContributor']);
// Chi tiết đơn giao hàng
Route::get('/store/order_detail_delivery/{id}', [StoreController::class, 'orderDetailDelivery']);
//nhập kho
Route::post('/import_store', [StoreController::class, 'importStore']);

// ship






