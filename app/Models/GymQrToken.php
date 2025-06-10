<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymQrToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expired_at',
        'used_at',
    ];

    protected $dates = [
        'expired_at',
        'used_at',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Token valid atau tidak
    public function isValid(): bool
    {
        return !$this->used_at && $this->expired_at->isFuture();
    }
}
