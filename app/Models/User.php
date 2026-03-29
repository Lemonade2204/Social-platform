<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'profile_image', 'about'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

     public function likes() {return $this->hasMany(Like::class);  }
    public function comments() {return $this->hasMany(Comment::class)->latest();}



    public function followers() 
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'followed_user_id',
            'user_id'
        );
    }

    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'user_id',
            'followed_user_id'
        );
    }

    public function isFollowing(User $other): bool {
        return $this->followings()->where('followed_user_id', $other->id)->exists();
    }
}
