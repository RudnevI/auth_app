<?php

namespace App\Models;



use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel
{

    protected $fillable = ['email', 'username', 'role_id'];

    //

    protected $hidden = ['hashed_password', 'id'];




    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function save(array $options = [])
    {


       $this->hashed_password = Hash::make($this->hashed_password);

       parent::save($options);

    }






}
