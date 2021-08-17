<?php

namespace App\Helper;

class CookieHelper
{
    const COOKIE_KEY = 'contributor_login';

    /**
     * @param string $dataCookie
     * @param int|float $minutes
     * @return $this
     */
    public function create(string $dataCookie, int $minutes = 3600 * 30): CookieHelper
    {
        cookie(self::COOKIE_KEY, $dataCookie, $minutes);

        return $this;
    }

    /**
     * @param string $dataCookie
     * @param int|float $minutes
     * @return $this
     */
    public function delete($dataCookie = '', int $minutes = -3600 * 30): CookieHelper
    {
        cookie(self::COOKIE_KEY, $dataCookie, $minutes);

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
    public function get()
    {
       return cookie(self::COOKIE_KEY);
    }

}
