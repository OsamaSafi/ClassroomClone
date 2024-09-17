<?php

namespace App\Http\Controllers;

use App\Events\ClassworkSubmission;
use App\Models\Classwork;
use App\Models\ClassworkUser;
use App\Models\Submission;
use App\Rules\ForbiddenFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

class SubmissionController extends Controller
{

    public function index(Classwork $classwork)
    {
        return view('classworks.submissions', compact('classwork'));
    }

    public function store(Request $request, Classwork $classwork)
    {
        Gate::authorize('submissions.create', $classwork);

        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => [new ForbiddenFiles(['application/exe', 'aplication/php', 'text/x-php', 'application/x-dosexec'])]
        ]);
        $assigned = $classwork->users()->where('id', Auth::id())->exists();
        if (!$assigned) {
            abort(403, 'This User Not Assigned!!');
        }
        try {
            DB::transaction(function () use ($request, $classwork) {
                $data = [];
                foreach ($request->file('files') as $file) {
                    $data[] = [
                        'classwork_id' => $classwork->id,
                        'content' => $file->store("submissions/{$classwork->id}"),
                        'type' => 'file',
                    ];
                }
                $submission = Auth::user()->submissions()->createMany($data);
                ClassworkUser::where([
                    'user_id' => Auth::id(),
                    'classwork_id' => $classwork->id,
                ])->update([
                    'status' => 'submitted',
                    'submitted_at' => now(),
                    "created_at" => now()
                ]);
            });
        } catch (Throwable $e) {
            return back()->with('danger', $e->getMessage());
        }


        return back()->with('success', 'File Uploaded!');
    }


    public function file(Submission $submission)
    {
        $isTeacher = $submission->classwork->classroom->teachers()->where('id', '=', Auth::id())->get();
        $isOwner = $submission->user_id == Auth::id();
        if (!$isTeacher && !$isOwner) {
            return abort(403);
        }
        return response()->download(storage_path('app/' . $submission->content));
    }
}
