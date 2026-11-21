<?php

namespace App\Http\Controllers;

use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
    public function toggleTheme(Request $request)
    {
        $user = Auth::user();
        $preference = $user->preference ?? new UserPreference(['user_id' => $user->id]);

        $currentTheme = $preference->theme ?? 'light';
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';

        $preference->theme = $newTheme;
        $preference->save();

        return response()->json(['theme' => $newTheme]);
    }

    public function getTheme()
    {
        $user = Auth::user();
        $theme = $user->preference->theme ?? 'light';
        return response()->json(['theme' => $theme]);
    }
}
