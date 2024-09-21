<?php

namespace App\Http\Controllers;

use App\Events\ClassworkCreated;
use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ClassworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom)
    {
        App::setLocale(Auth::user()->profile->locale);

        $classworks = $classroom->classworks()
            ->orderBy('created_at', 'desc')
            ->search($request->query())
            ->where(function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('id', '=', Auth::id());
                })
                    ->orWhereHas('classroom.teachers', function ($query) {
                        $query->where('id', '=', Auth::id());
                    });
            })
            ->withCount([
                'users' => function ($query) {
                    $query->where('classwork_user.status', '=', 'assigned');
                },
                'users as turnedin_count' => function ($query) {
                    $query->where('classwork_user.status', '=', 'submitted');
                },
                'users as graded_count' => function ($query) {
                    $query->whereNotNull('classwork_user.grade');
                },
            ])
            ->with('topic')
            ->get()
            ->groupBy('topic_id');
        return view('classworks.index')->with([
            "classworks" => $classworks,
            "classroom" => $classroom
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Classroom $classroom)
    {
        App::setLocale(Auth::user()->profile->locale);

        Gate::authorize('classworks.create', $classroom);
        $type = $this->getType();
        $classwork = new Classwork();
        return view('classworks.create', compact('classroom', 'classwork', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        Gate::authorize('classworks.create', $classroom);

        $type = $this->getType();

        $request->validate([
            'title' => ['string', 'required', 'max:255'],
            'description' => ['nullable', 'string'],
            'grade' => [Rule::requiredIf(function () use ($type) {
                return $type == 'assignment';
            }), 'numeric', 'min:0'],
            'due' => ['nullable', 'date', 'after:published_at']
        ]);

        // $request->merge([
        //     'user_id' => Auth::id(),
        //     // 'classroom_id' => $classroom->id
        // ]);
        // $classwork = Classwork::create($request->all());
        try {
            DB::transaction(function () use ($classroom, $request, $type) {
                $data = [
                    'user_id' => Auth::id(),
                    'type' => $type,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'topic_id' => $request->input('topic_id'),
                    'published_at' => $request->input('published_at', now()),
                    'options' => [
                        'grade' => $request->input('grade'),
                        'due' => $request->input('due')
                    ]
                ];
                $classwork = $classroom->classworks()->create($data);
                $classwork->users()->attach($request->input('students'));
                event(new ClassworkCreated($classwork));
            });
        } catch (QueryException $e) {
            return back()->with('danger', $e->getMessage());
        }
        return redirect()->route('classrooms.classworks.index', $classroom->id)->with('success', 'Classwork Created!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Classwork $classwork)
    {
        App::setLocale(Auth::user()->profile->locale);

        Gate::authorize('classworks.view', $classwork);
        $comment = new Comment();
        $userAssignment = $classwork->users()->where('id', '=', $classwork->user_id)->get();
        $submissions = $classwork->submissions()->where('classwork_id', '=', $classwork->id)->get();
        return view('classworks.show', compact('classroom', 'submissions', 'classwork', 'comment', 'userAssignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom, Classwork $classwork)
    {
        App::setLocale(Auth::user()->profile->locale);

        Gate::authorize('classworks.update', $classroom);

        $type = $classwork->type;
        $students = $classwork->users()->pluck('id')->toArray();
        return view('classworks.edit', compact('classroom', 'classwork', 'students', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
        Gate::authorize('classworks.update', $classroom);

        $type = $classwork->type;
        $request->validate([
            'title' => ['string', 'required', 'max:255'],
            'description' => ['string', 'nullable'],
            'grade' => [Rule::requiredIf(function () use ($type) {
                return $type == 'assignment';
            }), 'numeric', 'min:0'],
            'due' => ['nullable', 'date', 'after:published_at']
        ]);
        try {
            DB::transaction(function () use ($classwork, $request, $type) {
                $data = [
                    'user_id' => Auth::id(),
                    'type' => $type,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'topic_id' => $request->input('topic_id'),
                    'published_at' => $request->input('published_at'),
                    'options' => [
                        'grade' => $request->input('grade'),
                        'due' => $request->input('due')
                    ]
                ];
                $classwork->update($data);
                $classwork->users()->sync($request->input('students'));
            });
        } catch (QueryException $e) {
            return back()->with('danger', $e->getMessage());
        }


        return redirect()->route('classrooms.classworks.index', $classroom->id)->with('success', 'classwork Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        Gate::authorize('classworks.delete', $classroom);

        $isDeleted = $classwork->delete();
        return response()->json(
            [
                'icon' => $isDeleted ? 'success' : 'error',
                'message' => $isDeleted ? 'Deleted Successfully' : 'deleted fail'
            ],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

    protected function getType()
    {
        // $type = request('type');
        $type = request()->type;
        $types = ['assignment', 'material', 'question'];
        if (!in_array($type, $types)) {
            $type = 'assignment';
        }
        return $type;
    }
}
