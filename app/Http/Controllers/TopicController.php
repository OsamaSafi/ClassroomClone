<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Topic;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Classroom $classroom)
    {
        App::setLocale(Auth::user()->profile->locale);
        $topics = $classroom->topics()->get();
        return view('topics.index', compact('classroom', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Classroom $classroom)
    {
        App::setLocale(Auth::user()->profile->locale);
        $topics = $classroom->topics()->get();
        return view('topics.create', compact('classroom', 'topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'classroom_id' => ['nullable']
        // ]);
        // $request->merge([
        //     'user_id' => Auth::id(),
        //     'classroom_id' => $classroom->id
        // ]);
        // Topic::create($request->all());
        // return redirect()->route('classrooms.topics.create', $classroom->id)->with('success', 'Topics Created!');
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:45',
            'classroom_id' => 'required',
            'user_id' => 'required',
        ]);
        if (! $validator->fails()) {
            $topic = new Topic();
            $topic->name = $request->input('name');
            $topic->classroom_id = $request->input('classroom_id');
            $topic->user_id = $request->input('user_id');
            $isSaved = $topic->save();
            return response()->json([
                'message' => $isSaved ? 'topic created successfully' : 'creat failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, string $id)
    {
        App::setLocale(Auth::user()->profile->locale);
        $topic = $classroom->topics()->findOrFail($id);
        return view('topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom, string $id)
    {
        App::setLocale(Auth::user()->profile->locale);
        $topic = $classroom->topics()->findOrFail($id);
        return view('topics.edit', compact('topic', 'classroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'classroom_id' => ['nullable']
        ]);
        $topic = $classroom->topics()->findOrFail($id);
        $topic->update($request->all());
        return redirect()->route('classrooms.topics.create', $classroom->id)->with('success', 'Topics Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Topic $topic)
    {
        $isDelete = $topic->delete();
        return response()->json([
            'message' => $isDelete ? 'Topic delete successfully' : 'delete failed',
            'icon' => $isDelete ? 'success' : 'error',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
