<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsModel;
use App\Helper\SessionHelper;

class CategoryController extends Controller
{
    public function index()
    {   
        $categorys = CategoryModel::all();
        return view('category.index', ['categorys' => $categorys]);
    }

    public function create() {
        return view("category.create");
    }

    public function store(Request $request) {
        $category_name = $request->input('category_name', '');
        $category_desc = $request->input('category_desc', '');
        // $pathcategoryImage = $request->file('category_image')->store('public/categoryimages');
        $category = new CategoryModel();
        $category->category_name = $category_name;
        $category->category_desc = $category_desc;
        $category->category_image = "aa";

        // lưu sản phẩm
        $category->save();

        // chuyển hướng về trang category/index
        return redirect("/category/index")->with('status', 'thêm sản phẩm thành công !');
    }

    public function edit($id) {
        $category = CategoryModel::findOrFail($id);
        $data = [];
        $data["category"] = $category;
        return view("category.edit", $data);
    }

    public function update(Request $request, $id) {
        $category_name = $request->input('category_name', '');
        $category_desc = $request->input('category_desc', '');
        // $pathcategoryImage = $request->file('category_image')->store('public/categoryimages');
        // lấy đối tượng model dựa trên biến $id
        $category = categoryModel::findOrFail($id);

        $category->category_name = $category_name;
        $category->category_desc = $category_desc;
        $category->category_image = "aa";
        // lưu sản phẩm
        $category->save();
        // chuyển hướng về trang /category/edit/id
        return redirect("/category/index")->with('status', 'cập nhật danh mục thành công !');
    }

    public function delete($id) {
        $category = categoryModel::findOrFail($id);
        // truyền dữ liệu xuống view
        $data = [];
        $data["category"] = $category;
        return view("category.delete", $data);
    }

     // xóa sản phẩm thật sự trong CSDL
    public function destroy($id) {
      // lấy đối tượng model dựa trên biến $id
      $category = CategoryModel::findOrFail($id);
      $category->delete();
      // chuyển hướng về trang /backend/category/index
      return redirect("/category/index")->with('status', 'xóa danh mục thành công !');
    }

    public function categoryContribute(SessionHelper $sessionHelper) {
        $user_id = $sessionHelper->get()["id"];
      $categories_id = ProductsModel::select('category_id')->where('user_id', $user_id)->get();
      $categories = CategoryModel::whereIn('id',$categories_id)->get();
      $data = [];
      $data['categories'] = $categories;
      return view('category.contribute', $data);
    }
}
