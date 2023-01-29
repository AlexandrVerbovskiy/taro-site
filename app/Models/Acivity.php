<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acivity extends Model
{
    protected $table = 'areas_activities';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title_ua',
        'title_ru',
        'body',
        'img_src',
        'type'
    ];
}
