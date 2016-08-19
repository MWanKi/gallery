<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\Comment;

use App\Article;

class MemberController extends Controller
{
    function userpage($user_id, Request $request) {
        $category = $request->category;
        $user = User::find($user_id);

        // 직접 작성한 게시물
        $writed_articles = Article::where('user_id', $user->id)
                                    ->where('deleted', false)
                                    ->orderBy('id', 'desc')
                                    ->get();        

        // 좋아요를 누른 게시물
        $like_articles = Article::where('like', 'LIKE', '%*'.$user->name.'*%')
                            ->where('deleted', false)
                            ->orderBy('id', 'desc') 
                            ->get();


        $articles = array();
        $users = array();

        // 팔로우
        $follow = explode(',', str_replace('*','',$user->follow));
        $follow = User::whereIn('id', $follow)->get();
        $follow_list = array();
        $follow_like_count = 0;

        // 팔로워
        $followers = User::where('follow', 'Like', '%*'.$user->id.'*%')->get();

        if ($category == '' || $category == 'works') {
            $title = '게시한 작품들입니다.';
            $articles = $writed_articles;

        } else if ($category == 'likes') {
            $title = '좋아요를 누른 작품들입니다.';
            $articles = $like_articles;

        } else if ($category == 'follow') {
            $title = '팔로우 하는 작가들입니다.';
            $users = $follow;

        } else if ($category == 'follower') {
            $title = '나를 팔로우 하는 사람들입니다.';
            $users = $followers;
        }
            

        // 작성한 게시물 개수
        $count_aritlces = count($writed_articles);

        // 좋아요 게시물 개수
        $count_like = count($like_articles);

        return view('user.userpage', [
            'user' => $user,
            'users' => $users,
            'follow' => $follow,
            'follow_list' => $follow_list,
            'followers' => $followers,
            'articles' => $articles,
            'category' => $category,
            'title' => $title,
            'writed_articles' => $writed_articles,
            'count_aritlces' => $count_aritlces,
            'like_articles' => $like_articles,
            'count_like' => $count_like
        ]);
    }

    function mypage($user_id, Request $request) {
        $category = $request->category;
        $user = User::find($user_id);

        // 직접 작성한 게시물
        $writed_articles = Article::where('user_id', $user->id)
                                    ->where('deleted', false)
                                    ->orderBy('id', 'desc')
                                    ->get();        

        // 좋아요를 누른 게시물
        $like_articles = Article::where('like', 'LIKE', '%*'.$user->name.'*%')
                            ->where('deleted', false)
                            ->orderBy('id', 'desc') 
                            ->get();


        $articles = array();
        $users = array();

        // 팔로우
        $follow = explode(',', str_replace('*','',$user->follow));
        $follow = User::whereIn('id', $follow)->get();
        $follow_list = array();
        $follow_like_count = 0;

        // 팔로워
        $followers = User::where('follow', 'Like', '%*'.$user->id.'*%')->get();

        if ($category == '' || $category == 'works') {
            $title = '게시한 작품들입니다.';
            $articles = $writed_articles;

        } else if ($category == 'likes') {
            $title = '좋아요를 누른 작품들입니다.';
            $articles = $like_articles;

        } else if ($category == 'follow') {
            $title = '팔로우 하는 작가들입니다.';
            $users = $follow;

        } else if ($category == 'follower') {
            $title = '나를 팔로우 하는 사람들입니다.';
            $users = $followers;
        }
            

        // 작성한 게시물 개수
        $count_aritlces = count($writed_articles);

        // 좋아요 게시물 개수
        $count_like = count($like_articles);

        return view('user.mypage', [
            'user' => $user,
            'users' => $users,
            'follow' => $follow,
            'follow_list' => $follow_list,
            'followers' => $followers,
            'articles' => $articles,
            'category' => $category,
            'title' => $title,
            'writed_articles' => $writed_articles,
            'count_aritlces' => $count_aritlces,
            'like_articles' => $like_articles,
            'count_like' => $count_like
        ]);
    }

    function follow(Request $request) {
        $user = User::find(auth()->user()->id);

        $follow_users = array_filter(explode(',',$user->follow));

        if (!in_array('*'.$request->follow_id.'*', $follow_users)) {
            // follow에 다른 유저 아이디
            array_push($follow_users, '*'.$request->follow_id.'*');
            $user->follow = implode(',', $follow_users);
            $user->save();

            // 다른 유저에 현재 유저 아이디
            $followed_user = User::find($request->follow_id);
            $follower = array_filter(explode(',', $followed_user->follower));
            array_push($follower, '*'.$user->id.'*');
            $followed_user->follower = implode(',', $follower);
            $followed_user->save();

            return 'success';    
        } else {
            return 'failed';    
        }

        
    }

    function followcancel(Request $request) {
        $user = User::find(auth()->user()->id);
        $follow_users = explode(',', $user->follow);

        if (in_array('*'.$request->follow_id.'*', $follow_users)) {
            $key = array_search('*'.$request->follow_id.'*', $follow_users);
            array_splice($follow_users, $key, 1);
            $user->follow = implode(',',$follow_users);
            $user->save();

            $follower = User::find($request->follow_id);
            $follower_list = array_filter(explode(',', $follower->follower));
            $key2 = array_search('*'.$user->id.'*', $follower_list);
            array_splice($follower_list, $key2, 1);
            $follower->follower = implode(',',$follower_list);
            $follower->save();

            return 'success';    
        } else {
            return 'failed';    
        }
    }
}
