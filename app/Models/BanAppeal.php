<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanAppeal extends Model
{
    use HasFactory;

    protected $fillable = ['ban_appeal_message', 'user_id'];
}
