<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $me= auth()->user();

        if ($me->id === $user->id){
            return back();
        }
        $me->followings()->toggle($user->id);
        return back();

    }
}