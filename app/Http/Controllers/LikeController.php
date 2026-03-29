<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post){
        $user = auth()->user();

        if($post->isLikedBy($user)){
            $post->likes()->where('user_id', $user->id)->delete();
        } else{
            $post->likes()->create(['user_id' => $user->id]);
        }

        return back();
        }
    }