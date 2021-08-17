<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContributorLoginController extends Controller
{
    public function login()
    {
        $session_contributor_login = session('contributor_login', false);

        if ($session_contributor_login && isset($session_contributor_login["id"]) && ($session_contributor_login["id"] > 0)) {
            return redirect('product/index');
        }

        return view("login.contributor_login");
    }

    public function loginPost(Request $request)
    {
        // validate dữ liệu
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $remember_me = $request->input('remember_me', '');
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
                "role" => $contributor->role,
            ];
            session(['contributor_login' => $contributorLogin]);
            // tạo cookie remember Me và cập nhật vào trong bản ghi của CSDL
            if ($remember_me == "on") {
                $minutes = 3600 * 30;
                $hash = $contributor->id . $contributor->email . $contributor->password;
                $cookieValue = Hash::make($hash);
                cookie('contributor_login_remember', $cookieValue, $minutes);
                // update vào CSDL
                DB::table('contributors')
                    ->where('id', $contributor->id)
                    ->update(['remember_token' => $cookieValue]);
            }
            if ($contributor->role == 2) {
                return redirect('/recipients/home');
            } elseif ($contributor->role == 1) {
                return redirect('product/index');
            } else {
                return redirect('category/index');
            }
        }
        $request->session()->flash('status', 'thông tin đăng nhập không đúng !!');
        // Hiển thị trang login
        return view("login.contributor_login");
    }

    public function logout(Request $request)
    {
        cookie('contributor_login_remember', "", -3600 * 30);
        $request->session()->forget(['contributor_login']);
        $request->session()->flush();
        return redirect('/contributor/login');
    }
}
