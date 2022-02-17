<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    protected $fillable = ['name'];

    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'role_uuid';
    }
}
