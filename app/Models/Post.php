<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function postImages() {
        return $this->hasMany('App\Models\PostPhoto', 'post_id', 'id');
    }

    public function postComments() {
        return $this->hasMany('App\Models\PostComment', 'post_id', 'id');
    }

    public function postLikes() {
        return $this->hasMany('App\Models\PostLike', 'post_id', 'id');
    }

    public function postHashTags() {
        return $this->hasMany('App\Models\PostHashTag', 'post_id', 'id');
    }
}
