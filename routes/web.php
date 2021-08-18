<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\ProductRecipientController;

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

Route::middleware(["owner"])->group(function () {
    Route::get('/contributor/index', [ContributorController::class, 'index']);
    Route::get('/contributor/create', [ContributorController::class, 'create']);
    Route::get('/contributor/edit/{id}', [ContributorController::class, 'edit']);
    Route::get('/contributor/delete/{id}', [ContributorController::class, 'delete']);
    Route::post('/contributor/store', [ContributorController::class, 'store']);
    Route::post('/contributor/update/{id}', [ContributorController::class, 'update']);
    Route::post('/contributor/destroy/{id}', [ContributorController::class, 'destroy']);
});

Route::middleware(["recipient", "owner"])->group(function () {
    Route::get('/recipients/home', [ContributorController::class, 'registerHome']);
    Route::get('/recipients/register_category', [ContributorController::class, 'registerCategory']);
    Route::post('/recipients/save_register_category', [ContributorController::class, 'saveRegisterCategory']);
    Route::get('/recipients/list/{id}', [ContributorController::class, 'listRecipient']);
});

Route::middleware(["contributor", "owner"])->group(function () {
    Route::get('/contributor/infor', [ContributorController::class, 'infor']);
    Route::get('/product/index', [ProductsController::class, 'index']);
    Route::get('/product/create', [ProductsController::class, 'create']);
    Route::get('/product/edit/{id}', [ProductsController::class, 'edit']);
    Route::get('/product/delete/{id}', [ProductsController::class, 'delete']);
});

Route::middleware(["ship", "owner"])->group(function () {

});


// lưu sản phẩm
Route::post('/product/store', [ProductsController::class, 'store']);
// cập nhật sản phẩm
Route::post('/product/update/{id}', [ProductsController::class, 'update']);
// xóa sản phẩm
Route::post('/product/destroy/{id}', [ProductsController::class, 'destroy']);

Route::get('/category/create', [CategoryController::class, 'create']);
Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
Route::get('/category/delete/{id}', [CategoryController::class, 'delete']);
// lưu danh mục
Route::post('/category/store', [CategoryController::class, 'store']);
// cập nhật danh mục
Route::post('/category/update/{id}', [CategoryController::class, 'update']);
// xóa danh mục
Route::post('/category/destroy/{id}', [CategoryController::class, 'destroy']);

Route::get('/', [UserLoginController::class, 'index']);
Route::get('/login', [UserLoginController::class, 'index']);
Route::post('/contributor/login', [UserLoginController::class, 'login']);
Route::get('/logout', [UserLoginController::class, 'logout']);


Route::get('/category/contribute', [CategoryController::class, 'categoryContribute']);
Route::get('/product/contribute/{category_id}/{recipient_id}', [ProductsController::class, 'productContribute']);
// Quyên góp sản phẩm
Route::post('/contribute', [ProductRecipientController::class, 'store']);
//Hiển thị danh sách sản phẩm quyên góp cho người nhận
Route::get('/products/receive', [ProductsController::class, 'receive']);
//xóa danh mục người nhận đã đăng kí
Route::post('/delete/categoryRegister', [ContributorController::class, 'deleteCategoryRegister']);
//Chuyển trạng thái sản phẩm sang đã nhận
Route::post('/change_status_receive', [ProductsController::class, 'changeStatusReceive']);




