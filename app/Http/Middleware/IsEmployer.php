<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployer
{
    /**
     * ✅ Kiểm tra người dùng có phải là employer không
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập');
        }

        if (Auth::user()->role !== 'employer') {
            return redirect()->route('home')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
