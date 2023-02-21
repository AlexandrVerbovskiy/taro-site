<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterComment extends Model
{
    protected $table = 'masters_comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'author_id',
        'master_id',
        'body'
    ];
}
