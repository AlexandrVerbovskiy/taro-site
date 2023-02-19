<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticModel extends Model
{
    protected $table = 'static';

    protected $primaryKey = 'id';

    protected $fillable = [
        'key',
        'value'
    ];
}
