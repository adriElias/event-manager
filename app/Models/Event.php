<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'creation_date',
        'time_date_start',
        'time_date_end',
        'description',
        'location',
        'directions'
    ];
    public function participation()
    {
        return $this->belongsTo(Participation::class, 'id_event');
    }
    
}
