<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ContributorModel extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_SENT = 2;
    const ROLE_RECEIVE = 3;
    const ROLE_SHIP = 4;

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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
}
