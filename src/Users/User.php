<?php

namespace Humweb\Auth\Users;

use Humweb\Auth\Contracts\Permissible as PemissibleContract;
use Humweb\Auth\Groups\Contracts\Groupable as GroupableContract;
use Humweb\Auth\Groups\Groupable;
use Humweb\Auth\Permissions\Permissible;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package Humweb\Auth\Users
 */
class User extends Authenticatable implements PemissibleContract, GroupableContract
{
    use Notifiable, Permissible, Groupable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'permissions'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'permissions' => 'array'
    ];

    protected $attributes = [
        'permissions' => []
    ];


    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
