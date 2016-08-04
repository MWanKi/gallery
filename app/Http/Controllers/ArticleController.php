<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

use Validator;

class ArticleController extends Controller
{
    function index() 
    {
    	$articles = Article::where('deleted', false)
					    	->orderBy('created_at', 'desc')
					    	->get();
    	

    	return view('gallery.index', [
    		'articles' => $articles
		]);
    }

    function show($id) 
    {
    	$article = Article::where('deleted', false)->find($id);

    	return view('gallery.show', [
    		'article' => $article
    	]);
    }

    function upload() 
    {
    	return view('gallery.upload');
    }

    function store(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'smarteditor' => 'required',
            'image' => 'required',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('upload')
                    ->withErrors($validator)
                    ->withInput();
        } else {
            $article = new Article;
            $article->title = $request->title;
            $article->category = $request->category;
            $article->creative = $request->creative;
            $article->profit = $request->profit;
            $article->share = $request->share;
            $article->open = $request->open;
            $article->tag = $request->tag;
            $article->body = $request->smarteditor;

            $imageName = time() . '.' . $request->file('image')
                                 ->getClientOriginalExtension();

            $article->image = $imageName;
            
            $request->file('image')
                    ->move('uploads', $imageName);
            $article->save();

            return redirect('/');
        }
        
    }
}