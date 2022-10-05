<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postLikes(Request $request)
    {
        $result = [];
        if ($request->ajax()) {
            if ($request->post != null) {
                $likes = PostLike::select('user_id')->where('post_id',$request->post)->get();
                foreach ($likes as $like) {
                    $result[] = $like->user_id;
                }
                return response()->json($result);
            }
        }
    }

    public function like(Request $request)
    {
        if ($request->ajax()) {
            if ($request->post != null) {
                $like = new PostLike();
                $like->post_id = $request->post;
                $like->user_id = auth()->user()->id;
                $like->save();

                return response()->json('success');
            }
        }
    }

    public function dislike(Request $request)
    {
        if ($request->ajax()) {
            if ($request->post != null) {
                PostLike::where('post_id',$request->post)->where('user_id',auth()->user()->id)->delete();
                return response()->json('success');
            }
        }
    }
}
