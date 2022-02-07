<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    //

    protected $fillable = ['access_token', 'refresh_token', 'user_id'];

    public function getRouteKeyName()
    {
        return 'token_uuid';
    }
}
