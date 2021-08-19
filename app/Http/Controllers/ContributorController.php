<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContributorModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ObjectsModel;
use App\Models\CategoryModel;
use App\Models\CategoryUserModel;
use App\Helper\SessionHelper;

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

  public function infor(SessionHelper $sessionHelper) {
    $user_id = $sessionHelper->get()["id"];
    $data = [];
    $role = ContributorModel::where('id', $user_id)->pluck("role");
    foreach ( $role as $r) {
      if($r == 1) {
        $data['url'] = '/product/index';
      } elseif ($r == 2) {
        $data['url'] = '/recipients/home';
      }
    }
    $contributor = ContributorModel::findOrFail($user_id);
    $data["contributor"] = $contributor;
    return view('contributors.infor', $data);

  }
  public function registerHome() {
    return view("recipients.home");
  }
  public function registerCategory(SessionHelper $sessionHelper) {
     $user_id = $sessionHelper->get()["id"];
    $categories = CategoryModel::all();
    $data["categories"] = $categories;
    $categories_registered = CategoryUserModel::join('category','category.id','=','category_user.category_id')
                                        ->where('user_id', $user_id)
                                        ->where('is_deleted', 1)
                                        ->select('category_user.id', 'category_name')
                                        ->get();
          $data['categories_registered'] = $categories_registered;
          $data['stt'] = 0;
    return view('recipients.register_category', $data);
  }

  public function saveRegisterCategory(Request $request, SessionHelper $sessionHelper) {
     $user_id = $sessionHelper->get()["id"];
    $loop = $request->get('category_id');
    $data = [];
    $categories = CategoryModel::all();
    $data["categories"] = $categories;
    if(!is_null($loop)) {
      foreach ($loop as $value){
        $record = CategoryUserModel::where('user_id', $user_id)
                                    ->where('category_id', $value)
                                    ->where('is_deleted', 1)
                                    ->count();
        if($record > 0) {
          $data['note'] = 'Danh mục vừa chọn đã đăng kí rồi, xem danh sách danh mục sản phẩm phía dưới và đăng kí lại những danh mục sản phẩm chưa có!';
          $categories_registered = CategoryUserModel::join('category','category.id','=','category_user.category_id')
                                        ->where('user_id', $user_id)
                                        ->where('is_deleted', 1)
                                        ->select('category_user.id', 'category_name')
                                        ->get();
          $data['categories_registered'] = $categories_registered;
          $data['stt'] = 0;
          return view('recipients.register_category', $data);
        }
        $category_user = new CategoryUserModel;
        $category_user->user_id = $user_id;
        $category_user->category_id = $value;
        $category_user->is_deleted = 1;
        $category_user->save();
      }
      return redirect('/recipients/register_category')->with('infor', 'Đăng kí danh mục thành công!');
    } else {
      return redirect('/recipients/register_category')->with('infor', 'Chưa chọn danh mục!');
    }

  }

  public function listRecipient(Request $request, $id) {
    $recipients_id = [];
    $recipients_id = CategoryUserModel::where('category_id', $id)
                                      ->where('is_deleted', 1)
                                      ->pluck('user_id');

    $recipients = ContributorModel::whereIn('id',$recipients_id)->get();
    $data = [];
    $data['recipients'] = $recipients;
    $data['category_id'] = $id;
    return view('recipients.list', $data);
  }

  public function deleteCategoryRegister(Request $request, SessionHelper $sessionHelper) {
    $user_id = $sessionHelper->get()["id"];
    $loop = $request->get('category_user_id');
    if(is_null($loop)) {
      return redirect('/recipients/register_category')->with('infor', 'Chưa chọn danh mục để xóa!');
    }
    foreach ($loop as $value){
      $category_user = CategoryUserModel::where('user_id', $user_id)
                                        ->where('id', $value)
                                        ->update(['is_deleted'=>0]);

    }
    return redirect('/recipients/register_category')->with('infor', 'Xóa thành công danh mục!');
  }
}
