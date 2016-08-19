@extends('layouts/gallery')

@section('title')
:: 회원가입
@endsection

@section('content')

@if (count($errors) > 0)
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<style>
	.jcrop-holder div {
  -webkit-border-radius: 50% !important;
  -moz-border-radius: 50% !important;
  border-radius: 50% !important;
  margin: -1px;
}
</style>
<span class="blackcover"></span>

	<script language="Javascript">
	    $(function() {

    		// Create variables (in this scope) to hold the API and image size
		    var jcrop_api,
		        boundx,
		        boundy,

		        // Grab some information about the preview pane
		        $preview = $('#preview-pane'),
		        $pcnt = $('#preview-pane .preview-container'),
		        $pimg = $('#preview-pane .preview-container img'),

		        xsize = $pcnt.width(),
		        ysize = $pcnt.height();

	    	function showCoords(c) {
		        // variables can be accessed here as
		        // c.x, c.y, c.x2, c.y2, c.w, c.h

		        var rx = xsize / c.w,
		        	ry = ysize / c.h;
		        
		        if (parseInt(c.w) > 0) {
			        //var rx = xsize / c.w * c.w;
			        //var ry = ysize / c.h * c.h;

			        $pimg.css({
			            width: Math.round(rx * boundx) + 'px',
			            height: Math.round(ry * boundy) + 'px',
			            marginLeft: '-' + Math.round(rx * c.x) + 'px',
			            marginTop: '-' + Math.round(ry * c.y) + 'px'
			        });
			    }

		    	$('input[name=image_w]').val(c.w);
		        $('input[name=image_h]').val(c.h);
		        $('input[name=image_x]').val(c.x);
		        $('input[name=image_y]').val(c.y);
		    
			}

			$(document).on('change', '#image-upload', function() {
				
				// Todo destroy Jcrop
				// ...

			    if(window.FileReader) {
			        var reader = new FileReader();
			        reader.onload = function(e) {

			        	if ($("#image-upload").val() != '') {

			        		$pimg.attr('src',reader.result);
				            real_width = $pimg[0].naturalWidth;
				            real_height = $pimg[0].naturalHeight;	
			        	
				            if (real_width > 1200) {
				            	alert("가로 사이즈가 1200픽셀보다 작은 이미지를 업로드해주세요.");
				            } else {
				            	if (real_width < 100) {
				            		if (real_height < 100) {
				            			alert("가로, 세로 사이즈가 100픽셀보다 큰 이미지를 업로드해주세요.");	
				            		}
				            	} else {
				            		if (real_height < 100) {
				            			alert("가로, 세로 사이즈가 100픽셀보다 큰 이미지를 업로드해주세요.");	
				            		} else {
				            			$('.box-modal-crop').fadeIn();
							        	$('.blackcover').fadeIn();
							        	$('.box-image').children().remove();
										$('.box-image').append("<img id='target'>").show();

						            	$('#target').attr('src',reader.result);
						            	$pimg.attr('src',reader.result);
						            	$('#target').css({'width':'auto','height':'auto'});
								        $('#target').Jcrop({
								        	onChange:    showCoords,
								        	onSelect:    showCoords,
								            bgColor:     'black',
								            bgOpacity:   .4,
								            setSelect:   [ 100, 100, 50, 50 ],
								            aspectRatio: 1 / 1,
								            minSize: [100, 100],
								        }, function(){
										    // Use the API to get the real image size
										    var bounds = this.getBounds();
										    boundx = bounds[0];
										    boundy = bounds[1];

										    // Store the API in the jcrop_api variable
										    _jcrop_api = this;

										    // Move the preview into the jcrop container for css positioning
										    $preview.appendTo(_jcrop_api.ui.holder);
									    });

								        modal = $('.box-modal-crop');
									    modalWidth = modal.width();
									    modal.css({'margin-left':-modalWidth/2});
				            		}
				            	}
				            }
				        }
				    }
			        reader.readAsDataURL(this.files[0]);  
			    }
			});

	        
		
	    });
	</script>

	<!-- 이미지 크롭 -->
		<div class="box-modal-crop">
			<h4>미리보기 이미지 설정</h4>
			<div class="box-image">
				<img src="" alt="" id="target">
			</div>
			<a href="" class="confirm">이미지 확인</a>
		</div>
		<div id="preview-pane" class="register blind">
			<div class="preview-container">
				<img src="{{ url('uploads/foo.jpg') }}" alt="" class="preview-target">
			</div>
		</div>
	<!-- 이미지 크롭 -->


<div class="wrap-register">
	<h2>
		회원 가입
		<span class="welcome">
			예술향유 문화공간에 오신것을 환영합니다.<br>
			간단한 정보 제공으로 회원가입 하실 수 있습니다.
		</span>
	</h2>
	<form class="regist-form" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="box-left box-layout">
			<h3>개인정보취급방침</h3>
			<div class="cover">
				<textarea name="" id="" cols="30" rows="10" readonly>@include('auth.private')</textarea>
			</div>
			<h3>이용약관</h3>
			<div class="cover">
				<textarea name="" id="" cols="30" rows="10" readonly>@include('auth.use')</textarea>
			</div>
		</div>
		<div class="box-right box-layout">
			<div class="box-register">
				<h3>정보 입력</h3>	
				<!-- 이미지 사이즈 -->
				<input type="hidden" name="image_w" value="">
				<input type="hidden" name="image_h" value="">
				<input type="hidden" name="image_x" value="">
				<input type="hidden" name="image_y" value="">
				<!-- 이미지 사이즈 -->
				<div class="box-profile">
					<div class="box-left">
						<div class="box-thumbnail" id="image-preview">
				        	<a class="btn-thumbnail" href="#">
								<div class="desc-box">
									<img src="{{ url('images/profile2.png') }}" alt="" class="profile">
								</div>
							</a>
						    <input class="blind" type="file" name="image" id="image-upload" accept="image/*"/>
							<script type="text/javascript">
								$(function(){

									// 이미지 썸네일 미리보기
									$('.confirm').click(function(){
										$(".box-thumbnail #preview-pane").remove();
										$("#preview-pane").clone().prependTo(".box-thumbnail");
										$(".box-thumbnail #preview-pane").removeClass("blind");
										$('.box-modal-crop').fadeOut();
										$('.profile').hide();
										$('.blackcover').fadeOut();
										return false;
									});
									
								});

								// 제목 미리보기
								$(document).on("keyup", '#upload-title', function() {
									$('.box-thumbnail .title').text($(this).val());
								});

								// 썸네일 첨부 클릭
								$(document).on("click", ".btn-thumbnail, #preview-pane", function(){
									$("#image-upload").click();
									return false;
								});
							</script>
				        </div>
				        <p class="desc">* <span class="required">100 x 100</span> 픽셀 크기의 이미지를 권장합니다.</p>	
				    </div>
			        <div class="box-input">
			        	<div class="box-nickname">
			        		<p class="desc">* 한번 정한 별명은 변경할 수 없습니다. <span class="point">(필수)</span></p>
							<label class="">별명</label>
							<input type="text" class="user-name require-info" name="name" value="{{ old('name') }}" placeholder="별명을 입력해주세요." data-csrf-token="{{ csrf_token() }}" data-url="{{ url('/articles/usercheck') }}" maxlength="10">
							<p class="condition error">
								별명을 입력해주세요.
							</p>
							<script>
								$(function(){
									var infoLength = $('.wrap-register .require-info').length;

									// 빈값 에러
									$('.require-info').bind("keyup blur", function(){

										if ($(this).hasClass('user-name')) {
											var userName = $(this).val();
											var csrfToken = $(this).data("csrfToken");
											var url = $(this).data("url");
											var rule = /[ \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi; //특수문자 

											if (rule.test(userName)) {
												userName = userName.replace(rule, "");
												$(this).val(userName);
											} else {
												if (userName == '') {
													$('.condition').text("별명을 입력해주세요.").addClass('error');
												} else {
													$.ajax({
														type : 'post',
														url : url,
														data : {
															name: userName,
															_token: csrfToken,
															xhr: 'true'
														}
													}).done(function (data){
														if (data == 'already') {
															$('.condition').text("이미 사용중인 별명입니다.").addClass('error');
															$('.wrap-register .btn-regist').addClass('disabled');
														} else if (data == 'none') {
															$('.condition').text("사용 가능한 별명입니다.").removeClass('error');
															$('input[name=name]').removeClass('errorfocus');

															if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
																$('.wrap-register .btn-regist').removeClass('disabled');
															} else {
																$('.wrap-register .btn-regist').addClass('disabled');
															} 
														}
													});	
												}
											}
										} 

										if ($(this).hasClass('user-email')) {
											var userEmail = $(this).val();
											var csrfToken = $(this).data("csrfToken");
											var url = $(this).data("url");
											var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

											if (userEmail == '') {
												$('.box-email .desc').text("이메일을 입력해주세요.").addClass('error');
											} else {
												$.ajax({
													type : 'post',
													url : url,
													data : {
														email: userEmail,
														_token: csrfToken,
														xhr: 'true'
													}
												}).done(function (data){
													if (data == 'already') {
														$('.box-email .desc').text("이미 사용중인 이메일입니다.").addClass('error');
														$('.wrap-register .btn-regist').addClass('disabled');
													} else if (data == 'none') {
														if (!regExp.test(userEmail)) {
															$('.box-email .desc').text("이메일 형식이 올바르지 않습니다.").addClass('error');
														} else {
															$('.box-email .desc').text("사용 가능한 이메일입니다.").removeClass('error');
															$('input[name=email]').removeClass('errorfocus');	
														}
														
														if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
															$('.wrap-register .btn-regist').removeClass('disabled');
														} else {
															$('.wrap-register .btn-regist').addClass('disabled');
														} 
													}
												});	
											}
										}

										if ($(this).hasClass('onlynum')) {
											var value = $(this).val();
											var rule = /[^0-9]/;
											
											if (value.length >= 3) {
												$(this).removeClass('error errorfocus');
											}

											if (rule.test(value)) {
												value = value.replace(rule, "");
												$(this).val(value);
											}
										}

										for (var i = 0; i < infoLength; i++) {

											if ($('.require-info').eq(i).val() == '') { // 빈값이면 에러 넣기
												$('.require-info').eq(i).addClass('error');
											} else { 
												$('.require-info').eq(i).removeClass('error');	// 값이 있으면 에러 제거
											}
										}

										if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
											$('.wrap-register .btn-regist').removeClass('disabled');
										} else {
											$('.wrap-register .btn-regist').addClass('disabled');
										} 
									});

								});

								$(document).on("click", ".wrap-register .box-right .box-agree label", function(){
									$(this).toggleClass('i-agree');

									if ($('.wrap-register .error').length == 0 && $('.i-agree').length == 2) {
										$('.wrap-register .btn-regist').removeClass('disabled');
									} else {
										$('.wrap-register .btn-regist').addClass('disabled');
									}
								});

							</script>
						</div>
						<div>
							<label for="">자기소개</label>
							<textarea name="introduction" id="" cols="30" rows="5" placeholder="자기소개를 입력해주세요."></textarea>
						</div>
			        </div>	
				</div>
				<p class="recommend">* 아래의 정보를 <span class="required">빠짐없이</span> 입력해주세요.</p>	
				<div class="box-required cf">
					<div class="box-input">
						<div class="box-phone">
							<label class="">휴대폰 번호</label>
							<div class="box-num box-info">
								<input class="require-info onlynum" type="text" name="p_num1" maxlength="3">
								<input class="require-info onlynum" type="text" name="p_num2" maxlength="4">
								<input class="require-info onlynum" type="text" name="p_num3" maxlength="4">
							</div>
						</div>

						<div class="box-info box-email">
							<label class="">이메일</label>
							<input type="email" class="require-info user-email" name="email" value="{{ old('email') }}" placeholder="이메일을 입력해주세요." data-csrf-token="{{ csrf_token() }}" data-url="{{ url('/articles/emailcheck') }}">
							<p class="desc">비밀번호 찾기시에 사용됩니다.</p>
						</div>

						<div class="box-info box-password">
							<label class="">비밀번호</label>
							<input type="password" class="require-info" name="password" placeholder="비밀번호를 입력해주세요.">
							<p class="desc">최소 6자 이상의 영문, 숫자 조합</p>
						</div>

						<div class="box-info">
							<label class="">비밀번호 확인</label>
							<input type="password" class="require-info password-check" name="password_confirmation" placeholder="비밀번호를 확인해주세요.">
						</div>		
					</div>		
				</div>
				<div class="box-agree">
					<div>
						<input class="blind" type="checkbox" name="agree1" id="agree1">
						<label for="agree1">개인정보취급방침에대한 내용을 충분히 읽고 이해하였으며 이에 동의합니다.</label>
					</div>
					<div>
						<input class="blind" type="checkbox" name="agree2" id="agree2">
						<label for="agree2">이용약관에대한 내용을 충분히 읽고 이해하였으며 이에 동의합니다.</label>
					</div>
				</div>
			</div>	
			<img src="{{ url('/images/spinner.gif') }}" alt="" class="loading-icon">
		</div>
		<a href="#" class="btn-regist disabled" type="submit" class="">
			회원가입
		</a>
		<script>
		$(document).on("click", ".wrap-register .btn-regist", function(){
			setTimeout(function() {
				if (!$(this).hasClass('disabled')) {

				// validation
				if ($('input[name=p_num1]').val().length < 3) {
					$('input[name=p_num1]').addClass('errorfocus');
					}

					if ($('input[name=p_num2]').val().length < 3) {
						$('input[name=p_num2]').addClass('errorfocus');
					}

					if ($('input[name=p_num3]').val().length < 4) {
						$('input[name=p_num3]').addClass('errorfocus');
					}

					var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

					if ($('input[name=email]').val() == '' || !regExp.test($('input[name=email]').val())) {
						$('input[name=email]').addClass('errorfocus');
					}

					if ($('input[name=password_confirmation]').val() != $('input[name=password]').val()) {
						$('input[name=password_confirmation]').addClass('errorfocus');
					}

					if ($('.wrap-register .condition').hasClass('error')) {
						$('input[name=name]').addClass('errorfocus');					
					}

					// 에러가 없다면 submit
					if ($('.errorfocus').length == 0) {
						$('.wrap-register .box-right div').fadeOut(300);
						$('.wrap-register .box-right .loading-icon').fadeIn(300);
						$('.regist-form').submit();
					} else {
						return false;
					}
				} else {
					return false;
				}
			}, 300);
			
		});
		</script>
	</form>
</div>
@endsection

