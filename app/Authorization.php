<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $fillable=[];
    public function getCustomAuthorizations($level)
    {
        return self::where('level','>=',$level);
    }
    public function getFormalAuthorizations($levvel)
    {
        return $this->hasMany('App\Navigator');
    }
}
