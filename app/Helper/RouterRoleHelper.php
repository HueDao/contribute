<?php

namespace App\Helper;

use App\Models\ContributorModel;

class RouterRoleHelper
{
    /**
     * @param $contributor
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function redirectUserContributor($contributor)
    {
        return redirect(self::getRouteUserRole($contributor->role));
    }

    /**
     * @param $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function redirectUserRole($role)
    {
        return redirect(self::getRouteUserRole($role));
    }

    /**
     * @param $role
     * @return string
     */
    public static function getRouteUserRole($role): string
    {
        switch ($role) {
            case ContributorModel::ROLE_RECEIVE:
                $router = '/recipients/home';
                break;
            case ContributorModel::ROLE_CONTRIBUTOR:
                $router = '/product/index';
                break;
            case ContributorModel::ROLE_SHIP:
                $router = '/ship/index';
                break;
            case ContributorModel::ROLE_ADMIN:
                $router = '/contributor/index';
                break;
            default:
                $router = '/login';
                break;
        }

        return $router;
    }
}
