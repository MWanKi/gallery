@extends('layouts/gallery')

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
								            minSize: [290, 290],
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
		<div id="preview-pane" class="blind">
			<div class="preview-container">
				<img src="{{ url('uploads/foo.jpg') }}" alt="" class="preview-target">
			</div>
		</div>
	<!-- 이미지 크롭 -->


<div class="wrap-register">
	<div class="box-register">
		<h2>회원가입</h2>

		<form class="" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data">
			{!! csrf_field() !!}
			<!-- 이미지 사이즈 -->
			<input type="hidden" name="image_w" value="">
			<input type="hidden" name="image_h" value="">
			<input type="hidden" name="image_x" value="">
			<input type="hidden" name="image_y" value="">
			<!-- 이미지 사이즈 -->
			<div class="box-thumbnail" id="image-preview">
	        	<a class="btn-thumbnail" href="#">
					<div class="desc-box">
						<img src="{{ url('images/logo.png') }}" alt="" class="profile" style="width:200px;">
						<span class="title">&nbsp;</span>
						<span class="writer"></span>
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
							$('.blackcover').fadeOut();
							return false;
						});
						
					});

					// 제목 미리보기
					$(document).on("keyup", '#upload-title', function() {
						$('.box-thumbnail .title').text($(this).val());
					});

					// 썸네일 첨부 클릭
					$(document).on("click", ".btn-thumbnail", function(){
						$("#image-upload").click();
						return false;
					});

					$(document).on("change", "#image-upload", function(){
						console.log('sadf');
						return false;
					});
				</script>
				<p class="desc">* <span class="point">580 x 580</span> 픽셀 크기의 이미지를 권장합니다.<span class="required">(필수)</span></p>
	        </div>

			<div class="">
				<label class="">닉네임</label>
				<input type="text" class="" name="name" value="{{ old('name') }}">
			</div>

			<div class="">
				<label class="">이메일</label>
				<input type="email" class="" name="email" value="{{ old('email') }}">
			</div>

			<div class="">
				<label class="">비밀번호</label>
				<input type="password" class="" name="password">
			</div>

			<div class="">
				<label class="">비밀번호 확인</label>
				<input type="password" class="" name="password_confirmation">
			</div>

			<button type="submit" class="">
				Register
			</button>

		</form>
	</div>	
</div>
@endsection

