<?php

namespace App\Helper;

use App\Models\ContributorModel;

class RoleCookieHelper
{
    protected $cookieHelper;
    protected $contributorModel;
    protected $cookieToken;

    public function __construct(CookieHelper $cookieHelper, ContributorModel $contributorModel)
    {
        $this->cookieHelper = $cookieHelper;
        $this->contributorModel = $contributorModel;
        $this->cookieToken = $this->cookieHelper->get();
    }

    /**
     * @return bool
     */
    public function isContributeRole(): bool
    {
        return $this->getRole() === ContributorModel::ROLE_CONTRIBUTOR;
    }

    /**
     * @return bool
     */
    public function isAdminRole(): bool
    {
        return $this->getRole() === ContributorModel::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isReceiveRole(): bool
    {
        return $this->getRole() === ContributorModel::ROLE_RECEIVE;
    }

    /**
     * @return bool
     */
    public function isShipRole(): bool
    {
        return $this->getRole() === ContributorModel::ROLE_SHIP;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        $contribute = $this->contributorModel->getUserRememberToken($this->cookieHelper->get());

        return isset($contribute[ContributorModel::FIELD_ROLE]) ?
            $contribute[ContributorModel::FIELD_ROLE] : ContributorModel::ROLE_GUEST;
    }

}
