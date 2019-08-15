<?php

namespace App;
use App\Http\Controllers\API\NavigationController;
use Illuminate\Support\Facades\Auth;
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
    protected $hidden = [
        'id', 'fathersName', 'createdBy', 'gender', 'birthday', 'nationality', 'bloodGroup', 'lastLogin', 'incentiveRate', 'status', 'mobile', 'altMobile', 'authorityLevel', 'address', 'referenceUID', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'
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
        try{
        $userObject=Auth::guard('api')->user();
        return [
            'collegeUID'=>$userObject->collegeUID,
            'authorityLevel'=>$userObject->authorityLevel,
            'level'=>$userObject->authorityLevel,
            'firstName'=>$userObject->firstName,
            'middleName'=>$userObject->middleName,
            'lastName'=>$userObject->lastName,
            'email'=>$userObject->email,
            'mobile'=>$userObject->mobile
            ];}
            catch (\Exception $e)
            {
                die("Invalid Session");
            }
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //this function is used to test the user is exsisting in the database or not
    public static function isNotExist($id)
    {
        return !self::isExist($id);
    }
    public static function ifNotExist($id)
    {
        return self::isNotExist($id);
    }
    public static function ifExist($id)
    {
        return self::isExist($id);
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
        $account->newStandardAccount($this->collegeUID,$this->createdBy);
        return $account;
        //account will now be opened through the standarad account interface in Account class
    }
    public function lastTheme()
    {
        $styles=['blue','purple','megna','red','green','default','default-dark','green-dark','red-dark','blue-dark','purple-dark','megna-dark',];
        return $styles[$this->theme];
    }
    public static function findAuthenticationLevel($collegeUID)
    {
        return User::where('collegeUID',$collegeUID)->value('authorityLevel');
    }
    public function accounts()
    {
        return $this->hasMany('App\Account','collegeUID','collegeUID');
    }
}
