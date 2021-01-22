<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Nurse;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // get comments on post
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        $comments = $post->comments();

        //add to the comment object it name of the commenter
        $commenter = false;
        foreach ($comments as $comment) {

            // check if the auth user is the commenter and add it to comment object
            $user_id = $comment->user_id;
            $auth_id = auth()->user()->id;
            $commenter = ($user_id === $auth_id);
            $comment->setAttribute('commenter', $commenter);

            //get the nurse who commented
            $commenter = Nurse::where('user_id', $comment->user_id)->get()->first();
            $firstName = $commenter->firstName;
            $comment->setAttribute('firstName', $firstName);
            $lastName = $commenter->lastName;
            $comment->setAttribute('lastName', $lastName);
        }
        return $comments;
    }

    //get last 2 comments on post
    public function showTwoComments($post_id)
    {
        $post = Post::findOrFail($post_id);
        $comments = $post->lastTwoComments();

        return $comments;
    }

    //get all comments of on all users posts
    public function index()
    {

        // get auth user
        $user = auth()->user();
        $comments = $user->comments();

        //remove all comments done by the author himself
        $commentsWithoutAuthor = [];
        foreach ($comments as $comment) {
            if ($user->id !== $comment->user_id)
                Array_push($commentsWithoutAuthor, $comment);
        }

        foreach ($commentsWithoutAuthor as $comment) {

            //get the nurse who commented
            $commenter = Nurse::where('user_id', $comment->user_id)->get()->first();
            $firstName = $commenter->firstName;
            $comment->setAttribute('firstName', $firstName);
            $lastName = $commenter->lastName;
            $comment->setAttribute('lastName', $lastName);
        }

        return $commentsWithoutAuthor;
    }

    public function store(Request $request, $post_id)
    {
        //validate data
        $request->validate([
            'comment' => 'required|string',
        ]);

        // get auth user
        $user = auth()->user();

        //create and save the new comment
        $comment = new Comment([
            'comment' => $request->comment,
            'post_id' => $post_id,
            'user_id' => $user->id,
            'read' => 0,
        ]);

        $comment->save();

        // return a success response
        return response()->json([
            'msg' => 'Comment is successfulyy Added!'
        ]);
    }

    public function update(Request $request, $id)
    {
        //validate data
        $request->validate([
            'comment' => 'required|string',
        ]);

        // get the comment that need to be updated and update
        Comment::findOrFail($id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'comment is successfulyy Updated!'
        ]);
    }

    public function destroy($id)
    {
        // get the comment that need to be deleted
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }

    public function markRead($id)
    {
        // get the comment that need to be marked as read and update it
        Comment::findOrFail($id)
            ->update(['read' => 1]);

        // return a success response
        return response()->json([
            'msg' => 'comment is marked as read!'
        ]);
    }

    // return number of unread comments
    public function unreadComments()
    {
        $user = auth()->user();
        // get comments on all the user's posts
        $comments = $user->comments();

        $count = 0;

        foreach ($comments as $comment) {
            if ($comment->read == 0)
                $count += 1;
        }

        return $count;
    }
}
