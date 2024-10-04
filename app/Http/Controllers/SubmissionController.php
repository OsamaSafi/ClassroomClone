<?php

namespace App\Http\Controllers;

use App\Events\ClassworkSubmission;
use App\Models\Classwork;
use App\Models\ClassworkUser;
use App\Models\Submission;
use App\Rules\ForbiddenFiles;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SubmissionController extends Controller
{

    public function index(Classwork $classwork)
    {

        $submissions = Submission::where('classwork_id', $classwork->id)
            ->with(['user', 'classwork']) // تأكد من أن لديك العلاقات المعرفة
            ->get();

        // جلب الدرجات من جدول classwork_user
        foreach ($submissions as $submission) {
            $submission->grade = DB::table('classwork_user')
                ->where('classwork_id', $classwork->id)
                ->where('user_id', $submission->user_id)
                ->value('grade'); // جلب الدرجة
        }

        return view('classworks.submissions', compact('submissions', 'classwork'));
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


    public function updateGrade(Request $request, Submission $submission)
    {
        $request->validate([
            'grade' => "required|min:0"
        ]);
        ClassworkUser::where([
            'user_id' => $submission->user_id,
            'classwork_id' => $submission->classwork_id,
        ])->update([
            'status' => 'returned',
            'grade' => $request->input('grade')
        ]);

        // $validator = Validator($request->all(), [
        //     'grade' => "required|min:0",
        // ]);


        // if (! $validator->fails()) {
        //     $isUpdate = ClassworkUser::where([
        //         'user_id' => $submission->user_id,
        //         'classwork_id' => $submission->classwork_id,
        //     ])->update([
        //         'status' => 'returned',
        //         'grade' => $request->input('grade')
        //     ]);
        //     return response()->json([
        //         'message' => $isUpdate ? "Grade Updated Successfully" : "Update faild"
        //     ], $isUpdate ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        // } else {
        //     return response()->json([
        //         'message' => $validator->getMessageBag()->first()
        //     ], Response::HTTP_BAD_REQUEST);
        // }

        return redirect()->back()->with('success', 'submission graded');
    }
}
