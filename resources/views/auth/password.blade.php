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

				<div class="form-group">
					<label class="col-md-4 control-label">이메일 주소</label>
					<input type="email" class="form-control" name="email" value="{{ old('email') }}">
				</div>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary">
							비밀번호 초기화 링크 보내기
						</button>
					</div>
				</div>
			</form>
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
