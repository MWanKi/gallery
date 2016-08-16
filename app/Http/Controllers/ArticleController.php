<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

use App\URL;

use App\User;

use Validator;

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;


class ArticleController extends Controller
{

    function index() 
    {
    	$articles = Article::where('deleted', false)
					    	->orderBy('created_at', 'desc')
                            ->take(12)
					    	->get();

    	return view('gallery.index', [
    		'articles' => $articles
		]);
    }

    function category(Request $request) 
    {
        $articles = Article::where('deleted', false)
                            ->where('category', $request->c)
                            ->orderBy('created_at', 'desc')
                            ->take(12)
                            ->get();

        return view('gallery.category', [
            'articles' => $articles
        ]);
    }

    function create() 
    {
        return view('gallery.create');
    }

    function show($id) 
    {
        $article = Article::where('deleted', false)->find($id);        

    	$users = User::get();

        if (!auth()->guest()) {
            $writer = User::where('name', auth()->user()->name)->first();
            $hit_list = explode(',', $article->hit);

            if (!in_array($writer->id, $hit_list)) {
                $article->hit = $article->hit.','.$writer->id;
                $article->save();
            }
        } else {
            $client_ip = $_SERVER['REMOTE_ADDR'];
            $hit_list = explode(',', $article->hit);

            if (!in_array($client_ip, $hit_list)) {
                $article->hit = $article->hit.','.$client_ip;
                $article->save();
            }
        }

        $related_articles = Article::where('deleted', false)
                                    ->where('category', $article->category)
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();

        
    	return view('gallery.show', [
    		'article' => $article,
            'related_articles' => $related_articles,
            'users' => $users,
            // 'writer' => $writer
    	]);
    }

    function like($id, Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        $article = Article::where('deleted', false)->find($id);

        if ($validator->fails()) {            
            $data = array_slice(explode(',', $article->like), 0, 1);
        } else {
            $article->like = $article->like.','.$request->name;
            $article->save();

            $data = array_slice(explode(',', $article->like), 0, 1);
        }

        return count($data);
    }

    function usercheck(Request $request)
    {
        $users = User::get();

        $response = 'none';

        foreach($users as $user) {
            if ($user->name == $request->name) {
                $response = 'already';
                break;
            }
        }
        
        return $response;
    }

    function emailcheck(Request $request)
    {
        $users = User::get();

        $response = 'none';

        foreach($users as $user) {
            if ($user->email == $request->email) {
                $response = 'already';
                break;
            }
        }
        
        return $response;
    }

    function edit($id, Request $request)
    {

        $article = Article::find($id);

        return view('gallery.edit', [
            'article' => $article
        ]);
    }
    

    function destroy($id, Request $request)
    {
        $article = Article::find($id);
        $article->deleted = true;
        $article->save();

        if ($request->xhr) {
            return 'success';
        } else {
            return redirect('/articles');
        }
        
    }

    function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'smarteditor' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/'.$id.'/edit')
                    ->withErrors($validator)
                    ->withInput();
        } else {
            $article = Article::find($id);
            $article->title = $request->title;
            $article->category = $request->category;
            $article->creative = $request->creative;
            $article->profit = $request->profit;
            $article->share = $request->share;
            $article->open = $request->open;
            $article->tag = $request->tags;
            $article->body = $request->smarteditor;
            $article->writer_key = auth()->user()->name;

            if ($request->image) {
                $imageName = time() . '.' . $request->file('image')
                                 ->getClientOriginalExtension();
                
                // resizing an uploaded file
                Image::make(
                    $request->file('image'))
                    ->crop(
                        $request->image_w, 
                        $request->image_h, 
                        $request->image_x, 
                        $request->image_y)
                    ->save('uploads/'.$imageName);

                $article->image = $imageName;
            }

            
            $article->save();

            return redirect('/articles');
        }
    }
    
    function store(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'smarteditor' => 'required',
            'image' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/articles/create')
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
            $article->tag = $request->tags;
            $article->body = $request->smarteditor;
            $article->writer_key = auth()->user()->name;

            $imageName = time() . '.' . $request->file('image')
                                 ->getClientOriginalExtension();
            
            // resizing an uploaded file
            Image::make(
                $request->file('image'))
                ->crop(
                    $request->image_w, 
                    $request->image_h, 
                    $request->image_x, 
                    $request->image_y)
                ->save('uploads/'.$imageName);

            $article->image = $imageName;
            
            $article->save();

            return redirect('/articles');
        }
        
    }

}