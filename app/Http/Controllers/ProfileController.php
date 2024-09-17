<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(User $user,Classroom $classroom)
    {

        return view('profile.show', compact('user','classroom'));
    }
    public function edit()
    {
        $user = Auth::user()->name;
        $first_name = substr($user, 0, strpos($user, " "));
        $last_name = substr($user, strpos($user, " ") + 1, strpos($user, " "));
        App::setLocale(Auth::user()->profile->locale);
        $profile = new Profile();
        return view('profile.edit', compact('first_name', 'last_name', 'profile', 'user'));
    }

    public function store(Request $request)
    {
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();
        $request->validate([
            'first_name' => "string|required",
            'last_name' => "string|required",
            'user_img' => [
                'nullable',
                'image',
                'dimensions:min_width=30,min_height=30'
            ],
            'gender' => ['required', 'in:male,female'],
        ]);
        if ($request->hasFile('user_img')) {
            $file = $request->file('user_img');
            $path = $file->store('/avatars', 'public');
        } else {
            $path = Auth::user()->profile->user_img_path;
        }
        $old = Auth::user()->profile->user_img_path;
        $request->user()->profile()->update([
            'user_img_path' => $path,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'locale' => $request->input('locale'),
        ]);
        App::setLocale(Auth::user()->profile->locale);
        $new = Auth::user()->profile->user_img_path;
        if ($old && $old <> $new) {
            Storage::disk('public')->delete($old);
        }
        return back()->with('success', __('profile updated'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
