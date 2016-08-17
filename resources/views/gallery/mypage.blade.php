@extends('layouts/gallery')
@section('title')
:: {{ auth()->user()->name }}
@endsection
@section('content')
<div class="wrap-profile">
	<div class="box-profile">
		<div class="box-card">
			<div class="box-cover">
				@if ($user->image != '')
					<img src="{{ url('/uploads/'.$user->image) }}" alt="">
				@else
					<img src="{{ url('/images/profile2.png') }}" alt="">
				@endif
			</div>
			<div class="box-info">
				<p class="name">{{ $user->name }}</p>
				<p class="intro">
					@if ($user->intro != '')
						{{ $user->intro }}
					@else
						자기소개가 없습니다.
					@endif 
				</p>
			</div>
			<a class="btn-profile-update" href="{{ url('/mypage/'.auth()->user()->id.'/edit') }}">프로필 수정하기</a>
		</div>
	</div>
	<div class="box-sub-menu">
		<ul>
			@if ($category == '' || $category == 'works')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/mypage/'.auth()->user()->id.'?category=works') }}">
					<p class="name">작품</p>
					<p class="count">{{ $count_aritlces }}</p>
				</a>
			</li>
			@if ($category == '' || $category == 'likes')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/mypage/'.auth()->user()->id.'?category=likes') }}">
					<p class="name">좋아요</p>
					<p class="count">{{ $count_like }}</p>
				</a>
			</li>
			@if ($category == '' || $category == 'follow')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/mypage/'.auth()->user()->id.'?category=follow') }}">
					<p class="name">팔로우</p>
					<p class="count">{!! count($user->follow)-1 !!}</p>
				</a>
			</li>
			@if ($category == '' || $category == 'follower')
				<li class="on">
			@else
				<li>
			@endif
				<a href="{{ url('/mypage/'.auth()->user()->id.'?category=follower') }}">
					<p class="name">팔로워</p>
					<p class="count">{!! count($users) !!}</p>
				</a>
			</li>

		</ul>
	</div>
	<!-- <span id="bg" class="bg-profile" style="background-image:url({{ url('/uploads/'.$user->image) }});"></span> -->
	<span id="bg" class="bg-profile"></span>
</div>
<script>
	$(function(){
		var profileHeight = $('.wrap-profile').height();
		$('.wrap-mypage').css({'padding-top':profileHeight});
		$('#bg').backgroundBlur({
		    imageURL : "{{ url('/uploads/'.$user->image) }}",
		    blurAmount : 50,
		    imageClass : 'bg-blur'
		});
	});
</script>
<div class="wrap-mypage">
	<div class="box-content">
		@if (count($articles) > 0)
			<div class="box-like-content">
				<h2>{{ $title }}</h2>
				<ul class="ul-like-articles">
					@foreach($articles as $article)
						<li class="li-data">
							<a href="{{ url('/articles/'.$article->id) }}">
								<div class="box-image">
									<img src="{{ url('/uploads/'.$article->image) }}" alt="">
								</div>
								<div class="box-info">
									<div class="box-profile-image">
										<img src="{{ url('/uploads/'.$article->user->image) }}" alt="">
									</div>
									<p class="title">{{ $article->title }}</p>
									<p class="writer">by. {{ $article->user->name }}</p>
								</div>
								<div class="box-etc">
									<ul>
										<li>
											<span class="icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
											<span class="count">{!! count(explode(',',$article->hit))-1 !!}</span>
										</li>
										<li>
											<span class="icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
											<span class="count">{!! count(explode(',',$article->like))-1 !!}</span>
										</li>
										<li>
											<span class="icon"><i class="fa fa-comment" aria-hidden="true"></i></span>
											<span class="count">{!! count($article->comments) !!}</span>
										</li>
									</ul>
								</div>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		@endif
		<!-- 팔로워 / 팔로우 리스트 -->
		@if (count($users) > 0)
			<div class="box-like-content">
				<h2>{{ $title }}</h2>
				<ul class="ul-like-articles">
					@foreach($articles as $article)
						<li class="li-data">
							<a href="{{ url('/articles/'.$article->id) }}">
								<div class="box-image">
									<img src="{{ url('/uploads/'.$article->image) }}" alt="">
								</div>
								<div class="box-info">
									<div class="box-profile-image">
										<img src="{{ url('/uploads/'.$article->user->image) }}" alt="">
									</div>
									<p class="title">{{ $article->title }}</p>
									<p class="writer">by. {{ $article->user->name }}</p>
								</div>
								<div class="box-etc">
									<ul>
										<li>
											<span class="icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
											<span class="count">{!! count(explode(',',$article->hit))-1 !!}</span>
										</li>
										<li>
											<span class="icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
											<span class="count">{!! count(explode(',',$article->like))-1 !!}</span>
										</li>
										<li>
											<span class="icon"><i class="fa fa-comment" aria-hidden="true"></i></span>
											<span class="count">{!! count($article->comments) !!}</span>
										</li>
									</ul>
								</div>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
</div>
@endsection