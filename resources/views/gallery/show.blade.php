@extends('layouts/gallery')
@section('title')
	:: {{ $article->title }}
@endsection

@section('article_title')
{{ $article->title }}
@endsection

@section('article_content')
{!! trim(strip_tags(str_replace('src="upload/', 'src="/editor/upload/', $article->body))) !!}
@endsection


@section('content')
<div class="wrap-show cf">
	@foreach($errors->all() as $error)
		{{ $error }}
	@endforeach

	<div class="box-show">
		<div class="box-header">
			<h2>{{ $article->title }}</h2>
			<span class="info">
				@if ($article->category == 0)
					카테고리A
				@elseif ($article->category == 1)
					카테고리B
				@elseif ($article->category == 2)
					카테고리C
				@elseif ($article->category == 3)
					카테고리D
				@endif
				/
				{{ $article->created_at }}
				<br>
				조회수 : {!! count(explode(',',$article->hit))-1 !!}
			</span>
		</div>
		<div class="content">
			{!! str_replace('src="upload/', 'src="/editor/upload/', $article->body) !!}
		</div>
		<div class="box-act">
			<div class="box-tag">
				@foreach(explode(',', $article->tag) as $tag)
				<a href="#">#{{ $tag }}</a>
				@endforeach
			</div>
			<div class="box-left">
				<div class="box-like">
					@if (auth()->guest())
						<a class="btn-like" href="#" data-name=""> 
							<i class="fa fa-heart-o" aria-hidden="true"></i> 
							<i class="fa fa-heart" aria-hidden="true"></i>
						</a>
						<span class="like-count">{{ count(explode(',',$article->like))-1 }}</span>
						<span class="like-txt"> 좋아요를 누르시면 작가님께 큰 힘이 됩니다.</span>	
					@else
						@if (!in_array(auth()->user()->name, explode(',',$article->like)))
							<a class="btn-like" href="#" data-name="{{ auth()->user()->name }}" data-csrf-token="{{ csrf_token() }}"> 
								<i class="fa fa-heart-o" aria-hidden="true"></i> 
								<i class="fa fa-heart" aria-hidden="true"></i>
							</a>
							<span class="like-count">{{ count(explode(',',$article->like))-1 }}</span>
							<span class="like-txt"> 좋아요를 누르시면 작가님께 큰 힘이 됩니다.</span>	
						@else
							<span class="already-like"> <i class="fa fa-heart" aria-hidden="true"></i> </span>
							<span class="like-count">{{ count(explode(',',$article->like))-1 }}</span>
							<span class="liked-txt">이미 좋아요를 누르셨습니다.</span>	
						@endif
					@endif
					
				</div>	
				<script>
					// 좋아요 클릭
					$(document).on("click", '.btn-like', function(){
						if (!$(this).hasClass('btn-like-clicked')) {
							var url = "{{ url('/articles/'.$article->id.'/like') }}";
							var csrfToken = $(this).data('csrfToken');
							var name = $(this).data('name');

							if (name != '') {
								$.ajax({
									type:'post',
									url: url,
									data:{
										_token: csrfToken,
										name: name,
									}
								}).done(function (data){
									$('.btn-like').addClass('btn-like-clicked');
									$('.like-count').text(data);
									$('.like-txt').addClass('liked-txt').text('좋아요를 누르셨습니다.');
								});
							} else {
								alert('로그인 후 이용가능합니다.');
							}

						}						
						return false;
					});
				</script>
			</div>
			<div class="box-menu-right">
				@if ($article->creative == 1)
					<div class="box-copyright">
						Copyright © <span class="writer">{{ $article->writer_key }}</span> All Rights Reserved.
					</div>
				@else
					<div class="box-ccl">
						<img src="{{ url('/images/ccl1on.png') }}" alt="">
						<img src="{{ url('/images/ccl2on.png') }}" alt="">
						@if ($article->profit == 1)
							<img src="{{ url('/images/ccl3on.png') }}" alt="">
						@endif

						@if ($article->share == 2)
							<img src="{{ url('/images/ccl4on.png') }}" alt="">
						@elseif ($article->share == 1)
							<img src="{{ url('/images/ccl5on.png') }}" alt="">
						@endif
					</div>
				@endif
				<div class="box-share">
					<a class="btn-share btn-fb" href="#" onclick="window.open('http://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}', '_blank', 'width=550 height=400')"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a class="btn-share btn-fb" href="#" onclick="window.open('https://twitter.com/intent/tweet?text=TEXT&url={{ URL::current() }}', '_blank', 'width=550 height=400')"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				</div>
				@if(auth()->guest())
				@elseif ($article->writer_key == auth()->user()->name)
					<a class="btn-list" href="{{ url('/articles/'.$article->id.'/edit') }}">수정</a>
					<a class="btn-list btn-delete" href="#" data-id="{{ $article->id }}" data-url="{{ url('/articles/'.$article->id) }}" data-csrf-token="{{ csrf_token() }}">삭제</a>
				@else
					<a class="btn-list" href="{{ url('/articles') }}">신고</a>
				@endif
				<a class="btn-list" href="{{ url('/articles') }}">목록</a>
			</div>
		</div>

		<script>
		$(document).on("click", ".btn-delete", function(){
			if (confirm("삭제하신 게시글은 복구가 불가능합니다.\n정말 삭제하시겠습니까?")) {

				var url = $(this).data('url');
				var csrfToken = $(this).data('csrfToken');

				$.ajax({
					type: 'delete',
					url: url,
					data: {
						_token: csrfToken,
						xhr: 'true'
					}
				}).done(function (data){
					$('.box-show').stop().animate({'height':288},300,function(){
						$('.box-delete-complete').fadeIn(300);
					});
					$('.box-show div').fadeOut(300);
				});
			}
			return false;
		});
		</script>
		
		<div class="box-delete-complete">
			<img src="{{ url('/images/smile.png') }}" alt="">
			<p>게시글이 정상적으로 삭제 되었습니다.</p>
			<a class="btn-list" href="{{ url('/') }}">게시글 목록보기</a>
		</div>

		<div class="box-comment">
			<h3>댓글을 남겨주세요.</h3>
			<div class="box-write">
				<form id="form-comment" action="{{ url('/articles/'.$article->id.'/comments') }}" method="post">
					<table>
						<tbody>
							<tr>
								<td>
									<div class="box-profile">
										@if(auth()->guest())
											<img src="{{ url('/images/profile2.png') }}" alt="">
										@elseif(auth()->user()->image == '')
											<img src="{{ url('/images/profile2.png') }}" alt="">
										@else 
											<img src="{{ url('/uploads/'.auth()->user()->image) }}" alt="">
										@endif
									</div>
								</td>
								<td>
									<textarea data-csrf-token="{{ csrf_token() }}" name="content" id="multi-users" cols="30" rows="10" placeholder="댓글을 남겨주세요. 타인을 향한 욕설이나 비방의 글은 제재를 당할 수 있습니다."></textarea>	
									<span class="desc">'@'를 입력하면 멘션할 수 있습니다.</span>
								</td>
								<td>
									@if(auth()->guest())
										<a class="btn-submit disabled" href="#">댓글 쓰기</a>
									@else
										<a class="btn-submit" data-name="{{ auth()->user()->name }}" href="#">댓글 쓰기</a>
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				<script>
				$("#multi-users").mention({
				    delimiter: '@',
				    users: [
				    @foreach($users as $user)
					    {username: "{{ $user->name }}"},
					@endforeach
				    ]
				});

				$('.btn-submit').click(function(){
					if (!$(this).hasClass('disabled')) {
						if ($('textarea[name=content]').val().length > 0) {
						
							$('textarea[name=content]').removeClass('error');
							var name = $(this).data('name');

							$.ajax({
								type:'post',
								url: "{{ url('/articles/'.$article->id.'/comments') }}",
								data:{
									name: name,
									_token: $('textarea[name=content]').data('csrfToken'),
									content: $('textarea[name=content]').val(),
								}
							}).done(function (data){
								$('textarea[name=content]').val('');

								var comment = $(".li-new-data").clone();

								comment.find('.writer').text(data['name']);
								comment.find('.reg-date').text(data['created_at']);

								userList = [
								@foreach($users as $user)
								    "{{ $user->name }}",
								@endforeach
								];

								for (var i = 0; i < userList.length; i++) {
									data['content'] = data['content'].replace('@'+userList[i], '<a class="mention" href="#">'+userList[i]+'</a>');
								}
								comment.find('.comment-content').html(data['content']);
								comment.appendTo('.box-data ul').fadeIn(500).removeClass('li-new-data').addClass('added-data');
								
								dataFind = $('.added-data').offset().top-500;
								$('body').animate({scrollTop:dataFind}, 500, function(){
									$('.added-data').removeClass('added-data');
								});
							});
							
						} else {
							alert('댓글 내용을 입력해주세요.');
							$('textarea[name=content]').addClass('error');
						}
					} else {
						alert('회원만 댓글을 작성할 수 있습니다.');
					}
					return false;
				});
				</script>
			</div>
			<div class="box-data">
				<ul>
					<li class="li-data li-new-data">
						<div class="box-writer">
							<span class="writer"></span>
							<span class="reg-date"></span>
						</div>
						<div class="comment-content">
							<!-- <a href="#" class="mention">@와우와우</a> 이것은 댓글의 내용입니다. -->
						</div>
						<div class="box-report">
							<a class="btn-delete-comment" href="#">삭제</a>
						</div>
						<a class="profile" href="#">
							@if(auth()->guest())
								<img src="{{ url('/images/logo.png') }}" alt="">
							@elseif(auth()->user()->image == '')
								<img src="{{ url('/images/profile2.png') }}" alt="">
							@else 
								<img src="{{ url('/uploads/'.auth()->user()->image) }}" alt="">
							@endif
						</a>
					</li>
					@foreach($article->comments as $comment)					
						<li class="li-data">
							<div class="box-writer">
								<span class="writer">{{ $comment->name }}</span>
								<span class="reg-date">{{ $comment->created_at }}</span>
							</div>
							<div class="comment-content">
								{!! nl2br(e($comment->content)) !!}
							</div>
							@if(true)
								<div class="box-report">
									@if(!auth()->guest())
										@if($comment->name != auth()->user()->name)
											<a class="btn-reply" href="#">답글 달기</a>
											<a href="#">신고</a>
										@else
											<a class="btn-delete-comment" href="#" data-url="{{ url('/articles/'.$article->id.'/comments/'.$comment->id) }}" data-csrf-token="{{ csrf_token() }}">삭제</a>
											<script>
												$(document).on("click", ".btn-reply", function() {
													var name = $(this).closest('li').find('.writer').text();

													$('textarea[name=content]').val('@'+name+' ').focus();
												});
												$(document).on("click", ".btn-delete-comment", function() {
													$(this).addClass('delete');

													var url = $(this).data('url');
													var csrfToken = $(this).data('csrfToken');

													$.ajax({
														type: 'delete',
														url: url,
														data: {
															_token: csrfToken,
															xhr: 'true'
														}
													}).done(function (data){
														if (data == 'success') {
															$('.box-comment .delete').closest('.li-data').fadeOut(500, function(){
																$(this).remove();
															});	
														}
													}).error(function() {

													});
													return false;
												});
											</script>
										@endif
									@endif
								</div>
							@endif
							<a class="profile" href="#">
								@if ($comment->user->image == '')
									<img src="{{ url('/images/profile2.png') }}" alt="">
								@else 
									<img src="{{ url('/uploads/'.$comment->user->image) }}" alt="">
								@endif
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	<div class="box-remote">
		<h3>작가의 프로필</h3>
		<div class="box-profile cf">
			<div class="image">
				@if($article->user->image == '')
					<img src="{{ url('/images/profile2.png') }}" alt="">
				@else 
					<img src="{{ url('/uploads/'.$article->user->image) }}" alt="">
				@endif
			</div>
			<span class="job">Artist</span>
			<span class="id">{{ $article->writer_key }}</span>
			<p class="introduce">
				자기소개서.자기소개서.자기소개서.자기소개서.자기소개서.자기소개서. 자기소개서.자기소개서.자기소개서. 자기소개서.자기소개서. 자기소개서.자기소개서.
			</p>
		</div>
	</div>
	<div class="box-relate-article">
		<h2>위와 관련된 작품들입니다.</h2>
		<ul class="main-article">
			@foreach($related_articles->all() as $article)
				<li>
					<a href="{{ url('/articles/'.$article->id) }}" data-name="유저네임">
						<img src="{{ url('/uploads/'.$article->image) }}" alt="{{ $article->title }}" class="thumbnail">
						<div class="desc-box">
							@if($article->user->image == '')
								<img class="profile" src="{{ url('/images/profile.png') }}" alt="">
							@else 
								<img class="profile" src="{{ url('/uploads/'.$article->user->image) }}" alt="">
							@endif
							<span class="title">{{ $article->title }}</span>
							<span class="writer">by. {{ $article->writer_key }}</span>
						</div>
					</a>
				</li>
			@endforeach
		</ul>
	</div>
	<script>
	$(function(){
		// 관련작품 현재 보고 있는 동일 글 리스트중에서 삭제
		$('.box-relate-article a[href="{{ URL::current() }}"]').closest('li').remove();
	})
	</script>
</div>
@endsection