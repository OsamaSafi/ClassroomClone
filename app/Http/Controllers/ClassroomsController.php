<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class ClassroomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('subscriped')->only('store', 'create');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom)
    {
        // dd($classroom->users()->first()->profile->user_image_path ?? "");
        App::setLocale(Auth::user()->profile->locale);
        $classrooms = $classroom->orderBy('created_at', 'desc')->filter($request->query())->status('active')->paginate(4);
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        App::setLocale(Auth::user()->profile->locale);

        return view('classrooms.create', [
            'classroom' => new Classroom()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request)
    {
        $validate = $request->validated();
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = Classroom::storeCoverImage($file);
            // $request->merge([
            //     'cover_image_path' => $path,
            //     'code' => Str::random(8)
            // ]);
            $validate['cover_image_path'] = $path;
        }
        // $validate['code'] = Str::random(8);
        // $validate['user_id'] = Auth::user()->id;

        DB::beginTransaction();
        try {
            $classroom = Classroom::create($validate);
            $classroom->join(Auth::id(), 'teacher');
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->withInput()->with('danger', $e->getMessage());
        }

        return response()->json([
            'message' => 'add classroom successfuly'
        ]);
        // return redirect()->route('classrooms.index')->with('success', 'classroom is created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        App::setLocale(Auth::user()->profile->locale);
        $classroom = Classroom::findOrFail($id);
        return view('classrooms.show', compact('classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        App::setLocale(Auth::user()->profile->locale);
        $classroom = Classroom::findOrFail($id);
        Gate::authorize('classroom.manage', $classroom);
        return view('classrooms.edit', compact('classroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomRequest $request, string $id)
    {
        $validate = $request->validated(); // الحصول على الحقول يلي انعمل الهم تحقق
        if ($request->hasFile('cover_image')) {
            $file = $request->cover_image;
            $path = Classroom::storeCoverImage($file);
            // $request->merge([
            //     'cover_image_path' => $path
            // ]);
            $validate['cover_image_path'] = $path;
        }
        $classroom = Classroom::findOrFail($id);
        Gate::authorize('classroom.manage', $classroom);
        $old = $classroom->cover_image_path;
        $classroom->update($validate);
        $new = $classroom->cover_image_path;
        if ($old && $old <> $new) {
            Classroom::deleteCoverImage($old);
        }
        return redirect()->route('classrooms.index')->with('success', "Classroom ($classroom->name) updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        // Classroom::deleteCoverImage($classroom->cover_image_path);

        return redirect()->route('classrooms.index')->with('danger', "classroom ($classroom->name) Trached");
    }


    public function trached()
    {
        App::setLocale(Auth::user()->profile->locale);

        $classrooms = Classroom::onlyTrashed()->get();

        return view('classrooms.trached', compact('classrooms'));
    }

    public function restore($id)
    {
        $classroom = Classroom::onlyTrashed()->findOrFail($id);
        $classroom->restore();
        return redirect()->route('classrooms.index')->with('success', "Classroom ($classroom->name) Restored");
    }

    public function forceDelete($id)
    {
        $classroom = Classroom::withTrashed()->findOrFail($id);
        $classroom->forceDelete();
        return redirect()->route('classrooms.trached')->with('success', 'classroom ($classroom->name) Deleted');
    }

    public function chat(Classroom $classroom)
    {
        return view('classrooms.chat', compact('classroom'));
    }
}
