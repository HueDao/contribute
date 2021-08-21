<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ContributorModel extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_GUEST = -1;
    const ROLE_ADMIN = 4;
    const ROLE_CONTRIBUTOR = 1;
    const ROLE_RECEIVE = 2;
    const ROLE_SHIP = 3;
    const ROLE_STORE = 5;

    /**
     * Role Field table
     */
    const FIELD_ROLE = 'role';

    protected $table = 'contributors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function categoryUsers()
    {
        return $this->hasMany('App\Models\CategoryUserModel', 'user_id');
    }

    /**
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getUserEmail($email)
    {
        return self::where('email', '=', $email)->first();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserId($userId)
    {
        return self::where('id', '=', $userId)->first();
    }

    /**
     * @param $tokenRemember
     * @return mixed
     */
    public function getUserRememberToken($tokenRemember)
    {
        if (empty($tokenRemember)) {
            return null;
        }

        return self::where('remember_token', '=', $tokenRemember)->first();
    }
}
