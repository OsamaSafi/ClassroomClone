<?php

namespace App\Http\Controllers;

use App\Events\ClassworkCommented;
use App\Models\Classwork;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['string', 'required'],
            'comentable_id' => ['required'],
            'comentable_type' => ['required']
        ]);

        $comment = Auth::user()->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'comentable_type' =>  $request->comentable_type,
            'comentable_id' => $request->comentable_id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        event(new ClassworkCommented($comment));
        return back()->with('success', 'comment created');
    }

    public function destroy(Request $request, Comment $comment)
    {
        $comment->delete($request->all());
        return back()->with('success', 'comment deleted');
    }
}
