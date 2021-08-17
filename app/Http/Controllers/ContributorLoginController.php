<?php

namespace App\Http\Controllers;

use App\Helper\CookieHelper;
use App\Helper\RouterRoleHelper;
use App\Helper\SessionHelper;
use App\Models\ContributorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ContributorLoginController extends Controller
{
    protected $contribute;

    public function index()
    {
        $session_contributor_login = session('contributor_login', false);

        if ($session_contributor_login && isset($session_contributor_login["id"]) && ($session_contributor_login["id"] > 0)) {
            return redirect('product/index');
        }

        return view("login.login");
    }

    public function login(Request $request,
                          ContributorModel $contributorModel,
                          SessionHelper $sessionHelper,
                          CookieHelper $cookieHelper)
    {
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $remember_me = $request->input('remember_me', '');
        $contributor = $contributorModel->getUserEmail($email);

        if (!$contributor || !Hash::check($password, $contributor->password)) {
            return Redirect::back()->withErrors("Email or password isn't correct.");
        }

        $sessionHelper->create($contributor)->set();

        if ($remember_me == "on") {
            $hash = $contributor->id . $contributor->email . $contributor->password;
            $cookieValue = $cookieHelper->create(Hash::make($hash))->get();
            $contributor->update(['remember_token' => $cookieValue]);
        }

        return RouterRoleHelper::redirectUserRole($contributor);
    }

    public function logout(Request $request,
                           SessionHelper $sessionHelper,
                           CookieHelper $cookieHelper)
    {
        $sessionHelper->delete($request);
        $cookieHelper->delete();

        return redirect('/');
    }
}
