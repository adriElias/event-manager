<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'id_user',
        'id_event'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
    public $timestamps = false;
}
