<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens, HasUuids, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gym_branch_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function qrTokens()
    {
        return $this->hasMany(GymQRToken::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLogs::class);
    }

    public function gymBranch()
    {
        return $this->belongsTo(GymBranches::class);
    }
}
