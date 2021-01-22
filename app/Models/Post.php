<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'post', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->get();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->get();
    }

    public function lastTwoComments()
    {
        return $this->hasMany(Comment::class)->latest()->take(2)->get();
    }
}
