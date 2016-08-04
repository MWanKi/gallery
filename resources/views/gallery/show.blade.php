@extends('layouts/gallery')
@section('title')
	:: {{ $article->title }}
@endsection
@section('content')
<div class="wrap-show cf">
	<div class="box-show">
		<div class="box-header">
			<h2>{{ $article->title }}</h2>
			<span class="info">
				카테고리A / {{ $article->created_at }}<br>
				좋아요 : 123 / 조회수 : 1231
			</span>
		</div>
		<div class="box-category">
			 by. 후후후
		</div>
		<div class="content">
			{!! str_replace('src="upload/', 'src="/editor/upload/', $article->body) !!}
		</div>
		<div class="box-act">
			<div class="box-share">
				<a class="btn-share" href="#">공유하기</a>
			</div>
			<a class="btn-list" href="{{ url('/') }}">목록</a>
		</div>
		<div class="box-comment">
			<h3>댓글을 남겨주세요.</h3>
			<div class="box-write">
				<table>
					<tbody>
						<tr>
							<td><textarea name="" id="" cols="30" rows="10"></textarea></td>
							<td><a href="">댓글등록</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="box-remote">
		<h3>작가의 프로필</h3>
		<div class="box-profile cf">
			<div class="image">
				<img src="{{ url('/images/logo.png') }}" alt="">
			</div>
			<span class="job">Artist</span>
			<span class="id">후후후</span>
			<p class="introduce">
				자기소개서.자기소개서.자기소개서.자기소개서.자기소개서.자기소개서. 자기소개서.자기소개서.자기소개서. 자기소개서.자기소개서. 자기소개서.자기소개서.
			</p>
		</div>
	</div>
</div>
@endsection