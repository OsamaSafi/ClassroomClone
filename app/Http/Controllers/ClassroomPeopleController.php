<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClassroomPeopleController extends Controller
{
    public function index(Classroom $classroom)
    {
        App::setLocale(Auth::user()->profile->locale);

        $students = $classroom->users()->wherePivot('role', 'student')->get();
        $teachers = $classroom->users()->wherePivot('role', 'teacher')->get();
        return view('classrooms.people', compact('classroom', 'teachers', 'students'));
    }

    public function destroy(Request $request, Classroom $classroom)
    {
        Gate::authorize('people.delete', $classroom);
        $request->validate([
            'user_id' => ['required'],
        ]);

        $user_id = $request->input('user_id');
        if ($user_id == $classroom->user_id) {
            return back()->with('danger', 'cant be remove this user');
        }
        $classroom->users()->detach($user_id);
        return redirect()->route('classrooms.people', $classroom->id)->with('success', 'User Removed');
    }
}
