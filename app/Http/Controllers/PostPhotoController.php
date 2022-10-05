<?php

namespace App\Http\Controllers;

use App\Models\PostPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostPhotoController extends Controller
{

    public function destroy($id)
    {
        $image = PostPhoto::findOrfail($id);
        unlink(storage_path('app/public/posts/'.$image->photo_path));
        $image->delete();
        return back();
    }
}
