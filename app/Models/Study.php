<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $table = 'studies';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'date',
        'body',
        'topic_id',
    ];
}
