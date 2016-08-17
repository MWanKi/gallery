<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

use App\Comment;

use App\User;

use Validator;

class CommentController extends Controller
{
    function store($article_id, Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		//'secret' => 'required',
    		'content' => 'required|max:300'
		]);

		if ($validator->fails()) {
			return redirect('/'.$article_id)
					->withErrors($validator)
					->withInput();
		} else {
			$article = Article::where('deleted', false)->find($article_id);

			$comment = new Comment;
			$users = User::get();

			$comment->article_id = $article_id;
			$comment->name = $request->name;
			$content = $request->content;
			$comment->secret = false;
			$comment->user_id = auth()->user()->id;

			foreach($users as $user) {
				$user_name = $user->name;
				$content = str_replace('@'.$user_name, '<a class="mention" href="">'.$user_name.'</a>', $content);
			}

			$comment->content = $content;

			$comment->save();

			$data = array(
				'id' => $comment->id, 
				'name' => $request->name, 
				'content' => nl2br($comment->content),
				'created_at' => date("Y-m-d H:i:s",time())
			);
			return $data;
			// return redirect('/'.$article_id);
		}

    }

    function show($id) {

    }

    function destroy($id, Request $request) 
    { 
    	$comment = Comment::find($request->id);
    	// $comment = Comment::where('id',$id)->get();
    	// $comment->deleted = true;
    	$comment->delete();

    	if ($request->xhr) {
    		// return $comment;	
    		// return $request->id;	
    		return 'success';	
    	} else {
    		// return redirect('/');
    	}
    	
    }
}
