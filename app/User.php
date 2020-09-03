<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Two\User as TwoUser;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'github_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'accesstoken',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public static function findOrCreateUser(TwoUser $githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }

        $user = new User();
        $user->name = $githubUser->name;
        $user->email = $githubUser->email;
        $user->github_id = $githubUser->id;
        $user->avatar = $githubUser->avatar;
        $user->accesstoken = $githubUser->token;
        $user->save();

        return $user;
    }

    // public static function find(Authenticatable $user){
    //     if ($authUser = User::where('github_id', $user->id)->first()) {
    //         return new User($authUser);
    //     }
    // }

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    public function repos(){
        return $this->hasMany('App\Repo');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }

}
