<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;

class UserLogoutService
{
    public function logout(Request $request): void
    {
        $request->user()->tokens()->delete();
    }
}
