<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'infos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title_ua',
        'title_ru'
    ];
}
