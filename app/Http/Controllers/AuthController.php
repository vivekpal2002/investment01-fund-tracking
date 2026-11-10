<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
   public function login(){
    return view('Auth.login');
   }

    public function get_login(Request $request){
        // dd($request->all());
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
   }


    public function register(){
    return view('Auth.register');
   }

    public function get_register(Request $request){
        // dd($request->all());
 $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

         event(new Registered($user));

        return redirect()->route('index')->with('success', 'Account created! Please verify your email.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function profile(){
        $user =Auth::user();
        return view('contents.profile',compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'address' => ['nullable', 'string', 'max:1000'],
            'income' => ['nullable', 'numeric', 'min:0'],
            'goal' => ['nullable', 'numeric', 'min:0'],
            'strategy' => ['nullable', Rule::in(['Balanced', 'Aggressive', 'Conservative'])],
            'risk' => ['nullable', Rule::in(['Low', 'Medium', 'High'])],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
