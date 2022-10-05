<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postComments(Request $request)
    {
        $result = [];
        if ($request->ajax()) {
            if ($request->post != null) {
                $comments = PostComment::select('user_id')->where('post_id',$request->post)->get();
                foreach ($comments as $comment) {
                    $result[] = $comment->user_id;
                }
                return response()->json($result);
            }
        }
    }

    public function comment(Request $request)
    {
        if ($request->ajax()) {
            if ($request->post != null && $request->comment != null) {
                $comment = new PostComment();
                $comment->comment = $request->comment;
                $comment->post_id = $request->post;
                $comment->user_id = auth()->user()->id;
                $comment->save();
                return response()->json(PostComment::with('user')->where('id',$comment->id)->first());
            }
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->comment != null) {
                PostComment::findOrfail($request->comment)->delete();
                return response()->json('success');
            }
        }
    }
}
