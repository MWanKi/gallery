@extends('layouts/gallery')
@section('title')
@endsection
@section('content')
<div class="wrap-index">
	<h2>C.GALLERY의 카테고리 게시물입니다.</h2>
	<ul class="main-article">
		@foreach($articles->all() as $article)
			<li>
				<a href="{{ url('/articles/'.$article->id) }}">
					<img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}" class="thumbnail">
					<div class="desc-box">
						@if (true)
							<img src="{{ url('images/profile.png') }}" alt="" class="profile">
						@else

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