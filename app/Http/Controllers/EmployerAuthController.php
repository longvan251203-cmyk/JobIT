<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployerAuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.employer_register');
    }

    public function register(Request $request)
    {
        // ✅ Kiểm tra dữ liệu gửi lên
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:15',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'terms' => 'accepted'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction(); // ✅ Đảm bảo lưu đồng bộ 3 bảng

        try {
            // 1️⃣ Tạo user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employer',
            ]);

            // 2️⃣ Tạo employer
            $employer = Employer::create([
                'user_id' => $user->id,
                'hoten_daidien' => $request->name,
                'gioitinh' => $request->gender === 'male' ? 'Nam' : 'Nữ',
                'sdt' => $request->phone,
            ]);

            // 3️⃣ Tạo company
            Company::create([
                'employer_id' => $employer->id,
                'tencty' => $request->company,
                'tinh_thanh' => $request->location,
                'quan_huyen' => $request->district ?? '',
            ]);

            DB::commit();

            // ✅ Đăng nhập ngay sau khi đăng ký
            Auth::login($user);

            return redirect()->route('employer.dashboard')
                ->with('showCompanyInfoModal', true);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi đăng ký: ' . $e->getMessage());
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // ✅ Kiểm tra tài khoản
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ✅ Chỉ cho phép vào nếu role = employer
            if ($user->role === 'employer') {
                return redirect()->route('employer.dashboard')
                    ->with('success', 'Đăng nhập thành công');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản này không phải nhà tuyển dụng!'
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.'
        ]);
    }
}
