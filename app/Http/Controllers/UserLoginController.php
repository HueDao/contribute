<?php

namespace App\Http\Controllers;

use App\Helper\CookieHelper;
use App\Helper\RoleCookieHelper;
use App\Helper\RoleSessionHelper;
use App\Helper\RouterRoleHelper;
use App\Helper\SessionHelper;
use App\Models\ContributorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserLoginController extends Controller
{
    public function index(RoleCookieHelper $cookieHelper, RoleSessionHelper $sessionHelper)
    {
        $userRole = $sessionHelper->getRole();

        if ($userRole !== ContributorModel::ROLE_GUEST) {
            return RouterRoleHelper::redirectUserRole($userRole);
        }

        $userRole = $cookieHelper->getRole();

        if ($userRole !== ContributorModel::ROLE_GUEST) {
            return RouterRoleHelper::redirectUserRole($userRole);
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

        return RouterRoleHelper::redirectUserContributor($contributor);
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
