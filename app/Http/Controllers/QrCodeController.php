<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymQrToken;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $user = $request->user(); // sudah login via Sanctum

        $token = Str::random(32);
        $expiredAt = now()->addMinutes(1);

        $qr = GymQrToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expired_at' => $expiredAt,
        ]);

        return response()->json([
            'token' => $token,
            'expired_at' => $expiredAt,
            // optionally generate base64 QR here
        ]);
    }

    public function verify(Request $request)
    {
        $token = $request->input('token');

        $qr = GymQrToken::where('token', $token)->first();

        if (! $qr) {
            return response()->json(['message' => 'Invalid QR token'], 404);
        }

        if ($qr->used_at) {
            return response()->json(['message' => 'QR token already used'], 400);
        }

        if ($qr->expired_at < now()) {
            return response()->json(['message' => 'QR token expired, Generate Again'], 400);
        }

        // Valid
        $qr->update(['used_at' => now()]);

        return response()->json([
            'message' => 'Check-in success',
            'user_id' => $qr->user_id,
            'user' => $qr->user,
        ]);
    }
}
