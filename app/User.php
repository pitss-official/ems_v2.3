<?php

namespace App;
use App\Http\Controllers\API\NavigationController;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
    protected $visible = [
        'firstName','middleName','lastName','collegeUID'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*
     * This function will send the current user logged in object
     */
    public static function getCurrentAPIUser()
    {
        return \Auth::user();
    }
    public static function showLinks()
    {
        $navigationList=new Navigator();
        $navigationList=$navigationList->getNavigationLinks(1024);
        return $navigationList;
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
