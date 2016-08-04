@extends('layouts/gallery')
@section('title')
	:: 업로드
@endsection
@section('content')

@if (count($errors) > 0)
<div class="box-upload-error">
	<h3>업로드에 실패했습니다.</h3>
    <ul class="upload-error">
        @foreach($errors->all() as $error)
            <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>
    <script>
    	$(function(){
    		for (var i = 0; i < $('.upload-error li').length; i++) {
	    		var error = $('.upload-error li').eq(i).text();

	    		if (error == ' The title field is required.') {
	    			errorMessage = '제목을 입력해주세요.';
	    		} else if (error == ' The smarteditor field is required.') {
	    			errorMessage = '내용을 입력해주세요.';
	    		} else if (error == ' The image field is required.') {
	    			errorMessage = '썸네일 이미지를 업로드 해주세요.';
	    		} else {
	    			errorMessage = '카테고리를 선택해주세요.';
	    		}

	    		$('.upload-error li').eq(i).text(errorMessage);
	    	}
    	});
    	
    </script>
@endif

	<div class="box-upload">
		<span class="txt-upload">C.GALLERY UPLOAD</span>
		<form action="{{ url('/') }}" method="POST" id="upload-article" enctype="multipart/form-data">
	        {{ csrf_field() }}
	        <input type="hidden" name="category" value="">
	        <input type="hidden" name="creative" value="0">
	        <input type="hidden" name="profit" value="0">
	        <input type="hidden" name="share" value="0">
	        <input type="hidden" name="open" value="1">

	        <h2>작품의 정보를 입력해주세요.</h2>
	        <div class="box-thumbnail" id="image-preview">
	        	<a class="btn-thumbnail" href="#">
					<div class="desc-box">
						<img src="{{ url('images/logo.png') }}" alt="" class="profile">
						<span class="title">&nbsp;</span>
						<span class="writer">by. </span>
					</div>
				</a>
			    <input class="blind" type="file" name="image" id="image-upload" accept="image/*"/>
				<script type="text/javascript">

					// 제목 미리보기
					$(document).on("keyup", '#upload-title', function() {
						$('.box-thumbnail .title').text($(this).val());
					});

					// 썸네일 첨부 클릭
					$(document).on("click", ".btn-thumbnail", function(){
						$("#image-upload").click();
						return false;
					});

					// 이미지 미리보기
					$(document).ready(function() {
					    $.uploadPreview({
					        input_field: "#image-upload",   // Default: .image-upload
					    	preview_box: "#image-preview",  // Default: .image-preview
					    	label_field: "#image-label",    // Default: .image-label
					    	label_default: "",   // Default: Choose File
					    	label_selected: "",  // Default: Change File
					    	no_label: true                 // Default: false
					    });
					});
				</script>
				<p class="desc">* <span class="point">580 x 580</span> 픽셀 크기의 이미지를 권장합니다.<span class="required">(필수)</span></p>
	        </div>
	        <div class="box-condition">
	        	<div class="box-title">
		        	<span class="title">제목을 입력해주세요. <span class="required">(필수)</span></span>
			        <input type="text" name="title" id="upload-title" placeholder="제목을 입력해주세요.">
		        </div>
		        <div class="box-category">
		        	<span class="title">카테고리를 선택해주세요.<span class="required">(필수)</span></span>
		        	<ul class="cf category-select">
		        		<li class="category-selected">
		        			<p>작품 카테고리를 선택하세요.</p>
		        		</li>
		        		<li class="category-list">
		        			<ul>
		        				<li> <a href="#">카테고리1</a> </li>
		        				<li> <a href="#">카테고리2</a> </li>
		        				<li> <a href="#">카테고리3</a> </li>
		        				<li> <a href="#">카테고리4</a> </li>
		        			</ul>
		        		</li>
		        	</ul>
		        </div>
		        <script>
			        // 업로드 카테고리 선택
			        $(document).on("click", ".category-selected p", function() {
			        	$(this).addClass('open');
			        	$('.category-list').show();
			        });

			        // 업로드 카테고리 선택
			        $(document).on("click", ".category-list a", function() {
			        	var category = $(this).text();
			        	var index = $(this).parent().index();
			        	var tag = $('.box-tag input').val();

			        	$('.category-selected p').text(category).removeClass('open');

			        	if ($('.box-tag input').val() == '') {
			        		$('.box-tag input').val(tag+category);
			        	} else {
			        		$('.box-tag input').val(tag+','+category);
			        	}
			        	
			        	$('input[name=category]').val(index);
			        	$('.category-list').hide();
			        	return false;
			        });
		        </script>
		        <div class="box-category box-tag">
		        	<span class="title">태그를 입력해주세요. <span class="desc">(콤마로 구분)</span></span>
		        	<input type="text" placeholder="아트,회화,만화" name="tag">
		        </div>
		        <div class="box-category box-license box-creative">
		        	<span class="title">크리에이티브 커먼즈 라이선스를 적용하겠습니까?</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="creative_select" id="creative1" value="">
		        			<label for="creative1">네</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="creative_select" id="creative2" value="" checked="checked">
		        			<label for="creative2">아니오</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-profit">
		        	<span class="title">영리 목적 이용을 허락합니까?</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="profit_select" id="profit1" value="" disabled>
		        			<label for="profit1">네</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="profit_select" id="profit2" value="" disabled checked="checked">
		        			<label for="profit2">아니오</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-share">
		        	<span class="title">공유하는 저작물에 변경을 허락합니까?</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="share_select" id="share1" value="" disabled>
		        			<label for="share1">네</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="share_select" id="share2" value="" disabled>
		        			<label for="share2">동일한 조건하에 수정 가능함</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="share_select" id="share3" value=""  disabled checked="checked">
		        			<label for="share3">아니오</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-open">
		        	<span class="title">공개여부를 선택해주세요.</span>
		        	<ul class="cf">
		        		<li>
		        			<input class="blind" type="radio" name="open" id="open1" value="" checked="checked">
		        			<label for="open1">공개</label>
		        		</li>
		        		<li>
		        			<input class="blind" type="radio" name="open" id="open2" value="">
		        			<label for="open2">비공개</label>
		        		</li>
		        	</ul>
		        </div>
		        <div class="box-category box-license box-copyright">
		        	<span class="title">저작권 표시</span>
		        	<p class="copyright">Copyright © <span id="name">big****</span> All Rights Reserved.</p>
		        	<p class="license">
		        		<img class="license1" src="{{ url('/images/ccl1on.png') }}" alt="">
		        		<img class="license2" src="{{ url('/images/ccl2on.png') }}" alt="">
		        		<img class="license3" src="{{ url('/images/ccl3on.png') }}" alt="">
		        		<img class="license4" src="{{ url('/images/ccl4on.png') }}" alt="">
		        		<img class="license5 blind" src="{{ url('/images/ccl5on.png') }}" alt="">
		        	</p>
		        </div>
			</div>

			<script>
				// 업로드 라이선스
				$(document).on("click", ".box-creative label", function(){
					var index = $(this).parent().index();

					if (index == 0) {
						// 활성화
						$('.box-profit input, .box-share input').removeAttr("disabled");

						// 저작권 표시 변경
						$('.box-copyright .copyright').hide();
						$('.box-copyright .license').show();
						
					} else {
						// 비활성화
						$('.box-profit input, .box-share input').attr("disabled", "disabled");
						
						// 저작권 표시 변경
						$('.box-copyright .copyright').show();
						$('.box-copyright .license').hide();
					}

				});

				// 영리 목적 허락
				$(document).on("click", ".box-profit label", function() {
					var index = $(this).parent().index();

					if (index == 0) {
						$('.license3').addClass('blind');
					} else {
						$('.license3').removeClass('blind');
					}

				});

				// 공유 저작물 허락
				$(document).on("click", ".box-share label", function() {
					var index = $(this).parent().index();

					if (index == 0) {
						$('.license4').addClass('blind');
						$('.license5').addClass('blind');
					} else if (index == 1) {
						$('.license4').addClass('blind');
						$('.license5').removeClass('blind');
					} else {
						$('.license4').removeClass('blind');
						$('.license5').addClass('blind');
					}

				});

			</script>

			 <h2>작품의 내용을 입력해주세요. <span class="required">(필수)</span></h2>
			 <br>
			<textarea name="smarteditor" id="smarteditor" cols="30" rows="30"></textarea>
			<input type="hidden" name="content">
			<div class="box-agree">
				<div class="check">
					<input type="checkbox" name="agree-upload" id="agree-upload" class="blind">
					<label for="agree-upload"></label>
				</div>
				<p>
					본인은 본 콘텐츠를 적법하게 게시할 수 있는 권리자임을 확인하며, <a href="">서비스 운영원칙</a>에 동의합니다.<br>
					* 저작권 등 타인의 권리를 침해하거나 명예를 훼손하는 이미지, 동영상, 음원 등을 게시하는 경우 <a href="">이용약관</a> 및 관련 법률에 의하여 제재를 받으실 수 있습니다.	
				</p>
			</div>
			<div class="box-act">
				<a id="savebutton" class="disabled" href="#">발행</a>
			</div>
		</form>
	</div>	
	
	<script type="text/javascript">
	//스마트 에디터
	$(function(){
	    //전역변수선언
	    var editor_object = [];
	     
	    nhn.husky.EZCreator.createInIFrame({
	        oAppRef: editor_object,
	        elPlaceHolder: "smarteditor",
	        sSkinURI: "{{ url('/editor/SmartEditor2Skin.html') }}",	
	        htParams : {
	            // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseToolbar : true,             
	            // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseVerticalResizer : true,     
	            // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
	            bUseModeChanger : true, 
	        }
	    });

	    $(document).on("click", "#agree-upload", function() {
	    	$('#savebutton').toggleClass('disabled');
	    });
	     
	    //전송버튼 클릭이벤트
	    $("#savebutton").click(function(){

	    	if ($(this).hasClass('disabled')) {
	    		return false;
	    	} else {
	    		//id가 smarteditor인 textarea에 에디터에서 대입
		        editor_object.getById["smarteditor"].exec("UPDATE_CONTENTS_FIELD", []);
		         
		        // 이부분에 에디터 validation 검증
		        var error = [];

		        if ($('input[type=file]').val() == '') {
		        	error.push('썸네일 이미지를 업로드해주세요.');
		        	$('.box-upload .box-thumbnail').addClass('error');
		        }

		        if ($('input[name=title]').val() == '') {
		        	error.push('제목을 입력해주세요.');
		        	$('.box-upload #upload-title').addClass('error');	
		        }

		        if ($('input[name=category]').val() == '') {
		        	error.push('카테고리를 선택해주세요.'); 	
		        	$('.box-upload .box-category > ul li.category-selected p').addClass('error');	
		        }

		        if (error.length > 0) {
		        	alert(error.join("\n"));
		        } else {
		        	$('input[name=creative]').val($('.box-creative').find('input:checked').parent().index()); // 크리에이티브 값
					$('input[name=profit]').val($('.box-profit').find('input:checked').parent().index()); // 영리목적 값
					$('input[name=share]').val($('.box-share').find('input:checked').parent().index()); // 공유 저작물 값
					$('input[name=open]').val($('.box-open').find('input:checked').parent().index()); // 공개 여부 값

			        //폼 submit
			        $("#upload-article").submit();
			        return false;
		        }
		        
	    	}
	        
			
	    });

		// 에러 제거
		$(document).on("change",'input[type=file]', function() {
			if ($(this).val() != '') {
				$('.box-upload .box-thumbnail').removeClass('error');
			}
		});

		$(document).on("blur",'input[name=title]', function() {
			if ($(this).val() != '') {
				$(this).removeClass('error');
			}
		});

		$(document).on("click",'.box-upload .box-category > ul li.category-list li a', function() {
			if ($('input[name=category]').val() != '') {
				$('.box-upload .box-category > ul li.category-selected p').removeClass('error');
			}
		});

	});
	
	</script>
@endsection