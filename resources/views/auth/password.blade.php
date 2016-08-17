@extends('layouts.gallery')

@section('content')
<div class="wrap-register wrap-find-password">
	<h2>
		비밀번호 찾기
		<span class="welcome">
			사용하시는 비밀번호를 잊어버리셨나요?<br>
			가입하신 이메일로 비밀번호 초기화 링크가 발송됩니다.
		</span>
	</h2>
	<div class="box-layout">
		<div class="panel-body">
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
				{!! csrf_field() !!}
				<div class="box-response">
					<p class="success">
						작성하신 이메일로 메일이 발송되었습니다.<br>
						이메일을 확인해주시기 바랍니다.
					</p>
					<p class="failed">
						메일 발송에 실패하였습니다.<br>
						가입하신 이메일을 정확하게 작성해주세요.
					</p>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">이메일 주소</label>
					<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="가입하신 이메일 주소를 입력해주세요.">
				</div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<a href="#" id="reset-password-submit" class="btn btn-primary" data-url="{{ url('/password/email') }}" data-csrf-token="{{ csrf_token() }}">
							비밀번호 초기화 링크 보내기
						</a>
					</div>
					<script>
					$(document).on("click", "#reset-password-submit", function(){
						var url = $(this).data('url');
						var csrfToken = $(this).data('csrfToken');
						var email = $('input[name=email]').val();
						var rule = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

						if (!rule.test(email)) {
							$('.wrap-find-password .box-layout').animate({'padding-top':88},300,function(){
								$('.box-response .success').fadeOut(300);
								$('.box-response .failed').fadeIn(300);
							});
						} else {
							$('.wrap-find-password .loading-icon').fadeIn(300);
							$('.form-group').animate({'opacity':0},300);
							$('.box-response p').fadeOut(300);

							$.ajax({
								type: 'post',
								url: url,
								data: {
									email: email,
									_token: csrfToken,
									xhr: 'true'
								}
							}).done(function (response){
								if (response == 'passwords.sent') {
									// success
									$('.wrap-find-password .loading-icon').fadeOut(300);
									$('.form-group').animate({'opacity':1},300);
									$('.wrap-find-password .box-layout').animate({'padding-top':88},300,function(){
										$('.box-response .success').fadeIn(300);
										$('.box-response .failed').fadeOut(300);	
									});
								} else {
									// failed
									$('.wrap-find-password .loading-icon').fadeOut(300);
									$('.form-group').animate({'opacity':1},300);
									$('.wrap-find-password .box-layout').animate({'padding-top':88},300,function(){
										$('.box-response .success').fadeOut(300);
										$('.box-response .failed').fadeIn(300);
									});
								}
							});
						}
						return false;
					});
					</script>
				</div>
			</form>
			<img class="loading-icon" src="{{ url('/images/spinner.gif') }}" alt="">
		</div>
	</div>
</div>
<!-- <div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						{!! csrf_field() !!}

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Send Password Reset Link
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> -->
@endsection
