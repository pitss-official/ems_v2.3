<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Message;

class Chat extends Model
{
    protected $visible=['name','id','sender','activity_state'];
    protected $fillable=['sender','receiver','authorityLevel'];
    protected $appends=['activity_state'];
    public function messages(){
        return $this->hasMany('App\Message');
    }
    public function getSenderAttribute(){
        return User::getNameFromCollegeUID($this->attributes['sender']);
    }
    public function getActivityStateAttribute(){
        if(abs(now()->diffInSeconds(User::getUserByCollegeUID($this->attributes['sender'])->lastLogin))>120)
            return Carbon::parse(User::getUserByCollegeUID($this->attributes['sender'])->lastLogin)->diffForHumans(now());
        else
            return 'Online';
    }
}
