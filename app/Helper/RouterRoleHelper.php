<?php

namespace App\Helper;

use App\Constant\RouteConstant;
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
                $router = RouteConstant::PAGE_RECEIVE_AFTER_LOGIN;
                break;
            case ContributorModel::ROLE_CONTRIBUTOR:
                $router = RouteConstant::PAGE_CONTRIBUTOR_AFTER_LOGIN;
                break;
            case ContributorModel::ROLE_SHIP:
                $router = RouteConstant::PAGE_SHIP_AFTER_LOGIN;
                break;
            case ContributorModel::ROLE_ADMIN:
                $router = RouteConstant::PAGE_ADMIN_AFTER_LOGIN;
                break;
            case ContributorModel::ROLE_STORE:
                $router = RouteConstant::PAGE_STORE_AFTER_LOGIN;
                break;
            default:
                $router = RouteConstant::PAGE_ADMIN_DEFAULT;
                break;
        }

        return $router;
    }
}
