<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Nurse;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // specify whether the authentitaed user is the author of the post
        $author = false;

        // get all posts in the last 1 month
        $posts = Post::where('created_at', '>', (new \Carbon\Carbon)->submonths(1))->latest()->get();

        foreach ($posts as $post) {

            // check if the auth user is the author and add it to post object
            $user_id = $post->user_id;
            $auth_id = auth()->user()->id;
            $author = ($user_id === $auth_id);
            $post->setAttribute('author', $author);

            //get nurse/ author and add its name  to post object
            $nurse = Nurse::where('user_id', $post->user_id)->get()->first();
            $firstName = $nurse->firstName;
            $post->setAttribute('firstName', $firstName);
            $lastName = $nurse->lastName;
            $post->setAttribute('lastName', $lastName);

            // get last comment on this post
            $comment = Comment::where('post_id', $post->id)->get()->first();
            //add to it name of the commenter
            if (!is_null($comment)) {
                //get the nurse who commented
                $commenter = Nurse::where('user_id', $comment->user_id)->get()->first();
                $firstName = $commenter->firstName;
                $comment->setAttribute('firstName', $firstName);
                $lastName = $commenter->lastName;
                $comment->setAttribute('lastName', $lastName);
            }

            $post->setAttribute('comment', $comment);
        }
        return $posts;
    }

    //get post of a certain id
    public function show($id)
    {
        $post = Post::findOrFail($id);

        //get name
        $user = auth()->user();
        $nurse = $user->nurse();
        $post->setAttribute('firstName', $nurse->firstName);
        $post->setAttribute('lastName', $nurse->lastName);
        
        // check if the auth user is the author and add it to post object
        $user_id = $post->user_id;
        $auth_id = auth()->user()->id;
        $author = ($user_id === $auth_id);
        $post->setAttribute('author', $author);
        

        return $post;
    }

    public function store(Request $request)
    {

        //validate data
        $request->validate([
            'post' => 'required'
        ]);

        // get auth user
        $user = auth()->user();

        //create and save the new post
        $post = new Post([
            'user_id' => $user->id,
            'post' => $request->post
        ]);

        $post->save();

        // return a success response
        return response()->json([
            'msg' => 'Post is successfulyy Added!'
        ]);
    }

    public function update(Request $request, $id)
    {

        //validate data
        $request->validate([
            'post' => 'required|string'
        ]);

        // get the post that need to be updated and update
        Post::findOrFail($id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'Post is successfulyy Updated!'
        ]);
    }

    public function destroy($id)
    {
        // get the post that need to be deleted
        $post = Post::findOrFail($id);
        $post->delete();
    }
}
