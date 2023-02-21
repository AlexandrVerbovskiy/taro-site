<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAppointment extends Model
{
    protected $table = 'masters_appointments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'time_id',
        'master_id',
        'user_id',
        'status'
    ];
}
