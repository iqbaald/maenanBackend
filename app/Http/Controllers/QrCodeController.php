<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymQRToken;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    // Untuk user generate QR (misalnya member/karyawan)
    public function generate(Request $request)
    {
        $user = $request->user(); // login via Sanctum
        $branchId = $user->gym_branch_id;

        $token = Str::uuid()->toString(); // gunakan UUID
        $expiredAt = now()->addMinute();  // expired dalam 1 menit

        $qr = GymQRToken::create([
            'user_id'       => $user->id,
            'gym_branch_id' => $branchId,
            'token'         => $token,
            'type'          => $request->input('type', 'checkin'),
            'expired_at'    => $expiredAt,
        ]);

        return response()->json([
            'token'      => $qr->token,
            'expired_at' => $qr->expired_at,
        ]);
    }

    // Untuk alat scan memverifikasi QR (tanpa auth)
    public function verify(Request $request)
    {
        $token = $request->input('token');

        $qr = GymQRToken::where('token', $token)->latest()->first();

        if (! $qr) {
            return response()->json(['message' => 'Invalid QR token'], 404);
        }

        if ($qr->used_at) {
            return response()->json(['message' => 'QR token already used'], 400);
        }

        if ($qr->expired_at < now()) {
            return response()->json(['message' => 'QR token expired'], 400);
        }

        $qr->used_at = now();
        $qr->save();

        return response()->json([
            'message'   => 'QR valid',
            'user_id'   => $qr->user_id,
            'user'      => $qr->user->only(['id', 'name', 'role']),
            'branch_id' => $qr->gym_branch_id,
        ]);
    }
}
