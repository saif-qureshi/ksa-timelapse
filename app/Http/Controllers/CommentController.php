<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Photo;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('comments.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'photo_id' => 'required|exists:photos,id'
        ]);

        auth()->user()->comments()->create([
            'message' => $request->message,
            'photo_id' => $request->photo_id,
        ]);

        return response()->json('Comment posted successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back();
    }

    public function approve(Comment $comment)
    {
        $comment->update([
            'is_approved' => true,
        ]);

        return redirect()->back();
    }
}
