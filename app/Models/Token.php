<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'tokenable_id',
        'token'
    ];
}
