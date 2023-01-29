<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTopic extends Model
{
    protected $table = 'events_topics';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title_ua',
        'title_ru'
    ];
}
