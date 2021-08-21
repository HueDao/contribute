<?php

namespace App\Helper;

use App\Models\ContributorModel;

class RoleSessionHelper
{
    protected $sessionHelper;
    protected $contributorModel;
    protected $session;

    public function __construct(SessionHelper $sessionHelper, ContributorModel $contributorModel)
    {
        $this->sessionHelper = $sessionHelper;
        $this->contributorModel = $contributorModel;
        $this->session = $this->sessionHelper->get();
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
     * @return bool
     */
    public function isStoreRole(): bool
    {
        return $this->getRole() === ContributorModel::ROLE_SRORE;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return isset($this->session[ContributorModel::FIELD_ROLE]) ?
            $this->session[ContributorModel::FIELD_ROLE] : ContributorModel::ROLE_GUEST;
    }

}
