<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
