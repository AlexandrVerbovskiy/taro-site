<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarDate extends Model
{
    protected $table = 'calendar_dates';

    protected $primaryKey = 'id';

    protected $fillable = [
        'date'
    ];
}
