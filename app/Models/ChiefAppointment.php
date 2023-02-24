<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiefAppointment extends Model
{
    protected $table = 'chief_appointments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'time_id',
        'user_id',
        'status',
        'created_at'
    ];
}
