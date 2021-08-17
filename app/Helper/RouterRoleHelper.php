<?php


namespace App\Helper;

use App\Models\ContributorModel;

class RouterRoleHelper
{
    /**
     * @param $contributor
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function redirectUserRole($contributor)
    {
        return redirect(self::getRouteUserRole($contributor));
    }

    /**
     * @param $contributor
     * @return string
     */
    public static function getRouteUserRole($contributor): string
    {
        $router = '/';

        if (!isset($contributor->role)) {
            return $router;
        }

        $role = $contributor->role;

        switch ($role) {
            case ContributorModel::ROLE_RECEIVE:
                $router = '/recipients/home';
                break;
            case ContributorModel::ROLE_SENT:
                $router = '/product/index';
                break;
            default:
                $router = '/category/index';
                break;
        }

        return $router;
    }
}
