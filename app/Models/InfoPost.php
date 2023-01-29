<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoPost extends Model
{
    protected $table = 'infos_posts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'body',
        'info_id',
        'title',
        'media_type',
        'url'
    ];
}
