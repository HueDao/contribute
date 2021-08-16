<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsModel;
use App\Models\CategoryModel;

class ProductsController extends Controller
{
    
    public function index(Request $request)
    {   
      $sort = $request->query('product_sort', "");
      $searchKeyword = $request->query('product_name', "");
      $category_id = (int) $request->query('category_id', 0);
      $queryORM = ProductsModel::where('product_name', "LIKE", "%".$searchKeyword."%");
      if($category_id != 0) {
        $queryORM = $queryORM->where('category_id', $category_id);
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
      $products = $queryORM->paginate(10);
      $data = [];
      $data['products'] = $products;
      $data["searchKeyword"] = $searchKeyword;
      $data["category_id"] = $category_id;
      $data["sort"] = $sort;
      $categories = CategoryModel::all();
      $data["categories"] = $categories;
      return view('products.index', $data);
    }

    public function create() {
      $data = [];
      $categories = CategoryModel::all();
      $data["categories"] = $categories;
      return view("products.create", $data);
    }

    public function store(Request $request) {
    //   $validatedData = $request->validate([
    //     'product_name' => 'required',
    //     'category_id' => 'required',
    //     'product_expiry' => 'required',
    //     'product_desc' => 'required',
    //     'product_quantity' => 'required',
    //  ]);
      $product_name = $request->input('product_name', '');
      $category_id = (int) $request->input('category_id', 0);
      $product_quantity = $request->input('product_quantity', 0);
      $product_desc = $request->input('product_desc', '');
      $product_enpiry = $request->input('product_enpiry');
      if(!$product_enpiry) {
          $product_enpiry = 'unlimited';
      }
      $product = new ProductsModel();
      $product->product_name = $product_name;
      $product->category_id = $category_id;
      $product->product_desc = $product_desc;
      $product->product_enpiry = $product_enpiry;
      $product->product_quantity = $product_quantity;
      $product->product_image = "aa";
      $product->save();
      return redirect("/product/index")->with('status', 'thêm sản phẩm thành công !');
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
        $product_name = $request->input('product_name', '');
        $category_id = (int) $request->input('category_id', 0);
        $product_quantity = $request->input('product_quantity', 0);
        $product_desc = $request->input('product_desc', '');
        $product_enpiry = $request->input('product_enpiry');
        if(!$product_enpiry) {
            $product_enpiry = 'unlimited';
        }
        $product = ProductsModel::findOrFail($id);
        $product->product_name = $product_name;
        $product->category_id = $category_id;
        $product->product_desc = $product_desc;
        $product->product_enpiry = $product_enpiry;
        $product->product_quantity = $product_quantity;
        $product->product_image = "aa";
        $product->save();
        return redirect("/product/index")->with('status', 'cập nhật sản phẩm thành công !');
    }

    public function delete($id) {
        $product = ProductsModel::findOrFail($id);
        // truyền dữ liệu xuống view
        $data = [];
        $data["product"] = $product;
        return view("products.delete", $data);
    }

     // xóa sản phẩm thật sự trong CSDL
    public function destroy($id) {
      // lấy đối tượng model dựa trên biến $id
      $product = ProductsModel::findOrFail($id);
      $product->delete();
      // chuyển hướng về trang /backend/product/index
      return redirect("/product/index")->with('status', 'xóa sản phẩm thành công !');
    }
}
