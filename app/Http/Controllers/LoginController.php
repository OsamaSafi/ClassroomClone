<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function create(): View
    {
        App::setLocale(Auth::user()->profile->locale);

        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        //يوجد حلين لعملية تسجيل الدخول الاول بطريقة attempt
        // ===============================================================================================
        // $result = Auth::attempt($request->only('email', 'password'), $request->remember);

        // if($result){
        //     return redirect()->route('classrooms.index')->with('success', 'Welcom to Classroom');
        // }
        // return back()->withInput()->with('danger', 'Cheack your Email or Password');
        // ===============================================================================================

        $user = User::where('email', '=', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user, $request->remember);

            return redirect()->intended('/')->with('success', 'Welcome To Classrooms');

            // intended رح يوديني على الصفحة يلي طلبتها قبل ما اعمل تسجيل دخول يعني لو طابت الصفحة الرئيسية و انا مش عامل تسجيل دخول بعد ما سجل دخول رح يوديني على المسار يلي طلبتو قبل ما اعمل تسجيل دخول
        }
        return back()->withInput()->with('danger', 'invalid email or password');
    }
}
