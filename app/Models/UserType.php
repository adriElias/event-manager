<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;

    //
    protected $fillable = [
        'name',
        'description'
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
}
