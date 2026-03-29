<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index() {

        $user=auth()->user();

        $followingIds = $user->followings()->pluck('users.id');

        $posts = Post::with(['user','likes','comments.user'])
        ->whereIn('user_id', $followingIds)
        ->latest()
        ->paginate(10);

        return view('timeline.index', compact('posts'));

    }
}