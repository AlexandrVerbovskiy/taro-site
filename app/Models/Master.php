<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table = 'masters';

    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'description',
        'img_src'
    ];
}
