<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar()
    {
        if (!$this->avatar) {
            return env('APP_ROOT_URL') . '/assets/img/profile.png';
        }

        return Str::contains($this->avatar, ['http', 'gravatar'])
            ? $this->avatar
            : env('APP_ROOT_URL') . "/upload/users/{$this->avatar}";
    }

    public function name()
    {
        return sprintf("%s %s", $this->first_name, $this->last_name);
    }

    public function getUserGroup()
    {
        return $this->isAdmin() ? 'ADMIN' : 'CLIENT';
    }

    public function isAdmin()
    {
        return $this->role_id == 1;
    }



    public function getUserGroupsMember()
    {
        if (!$this->user_groups_member) {
            $this->user_groups_member = $this->_member_of_groups()
                ->get()
                ->pluck('id')
                ->toArray();
        }
        return $this->user_groups_member;
    }



    public function _member_of_groups() {
        return $this->belongsToMany(UserGroup::class, 'user_groups_2_users', 'user_id', 'user_group_id')
            ->as('_link')
            ->withPivot(['user_group_id', 'user_id', 'cached_from_conditions']);
    }
}
