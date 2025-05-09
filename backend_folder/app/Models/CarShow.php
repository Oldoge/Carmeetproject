<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarShow extends Model
{
    protected $fillable = [
        'title',
        'picture',
        'organizer',
        'event_date',
        'event_date_start',
        'event_date_end',
        'location',
        'description'
    ];
}
