<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Applicant;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // tránh session fixation

            $user = Auth::user();

            if ($user->role === 'applicant') {
                return redirect()->route('applicant.dashboard'); // sửa lại đúng route có sẵn
            } elseif ($user->role === 'employer') {
                return redirect()->route('employer.dashboard');
            }
        }

        return back()->withErrors([
            'login_error' => 'Email hoặc mật khẩu không đúng!',
        ])->with('showLoginModal', true);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Đăng ký
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Tạo user
        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'applicant',
        ]);

        // Tạo applicant
        Applicant::create([
            'hoten_uv' => $request->name,
            'user_id'  => $user->id,
        ]);

        Auth::login($user);

        return redirect()->route('applicant.profile')->with('success', 'Đăng ký thành công!');
    }

    // Trang welcome
    // Trang welcome
    public function welcome()
    {
        $user = \App\Models\User::with('applicant')->find(Auth::id());
        // lấy luôn user đang đăng nhập + applicant
        $displayName = $user->applicant->hoten_uv ?? $user->email;

        return view('welcome', compact('displayName', 'user'));
    }
}
