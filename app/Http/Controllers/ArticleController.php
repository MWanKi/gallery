<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

use App\Comment;

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
                            ->take(15)
					    	->get();

    	return view('gallery.index', [
    		'articles' => $articles
		]);
    }

    function subscription() {
         $articles = Article::where('deleted', false)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);
                    $articles->setPath('works');     
                    $category = '';
        
        
        return view('gallery.works', [
            'articles' => $articles,
            'category' => $category
        ]);
    }

    function works(Request $request) 
    {
        if (isset($request->cate)) {
            switch ($request->cate) {

                case 'A':
                    $articles = Article::where('deleted', false)
                            ->where('category',0)
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
                    $articles->setPath('works?cate='.$request->cate);    
                    $category = 'A';
                    break;
                case 'B':
                    $articles = Article::where('deleted', false)
                            ->where('category',1)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);
                    $articles->setPath('works?cate='.$request->cate);    
                    $category = 'B';
                    break;
                case 'C':
                    $articles = Article::where('deleted', false)
                            ->where('category',2)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);
                    $articles->setPath('works?cate='.$request->cate);      
                    $category = 'C';
                    break;
                case 'D':
                    $articles = Article::where('deleted', false)
                            ->where('category',3)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);
                    $articles->setPath('works?cate='.$request->cate);    
                    $category = 'D';
                    break;   
                case 'new':
                    $articles = Article::where('deleted', false)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);
                    $articles->setPath('works?cate='.$request->cate);    
                    $category = 'new';
                    break;   
                case 'hit':
                    $articles = Article::where('deleted', false)
                            ->orderBy('hit_count', 'desc')
                            ->paginate(25);
                    $articles->setPath('works?cate='.$request->cate);    
                    $category = 'hit';
                    break;   
                case 'like':
                    $articles = Article::where('deleted', false)
                            ->orderBy('like_count', 'desc')
                            ->paginate(25);
                    $articles->setPath('works?cate='.$request->cate);    
                    $category = 'like';
                    break;    
            }
        } else {
            $articles = Article::where('deleted', false)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);
                    $articles->setPath('works');     
                    $category = '';
        }
        
        return view('gallery.works', [
            'articles' => $articles,
            'category' => $category
        ]);
    }

    function artist(Request $request) 
    {

        if (isset($request->cate)) {
            switch ($request->cate) {
                case 'follow-top100':
                    $users = User::where('deleted', false)
                        ->orderBy('follower_count', 'desc')
                        ->take(100)
                        ->paginate(20);
                    $users->setPath('artist?cate='.$request->cate);
                    $category = 'follow-top100';
                    break;
                case 'likes-top100':
                    $users = User::where('deleted', false)
                        ->orderBy('liked', 'desc')
                        ->take(100)
                        ->paginate(20);
                    $users->setPath('artist?cate='.$request->cate);
                    $category = 'likes-top100';
                    break;
                case 'works':
                    $users = User::where('deleted', false)
                        ->orderBy('upload_articles', 'desc')
                        ->paginate(20);
                    $users->setPath('artist?cate='.$request->cate);
                    $category = 'works';
                    break;
                case 'new':
                    $users = User::where('deleted', false)
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
                    $users->setPath('artist?cate='.$request->cate);
                    $category = 'new';
                    break;
            }
        } else {
            $users = User::where('deleted', false)
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
            $users->setPath('artist');
            $category = '';
        }

        return view('gallery.artist', [
            'users' => $users,
            'category' => $category
        ]);
    }

    function create() 
    {   
        if (auth()->guest()) {
            return redirect('/auth/login');
        }
        return view('article.create');
    }

    function show($id) 
    {
        $article = Article::with('comments.user')->where('deleted', false)->find($id);        
    	$users = User::get();

        if (!auth()->guest()) {
            $writer = User::where('name', auth()->user()->name)->first();
            $hit_list = explode(',', $article->hit);

            if (!in_array($writer->id, $hit_list)) {
                $article->hit = $article->hit.','.$writer->id;
                $article->hit = array_filter(explode(',',$article->hit));
                $article->hit_count = count($article->hit);
                $article->hit = implode(',',$article->hit);
                $article->save();
            }
        } else {
            $client_ip = $_SERVER['REMOTE_ADDR'];
            $hit_list = explode(',', $article->hit);

            if (!in_array($client_ip, $hit_list)) {
                $article->hit = $article->hit.','.$client_ip;
                $article->hit = array_filter(explode(',',$article->hit));
                $article->hit_count = count($article->hit);
                $article->hit = implode(',',$article->hit);
                $article->save();
            }
        }

        $related_articles = Article::where('deleted', false)
                                    ->where('category', $article->category)
                                    ->whereNotIn('id', [$id])
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();

        
    	return view('article.show', [
    		'article' => $article,
            'related_articles' => $related_articles,
            'users' => $users,
    	]);
    }

    function like($id, Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);


        $article = Article::where('deleted', false)->find($id);
        $user = User::find($article->user_id);

        if ($validator->fails()) {            
            $data = array_slice(explode(',', $article->like), 0, 1);
        } else {
            $article->like = $article->like.','.'*'.$request->name.'*';
            $article->like = array_filter(explode(',', $article->like));
            $article->like_count = count($article->like);
            $article->like = implode(',', $article->like);
            $article->save();

            $user->liked = $user->liked+1;
            $user->save();
            // $data = array_slice(explode(',', $article->like), 0, 1);
        }

        return count($article->like);
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
        if (auth()->guest()) {
            return redirect('/auth/login');
        }
        $article = Article::find($id);

        return view('article.edit', [
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
            $article->user_id = auth()->user()->id;

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

            return redirect('/articles/'.$article->id);
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
            $article->user_id = auth()->user()->id;

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

            // 업로드한 게시물 수
            $user = User::find(auth()->user()->id);
            $upload_articles = Article::where('deleted', false)
                                        ->where('user_id', auth()->user()->id)
                                        ->get();
            $user->upload_articles = count($upload_articles);
            $user->save();

            // return redirect('/articles/'.$article->id);
        }
        
    }

}