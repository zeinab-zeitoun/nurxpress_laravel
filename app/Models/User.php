<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'UID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // get regular user corresponsing to auth user
    public function regularUser()
    {
        // get id of auth user
        $id = auth()->user()->id;
        // get the corresponding regular user
        $regular_user = RegularUser::where('user_id', $id)->get()->first();

        return $regular_user;
    }

    // get nurse corresponsing to auth user
    public function nurse()
    {
        // get id of auth user
        $id = auth()->user()->id;
        // get the corresponding regular user
        $nurse = Nurse::where('user_id', $id)->get()->first();

        return $nurse;
    }

    //get all the comments of this user
    public function comments()
    {
        //$posts = Post::where('created_at', '>', (new \Carbon\Carbon)->submonths(1))->latest()->get();
        //get all comments of user on all his posts
        return $this->hasManyThrough(Comment::class, Post::class)->latest()->get();
    }
}
