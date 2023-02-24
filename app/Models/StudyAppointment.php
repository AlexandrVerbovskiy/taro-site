<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyAppointment extends Model
{
    protected $table = 'studies_appointments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'time_id',
        'study_id',
        'user_id',
        'status',
        'created_at'
    ];
}
