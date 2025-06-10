<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AttendanceLog extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'gym_branch_id',
        'type',
        'checked_in_at',
        'checked_out_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gymBranch()
    {
        return $this->belongsTo(GymBranch::class);
    }
}
