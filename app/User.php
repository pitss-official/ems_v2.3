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
        'firstName','middleName','lastName','collegeUID','nationality','bloodGroup','fathersName','mobile','altMobile','address'
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
    public function fullName()
    {
        $name=$this->firstName;
        if($this->middleName!="")
            $name.=" ".$this->middleName;
        if($this->lastName!="")
            $name.=" ".$this->lastName;
        return $name;
    }
    //this function will return the current user (api user) object
    public static function getCurrentAPIUser()
    {
        return \Auth::user();
    }
    //@showlinks is used to display the user dynamic navigation links
    public static function showLinks()
    {
        $userLevel=User::getCurrentAPIUser()->authenticationLevel;
        $navigationList=new Navigator();
        $navigationList=$navigationList->getNavigationLinks($userLevel);
        return $navigationList;
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //this function is used to test the user is exsisting in the database or not
    public static function ifNotExist($id)
    {
        if (self::where('collegeUID', $id)->count() != 1)
            return true;
        else return false;
    }

    public static function isExist($id)
    {
        if (self::where('collegeUID', $id)->count() == 1)
            return true;
        else return false;
    }
    //open a new account for a user with zero balance / standard account
    public function openAccount()
    {
        $account = new Account();
        $account->newStandardAccount($this->collegeUID);
        return $account;
        //account will now be opened through the standarad account interface in Account class
//        $account= new Account();
//        $account->name=$this->fullName()." - Standard Account";
//        $account->onHold=1;
//        $account->type=0;
//        $account->queueID=0;
//        $account->balance=0;
//        $account->number=$this->collegeUID;
//        $account->collegeUID=$this->collegeUID;
//        $account->save();
//        return $account->number;
    }

}
