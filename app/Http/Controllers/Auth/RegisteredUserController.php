<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $userName = $request->name;
        $first_name = substr($userName, 0, strpos($userName, " "));
        $last_name = substr($userName, strpos($userName, " ") + 1, strpos($userName, " "));
        $allwed_locale = ['en', 'ar', 'en-US'];
        $header = $request->header('accept_language');
        $locales = explode(',', $header);
        foreach ($locales as $locale) {
            if (($i = strpos($locale, ';')) !== false) {
                $locale = substr($locale, 0, $i);
            }
            if (!in_array($locale, $allwed_locale)) {
                $locale = config('app.locale');
            } else {
                $locale = App::setLocale($locale);
                break;
            }
        }

        try {
            DB::transaction(function () use ($request, $first_name, $last_name, $locale) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                if ($user) {
                    Profile::create([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'locale' => $locale,
                        'user_id' => $user->id
                    ]);
                }

                event(new Registered($user));

                Auth::login($user);
            });
        } catch (Exception $e) {
            return back();
        }
        return redirect(RouteServiceProvider::HOME);
    }
}
