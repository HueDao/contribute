<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContributorLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $contributor_login_remember = $request->cookie('contributor_login_remember');

        if ($contributor_login_remember) {
            $contributorCookie = DB::table('contributors')
                ->where('remember_token', '=', $contributor_login_remember)
                ->where('role', 1)
                ->first();
            if (isset($contributorCookie->id) && ($contributorCookie->id > 0)) {
                return $next($request);
            }
        }

        $session_contributor_login = session('contributor_login', false);

        if ($session_contributor_login && $session_contributor_login['role'] != 1 || !$session_contributor_login) {
            return redirect('/contributor/login');
        }

        return $next($request);
    }
}
