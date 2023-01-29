<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $fillable = [
        'body',
        'events_topic_id',
        'title',
        'media_type',
        'url'
    ];
}
