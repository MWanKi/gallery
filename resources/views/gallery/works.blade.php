@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index">
	<ul class="ul-works-cate">
		<li><a class="{{ $category == '' ? 'on' : '' }}" href="{{ url('/works') }}">전체보기</a></li>
		<li><a class="{{ $category == 'A' ? 'on' : '' }}" href="{{ url('/works?cate=A') }}">카테고리1</a></li>
		<li><a class="{{ $category == 'B' ? 'on' : '' }}" href="{{ url('/works?cate=B') }}">카테고리2</a></li>
		<li><a class="{{ $category == 'C' ? 'on' : '' }}" href="{{ url('/works?cate=C') }}">카테고리3</a></li>
		<li><a class="{{ $category == 'D' ? 'on' : '' }}" href="{{ url('/works?cate=D') }}">카테고리4</a></li>
	</ul>
	<h2>C.GALLERY의 카테고리 게시물입니다.</h2>
	<ul class="main-article">
		@foreach($articles->all() as $article)
			<li>
				<a href="{{ url('/articles/'.$article->id) }}">
					<img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}" class="thumbnail">
					<div class="desc-box">
						@if ($article->user->image == '')
							<img src="{{ url('images/profile.png') }}" alt="" class="profile">
						@else
							<img src="{{ url('uploads/'.$article->user->image) }}" alt="" class="profile">
						@endif
						<span class="title">{{ $article->title }}</span>
						<span class="writer">by. {{ $article->writer_key }}</span>
					</div>
				</a>
			</li>
		@endforeach
	</ul>
</div>
@endsection