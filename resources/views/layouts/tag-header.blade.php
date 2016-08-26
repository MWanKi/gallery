<div class="wrap-header cf">
	<div class="box-header">
		<h1 class="logo"><a href="{{ url('/articles') }}"><img src="{{ url('images/logo(84.24px)_bk.png') }}" alt=""></a></h1>
		<ul class="ul-nav cf">
			<li class="li-nav">
				<a href="{{ url('/subscription') }}">구독함</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li>

			<li class="li-nav">
				<a href="{{ url('/works') }}">갤러리</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li>

			<li class="li-nav">
				<a href="{{ url('/artist') }}">아티스트</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li>
			<!-- <li class="li-nav">
				<a href="{{ url('/category') }}">카테고리C</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li>
			<li class="li-nav">
				<a href="{{ url('/category') }}">카테고리D</a>
				<ul class="ul-child">
					<li class="li-child"> <a href="">조건1</a> </li>
					<li class="li-child"> <a href="">조건2</a> </li>
					<li class="li-child"> <a href="">조건3</a> </li>
				</ul>
			</li> -->
		</ul>
		<ul class="ul-user">
			@if(auth()->guest())				
				<li class="li-nav">
					<a class="link-login" href="{{ url('/auth/login') }}">로그인</a>
				</li>
				<li class="li-nav">
					<a class="btn-upload disabled" href="{{ url('auth/login') }}">업로드</a>
				</li>
			@else
				<li class="li-nav li-my">
					<a href="{{ url('/mypage/'.auth()->user()->id.'?category=works') }}">
						<div class="box-mini-profile">
							@if (auth()->user()->image == '')
								<img src="{{ url('/images/profile2.png') }}" alt="">
							@else
								<img src="{{ url('/uploads/'.auth()->user()->image) }}" alt="">
							@endif	
						</div>
					</a>
					<ul class="ul-mypage">
						<li><a href="{{ url('/mypage/'.auth()->user()->id.'/edit') }}">개인정보 수정</a></li>
						<li><a href="{{ url('/auth/logout') }}">로그아웃</a>	</li>
					</ul>
				</li>
				<li class="li-nav">
					<a class="btn-upload" href="{{ url('articles/create') }}">업로드</a>
				</li>
			@endif
		</ul>
	</div>
</div>