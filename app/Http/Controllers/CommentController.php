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
			$comment->article_id = $article_id;
			$comment->name = $request->name;
			$comment->content = $request->content;

			$comment->secret = false;
			$comment->save();

			$data = array(
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

    function destroy($id, Request $request) {
    	$comment = Comment::find($id);
    	$comment->deleted = true;
    	$comment->save();

    	if ($request->xhr) {
    		return 'success';	
    	} else {
    		// return redirect('/');
    	}
    	
    }
}
