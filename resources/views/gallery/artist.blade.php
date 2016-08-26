@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index wrap-artist">
	<h2>C.GALLERY의 인기 작가들입니다.</h2>
	<div class="box-like-content">
		<h2></h2>
		<ul class="ul-follow-users">
			@foreach($users as $user)
				<li class="li-data">
					<a href="{{ url('/userpage/'.$user->id.'?category=works') }}">
						<div class="box-profile">
							<div class="box-image">
								@if ($user->image != '')
									<img src="{{ url('/uploads/'.$user->image) }}" alt="">
								@else
									<img src="{{ url('/images/profile2.png') }}" alt="">
								@endif
							</div>	
							<p class="name">{{ $user->name }}</p>
						</div>
					</a>
					<div class="box-etc">
						<ul>
							<li>
								<span class="icon"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
								<span class="count">{!! count($user->articles) !!}</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
								<span class="count">{{ $user->liked }}</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
								<span class="count">{!! count(array_filter(explode(',',$user->follower))) !!}</span>
							</li>
						</ul>
					</div>

					<div class="box-article">
						<ul>
							@foreach($user->articles->where('deleted', 0)->take(8) as $article)
								<li><a href="{{ url('/articles/'.$article->id) }}"><img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}"></a></li>
							@endforeach
						</ul>
					</div>

					<div class="box-act">
						@if (!auth()->guest())
							@if (in_array('*'.$user->id.'*', explode(',',auth()->user()->follow)))
								<a class="btn-follow btn-already-follow" data-id="{{ $user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>현재 팔로우 중입니다.</span></a>
							@else
								@if ($user->id == auth()->user()->id)
									<a class="btn-follow disabled" href="#"><span>본인입니다.</span></a>
								@else
									<a class="btn-follow" data-id="{{ $user->id }}" data-cancel-url="{{ url('/followcancel') }}" data-url="{{ url('/follow') }}" data-csrf-token="{{ csrf_token() }}" href="#"><i class="fa fa-star" aria-hidden="true"></i> <span>팔로우</span></a>
								@endif
							@endif
						@else
							<a class="btn-follow" href="{{ url('/auth/login') }}"><i class="fa fa-star" aria-hidden="true"></i> <span>팔로우</span></a>
						@endif
					</div>
				</li>
			@endforeach
		</ul>
	</div>
</div>
@endsection