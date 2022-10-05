<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostHashTag;
use App\Models\PostPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::paginate(6);
        return view('posts.index',compact('posts'));
    }

    public function postHashTag($hashtag)
    {
        $hashtags = PostHashTag::select('post_id')->where('hashtag','like','%'.$hashtag.'%')->get()->toArray();
        $posts = Post::whereIn('id',$hashtags)->paginate(6);
        return view('posts.hashtags',compact('posts','hashtag'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'images.*' => 'required|mimes:png,jpg,jpeg|max:10240'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        $post->save();

        if ($request->images) {
            foreach ($request->images as $image) {
                $fileName   = time() . $image->getClientOriginalName();
                Storage::disk('public')->put('posts/' . $fileName, File::get($image));
                $post_image = new PostPhoto();
                $post_image->photo_path = $fileName;
                $post_image->post_id = $post->id;
                $post_image->save();
            }
        }

        if ($request->hashtag) {
            foreach (explode(',',$request->hashtag) as $hash) {
                $tag = new PostHashTag();
                $tag->hashtag = $hash;
                $tag->post_id = $post->id;
                $tag->save();
            }
        }

        return back();
    }

    public function show($post_id)
    {
        $post = Post::where('id',$post_id)->with('postImages')->first();
        return view('posts.single-post',compact('post'));
    }

    public function edit($id)
    {
        $post = Post::where('id',$id)->with('postImages')->first();
        return view('posts.edit-post',compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'images.*' => 'required|mimes:png,jpg,jpeg|max:10240'
        ]);

        $post = Post::findOrfail($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        $post->save();

        if ($request->images) {
            foreach ($request->images as $image) {
                $fileName   = time() . $image->getClientOriginalName();
                Storage::disk('public')->put('posts/' . $fileName, File::get($image));
                $post_image = new PostPhoto();
                $post_image->photo_path = $fileName;
                $post_image->post_id = $post->id;
                $post_image->save();
            }
        }

        return back();
    }

    public function destroy($id)
    {
        $post = Post::where('id',$id)->first();
        if ($post->user_id == auth()->user()->id) {
            $post->delete();
        }
        return back();
    }
}
