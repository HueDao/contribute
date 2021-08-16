<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContributorLoginController extends Controller
{
  public function loginview() {
      
    $session_contributor_login = session('contributor_login', false);
    $data = [];
    var_dump($session_contributor_login);
    if ($session_contributor_login && isset($session_contributor_login["id"]) && ($session_contributor_login["id"] > 0)) {
        return redirect('product/index');
    }
    // Hiển thị trang login
    return view("login.contributor_login");
  }

  public function loginPost(Request $request) {
    // validate dữ liệu
    $validatedData = $request->validate([
      'email' => 'required',
      'password' => 'required'
    ]);
    $email = $request->input('email', '');
    $password = $request->input('password', '');
    $contributor = DB::table('contributors')
      ->where('email', '=', $email)
      ->first();
    if (!$contributor) {
      $request->session()->flash('status', 'thông tin đăng nhập không đúng !!');
      return view("login.contributor_login");
    }
    if (isset($contributor->id) && ($contributor->id > 0) && Hash::check($password, $contributor->password)) {
      $contributorLogin = [
        "id" => $contributor->id,
        "email" => $contributor->email,
        "name" => $contributor->name,
        "password" => $contributor->password,
        "desc" => $contributor->desc,
        "address" => $contributor->address,
        "number_phone" => $contributor->number_phone,
      ];
      session(['contributor_login' => $contributorLogin]);
      return redirect('product/index');
    }
    $request->session()->flash('status', 'thông tin đăng nhập không đúng !!');
    // Hiển thị trang login
    return view("login.contributor_login");
  }

  public function logout(Request $request) {
    $request->session()->forget(['contributor_login']);
    $request->session()->flush();
    return redirect('/contributor/login');
  }
}
