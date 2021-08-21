<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use App\Models\CategoryModel;
use App\Models\StatusProductModel;
use App\Helper\SessionHelper;

class ProductsController extends Controller {
  public function index(Request $request, SessionHelper $sessionHelper) {
    $user_id = $sessionHelper->get()["id"];
    $sort = $request->query('product_sort', "");
    $searchKeyword = $request->query('product_name', "");
    $category_id = (int) $request->query('category_id', 0);
    $status_id = (int) $request->query('product_status', 0);
    $queryORM = ProductsModel::where('product_name', "LIKE", "%".$searchKeyword."%")
                ->where('user_id',$user_id)
                ->join('category','category.id','=','category_id')
                ->join('status_products','status','status_products.id')
                ->orderBy('products.created_at', 'desc')
                ->select('products.id','product_name','product_quantity','product_enpiry','product_desc','date_contribute','status_products.status_name','category.category_name');
    if($category_id != 0) {
      $queryORM = $queryORM->where('category_id', $category_id);
    }
    if($status_id != 0) {
      $queryORM = $queryORM->where('status_products.id',  $status_id);
    }

    if ($sort == "name_asc") {
      $queryORM = $queryORM->orderBy('product_name', 'asc');
    }
    if ($sort == "name_desc") {
      $queryORM->orderBy('product_name', 'desc');
    }
    if ($sort == "quantity_asc") {
      $queryORM->orderBy('product_quantity', 'asc');
    }
    if ($sort == "quantity_desc") {
      $queryORM->orderBy('product_quantity', 'desc');
    }
    if ($sort == "product_entiry_asc") {
      $queryORM->orderBy('product_entiry', 'asc');
    }
    if ($sort == "product_entiry_desc") {
      $queryORM->orderBy('product_entiry', 'desc');
    }
    if ($sort == "date_contribute_asc") {
      $queryORM->orderBy('date_contribute', 'asc');
    }
    if ($sort == "date_contribute_desc") {
      $queryORM->orderBy('date_contribute', 'desc');
    }
    $products = $queryORM->paginate(10);
    $data = [];
    $data['products'] = $products;
    $data["searchKeyword"] = $searchKeyword;
    $data["category_id"] = $category_id;
    $data["sort"] = $sort;
    $categories = CategoryModel::all();
    $data["categories"] = $categories;
    $status = StatusProductModel::all();
    $data["status"] = $status;
    $data['stt'] = 0;
    return view('products.index', $data);
  }

  public function create() {
    $data = [];
    $categories = CategoryModel::all();
    $data["categories"] = $categories;
    return view("products.create", $data);
  }

  public function store(Request $request, SessionHelper $sessionHelper) {
    $validatedData = $request->validate([
      'product_name' => 'required',
      'category_id' => 'required|not_in:0',
      'product_desc' => 'required',
      'product_quantity' => 'required|integer|min:1|not_in:0',
      'date_contribute' =>  ['required', 'date_format:m/d/Y', 'before_or_equal:product_enpiry'],
      'product_enpiry'  => ['required', 'date_format:m/d/Y']
   ]);
    $user_id = $sessionHelper->get()["id"];
    $product_name = $request->input('product_name', '');
    $category_id = (int) $request->input('category_id', '');
    $product_quantity = $request->input('product_quantity', '');
    $product_desc = $request->input('product_desc', '');
    $product_enpiry = $request->input('product_enpiry','');
    $date_contribute = $request->input('date_contribute', '');
    $product = new ProductsModel();
    $product->user_id = $user_id;
    $product->product_name = $product_name;
    $product->category_id = $category_id;
    $product->product_desc = $product_desc;
    $product->product_enpiry = date('Y-m-d H:i:s', strtotime($product_enpiry));
    $product->product_quantity = $product_quantity;
    $product->date_contribute =  date('Y-m-d H:i:s', strtotime($date_contribute));
    $product->status = 1;
    $product->save();
    return redirect("/product/index")->with('infor', 'Thêm sản phẩm thành công !');
  }

  public function edit($id) {
    $product = ProductsModel::findOrFail($id);
    $data = [];
    $data["product"] = $product;
    $categories = CategoryModel::all();
    $data["categories"] = $categories;
    return view("products.edit", $data);
  }

  public function update(Request $request, $id) {
    $validatedData = $request->validate([
      'product_name' => 'required',
      'category_id' => 'required|not_in:0',
      'product_desc' => 'required',
      'product_quantity' => 'required|integer|min:1|not_in:0',
      'date_contribute' =>  ['required', 'date_format:m/d/Y', 'before_or_equal:product_enpiry'],
      'product_enpiry'  => ['required', 'date_format:m/d/Y']
   ]);
    $product_name = $request->input('product_name', '');
    $category_id = (int) $request->input('category_id', 0);
    $product_quantity = $request->input('product_quantity', 0);
    $product_desc = $request->input('product_desc', '');
    $product_enpiry = $request->input('product_enpiry', '');
    $date_contribute = $request->input('date_contribute', '');
    $product = ProductsModel::findOrFail($id);
    $product->product_name = $product_name;
    $product->category_id = $category_id;
    $product->product_desc = $product_desc;
    $product->product_enpiry = date('Y-m-d H:i:s', strtotime($product_enpiry));
    $product->product_quantity = $product_quantity;
    $product->date_contribute = date('Y-m-d H:i:s', strtotime($date_contribute));
    $product->save();
    return redirect("/product/index")->with('infor', 'Cập nhật sản phẩm thành công !');
  }

  public function delete($id) {
    $product = ProductsModel::findOrFail($id);
    $data = [];
    $data["product"] = $product;
    // truyền dữ liệu xuống view
    return view("products.delete", $data);
  }

  // xóa sản phẩm thật sự trong CSDL
  public function destroy($id) {
    // lấy đối tượng model dựa trên biến $id
    $product = ProductsModel::findOrFail($id);
    if($product['status'] !== 1 || $product['status'] !== 2) {
      return redirect("/product/index")->with('note', 'Không thể xóa sản phẩm do sản phẩm đang được vận chuyển hoặc đã được nhận!');
    }
    $product->delete();
    return redirect("/product/index")->with('infor', 'Xóa sản phẩm thành công!');
  }

  public function productContribute(SessionHelper $sessionHelper, $category_id, $recipient_id) {
    $user_id = $sessionHelper->get()["id"];
    $products = ProductsModel::where('user_id', $user_id)->where('category_id', $category_id)
                            ->join('status_products','status','status_products.id')
                            ->where('status_products.id', 1)
                            ->select('products.id','product_name','product_quantity','product_enpiry','product_desc','date_contribute','status_products.status_name')
                            ->get();
    $data = [];
    $data['products'] = $products;
    $data['recipient_id'] = $recipient_id;
    $data['stt'] = 0;
    return view('products.contribute', $data);
  }
  
  public function receive(Request $request) {
    $user_id = session('contributor_login', false)['id'];
    $sort = $request->query('product_sort', "");
    $searchKeyword = $request->query('product_name', "");
    $category_id = (int) $request->query('category_id', 0);
    $status_id = (int) $request->query('product_status', 0);
    $queryORM = \DB::table('products')
    
                ->where('product_name', "LIKE", "%".$searchKeyword."%")
                ->join('product_recipient', 'product_recipient.product_id', '=', 'products.id')
                ->join('contributors', 'contributors.id', '=', 'products.user_id')
                ->join('status_products', 'status_products.id', '=', 'products.status')
                ->select('products.id','product_name','product_quantity','product_desc', 'product_enpiry', 'date_contribute','status_name', 'contributors.name', 'contributors.address');
    if($category_id != 0) {
      $queryORM = $queryORM->where('category_id', $category_id);
    }
    if($status_id != 0) {
      $queryORM = $queryORM->where('status_products.id',  $status_id);
    }
    if ($sort == "name_asc") {
      $queryORM->orderBy('product_name', 'asc');
    }
    if ($sort == "name_desc") {
      $queryORM->orderBy('product_name', 'desc');
    }
    if ($sort == "quantity_asc") {
      $queryORM->orderBy('product_quantity', 'asc');
    }
    if ($sort == "quantity_desc") {
      $queryORM->orderBy('product_quantity', 'desc');
    }
    $products = $queryORM->get();
    $data = [];
    $data['products'] = $products;
    $data["searchKeyword"] = $searchKeyword;
    $data["category_id"] = $category_id;
    $data["sort"] = $sort;
    $categories = CategoryModel::all();
    $data["categories"] = $categories;
    $status_filter = StatusProductModel::all();
    $data["status_filter"] = $status_filter;
    $data['stt'] = 0;
    return view('products.receive', $data);
  }

  public function changeStatusReceive(Request $request) {
    $loop = $request->get('product_id');
    if(is_null($loop)) {
      return redirect('/products/receive')->with('error', 'Chưa chọn sản phẩm để xác nhận đã nhận!');
    }
    foreach ($loop as $value){
      $category_user = ProductsModel::where('id', $value)
                                      ->update(['status'=>4]);
    }
    return redirect('/products/receive')->with('infor', 'Xác nhận thực phẩm thành công!');
  }
}
