<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContributorModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ObjectsModel;
use App\Models\CategoryModel;
use App\Models\CategoryUserModel;

class ContributorController extends Controller
{
  public function index(Request $request)
  {   
    $sort = $request->query('contributor_sort', "");
    $searchKeyword = $request->query('contributor_name', "");
    $queryORM = ContributorModel::where('name', "LIKE", "%".$searchKeyword."%");
    if ($sort == "name_asc") {
      $queryORM->orderBy('name', 'asc');
    }
    if ($sort == "name_desc") {
      $queryORM->orderBy('name', 'desc');
    }
    $contributors = $queryORM->paginate(10);
    $data = [];
    $data['contributors'] = $contributors;
    $data["searchKeyword"] = $searchKeyword;
    $data["sort"] = $sort;
    return view('contributors.index', $data);
  }

  public function create(){
    $objects = ObjectsModel::all();
    $data["objects"] = $objects; 
    return view('contributors.create', $data);
  }
  public function store(Request $request) {
    // validate dữ liệu
    $validatedData = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:contributors',
      'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
      'password_confirmation' => 'required|min:6',
      'desc' => 'required',
      'role' => 'required',
    ]);
    $name = $request->input('name', '');
    $email = $request->input('email', '');
    $password = $request->input('password', '');
    $desc = $request->input('desc', '');
    $address = $request->input('address', '');
    $number_phone = $request->input('desc', '');
    $role = $request->input('role', 0);
    $contributor = new ContributorModel();
    $contributor->name = $name;
    $contributor->email = $email;
    $contributor->password = Hash::make($password);
    $contributor->desc = $desc;
    $contributor->address = $address;
    $contributor->number_phone = $number_phone;
    $contributor->role = $role;
    $contributor->save();
    return redirect("/contributor/login")->with('status', 'Đăng kí người đóng góp thành công !');
  }

  public function edit($id) {
    $contributor = ContributorModel::findOrFail($id);
    $data = [];
    $data["contributor"] = $contributor;
    return view("contributors.edit", $data);
  }

  public function update(Request $request, $id) {
    $name = $request->input('name', '');
    $email = $request->input('email', '');
    $desc = $request->input('desc', '');
    $address = $request->input('address', '');
    $number_phone = $request->input('number_phone', '');
    $contributor = ContributorModel::findOrFail($id);
    $contributor->name = $name;
    $contributor->email = $email;
    $contributor->desc = $desc;
    $contributor->address = $address;
    $contributor->number_phone = $number_phone;
    $contributor->save();
    return redirect("/contributor/index")->with('status', 'cập nhật sản phẩm thành công !');
  }

  public function delete($id) {
    $contributor = ContributorModel::findOrFail($id);
    // truyền dữ liệu xuống view
    $data = [];
    $data["contributor"] = $contributor;
    return view("contributors.delete", $data);
  }

  // xóa sản phẩm thật sự trong CSDL
  public function destroy($id) {
    // lấy đối tượng model dựa trên biến $id
    $contributor = ContributorModel::findOrFail($id);
    $contributor->delete();
    return redirect("/contributor/index")->with('status', 'xóa sản phẩm thành công !');
  }

  public function registerHome() {
    return view("recipients.home");
  }
  public function registerCategory() {
    $categories = CategoryModel::all();
    $data["categories"] = $categories; 
    return view('recipients.register_category', $data);
  }

  public function saveRegisterCategory(Request $request) {
    $user_id = session('contributor_login', false)['id'];
    $loop = $request->get('category_id');
    foreach ($loop as $value){
        $category_user = new CategoryUserModel;
        $category_user->user_id = $user_id;
        $category_user->category_id = $value;
        $category_user->save();
    }
    return redirect('/recipients/home');
  }

  public function listRepicient(Request $request) {   
    $sort = $request->query('contributor_sort', "");
    $searchKeyword = $request->query('contributor_name', "");
    $queryORM = ContributorModel::where('name', "LIKE", "%".$searchKeyword."%")->where('role',2);
    if ($sort == "name_asc") {
      $queryORM->orderBy('name', 'asc');
    }
    if ($sort == "name_desc") {
      $queryORM->orderBy('name', 'desc');
    }
    // $contributors = $queryORM->paginate(10);
    $contributors = \App\Models\ContributorModel::with('categoryUsers')->where('role',2)->get();
    foreach ($contributors as $c) {
      dd($c);
    }
    die;
    $data = [];
    $data['contributors'] = $contributors;
    $data["searchKeyword"] = $searchKeyword;
    $data["sort"] = $sort;
    $category = CategoryUserModel::all();
    return view('recipients.list', $data);
  }
}
