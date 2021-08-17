<?php

namespace App\Helper;

use App\Models\ContributorModel;
use Illuminate\Http\Request;

class SessionHelper
{
    const SESSION_KEY = 'contributor_login';

    private $dataSession = [];

    /**
     * @param ContributorModel $contributor
     * @return SessionHelper
     */
    public function create(ContributorModel $contributor): SessionHelper
    {
        $this->dataSession = [
            "id" => $contributor->id,
            "email" => $contributor->email,
            "name" => $contributor->name,
            "password" => $contributor->password,
            "desc" => $contributor->desc,
            "address" => $contributor->address,
            "number_phone" => $contributor->number_phone,
            "role" => $contributor->role,
        ];

        return $this;
    }

    /**
     * @return $this
     */
    public function set(): SessionHelper
    {
        session([self::SESSION_KEY => $this->dataSession]);

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public function get()
    {
        return session(self::SESSION_KEY, false);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function delete(Request $request)
    {
        $request->session()->forget(['contributor_login']);
        $request->session()->flush();

        return $this;
    }
}
