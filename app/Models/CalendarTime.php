<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarTime extends Model
{
    protected $table = 'calendar_times';

    protected $primaryKey = 'id';

    protected $fillable = [
        'calendar_date_id',
        'date',
        'time'
    ];
}
