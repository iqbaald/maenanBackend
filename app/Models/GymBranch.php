<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GymBranch extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'location'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function qrTokens()
    {
        return $this->hasMany(GymQRToken::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
