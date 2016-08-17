<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\Comment;

use App\Article;

class MemberController extends Controller
{
    function mypage($user_id, Request $request) {
        $category = $request->category;
        $user = User::find($user_id);

        // 직접 작성한 게시물
        $writed_articles = Article::where('user_id', $user->id . 'AND' . 'deleted', false)
                                    ->orderBy('id', 'desc')
                                    ->get();        

        // 좋아요를 누른 게시물
        $like_articles = Article::where('like', 'LIKE', ','.$user->name)
                            ->orderBy('id', 'desc') 
                            ->get();


        $articles = [];
        $users = [];

        if ($category == '' || $category == 'works') {
            $articles = $writed_articles;
            $title = '게시한 작품들입니다.';
        } else if ($category == 'likes') {
            $articles = $like_articles;
            $title = '좋아요를 누른 작품들입니다.';
        } else if ($category == 'follow') {
            $users = $user;
            $title = '팔로우 하는 작가들입니다.';
        } else if ($category == 'follower') {
            $users = User::where('follower', 'LIKE', ','.$user->id)->get();
            $title = '나를 팔로우 하는 사람들입니다.';
        }
            

        // 좋아요 게시물 개수
        $count_aritlces = count($writed_articles);
        $count_like = count($like_articles);

        return view('gallery.mypage', [
            'user' => $user,
            'users' => $users,
            'articles' => $articles,
            'category' => $category,
            'title' => $title,
            'writed_articles' => $writed_articles,
            'count_aritlces' => $count_aritlces,
            'like_articles' => $like_articles,
            'count_like' => $count_like
        ]);
    }
}
