<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->latest()->get();
        return view('profile.show', compact('user', 'posts'));
    }
}
