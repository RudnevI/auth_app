<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends BaseModel
{
    protected $fillable = ['full_name', 'bio', 'isBanned', 'user_id'];
    protected $hidden  = ['isBanned'];
}
