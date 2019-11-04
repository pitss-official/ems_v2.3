<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[
        'sender', 'message',
        'chat_id'
    ];
    protected $visible=['sender','message','created_at','read_time','id'];
    public function sender(){
        return $this->hasOne('App/User');
    }
    public function chat(){
        return $this->hasOne('App/Chat');
    }
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function getSenderAttribute(){
        return User::getNameFromCollegeUID($this->attributes['sender']);
    }
}
