<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $table="system";

    public function isUserCanViewSettings(int $collegeUID)
    {

    }
    public function ifUserCanAlterSettings(int $collegeUID)
    {

    }
}
