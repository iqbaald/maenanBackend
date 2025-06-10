<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GymQrToken extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'user_id',
        'gym_branch_id',
        'token',
        'type',
        'expired_at',
        'used_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'used_at'    => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke cabang gym
    public function gymBranch()
    {
        return $this->belongsTo(GymBranches::class);
    }

    // Mengecek apakah token masih berlaku dan belum digunakan
    public function isValid(): bool
    {
        return is_null($this->used_at) && $this->expired_at?->isFuture();
    }
}
