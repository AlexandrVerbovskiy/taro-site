<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyTopic extends Model
{
    protected $table = 'studies_topics';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title_ru',
        'title_ua'
    ];
}
