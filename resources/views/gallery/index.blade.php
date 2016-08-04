@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index">
	<h2>C.GALLERY의 최근 게시물입니다.</h2>
	<ul class="main-article">
		@foreach($articles->all() as $article)
			<li>
				<a href="{{ url('/'.$article->id) }}">
					<img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}" class="thumbnail">
					<div class="desc-box">
						<img src="{{ url('images/logo.png') }}" alt="" class="profile">
						<span class="title">{{ $article->title }}</span>
						<span class="writer">by. </span>
					</div>
				</a>
			</li>
		@endforeach
	</ul>
</div>
@endsection