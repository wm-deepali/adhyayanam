<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
class TeacherLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:teacher')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.teacher-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::guard('teacher')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('teacher.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('teacher.login'));
    }

    public function showLinkRequestForm()
    {
        return view('auth.teacher-passwords.email'); // create this view
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('teachers')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.teacher-passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('teachers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($teacher, $password) use ($request) {
                $teacher->password = Hash::make($password);
                $teacher->setRememberToken(Str::random(60));
                $teacher->save();
                event(new PasswordReset($teacher));
                auth()->guard('teacher')->login($teacher);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('teacher.dashboard')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


}
