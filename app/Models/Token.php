<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends BaseModel
{
    //

    protected $fillable = ['access_token', 'refresh_token', 'user_id'];

    public function getRouteKeyName()
    {
        return 'token_uuid';
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
