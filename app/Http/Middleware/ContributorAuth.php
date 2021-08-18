<?php

namespace App\Http\Middleware;

use App\Helper\RoleCookieHelper;
use App\Helper\RoleSessionHelper;
use Closure;
use Illuminate\Http\Request;

class ContributorAuth
{
    protected $cookieHelper;
    protected $sessionHelper;
    protected $contributorModel;

    public function __construct(RoleCookieHelper $cookieHelper, RoleSessionHelper $sessionHelper)
    {
        $this->cookieHelper = $cookieHelper;
        $this->sessionHelper = $sessionHelper;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->sessionHelper->isContributeRole() || $this->sessionHelper->isAdminRole()) {
            return $next($request);
        }

        if ($this->cookieHelper->isContributeRole() || $this->cookieHelper->isAdminRole()) {
            return $next($request);
        }

        return redirect('/');
    }
}
