<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta property="og:url"           content="{{ URL::current() }}" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="@yield('article_title')" />
		<meta property="og:description"   content="@yield('article_content')" />
		<meta property="og:image"         content="" />
		<title>C.GALLERY @yield('title')</title>
		<link rel="shortcut icon" href="{{ url('images/logof.png') }}">
		<script src="{{ url('js/jquery.2.1.4.js') }}"></script>
		<script src="{{ url('js/jquery.tagsinput.js') }}"></script>
		<script src="{{ url('js/pjax.js') }}"></script>
		<script src="{{ url('js/nprogress.js') }}"></script>
		<script src="{{ url('js/common.js') }}"></script>
		<script type="text/javascript" src="{{ url('/editor/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
		<script type="text/javascript" src="{{ url('/js/uploadPreview.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/jquery.Jcrop.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/bootstrap-typeahead.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/mention.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/blur.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/article.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/comment.js') }}"></script>
		<script type="text/javascript" src="{{ url('/js/user.js') }}"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<link rel='stylesheet' href="{{url('css/nprogress.css') }}"/>
		<link rel="stylesheet" href="{{ url('css/reset.css') }}">
		<link rel="stylesheet" href="{{ url('css/common.css') }}">
		<link rel="stylesheet" href="{{ url('css/jquery.Jcrop.css') }}">
		<link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/jquery.tagsinput.css') }}" />
	</head>
	<body>
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '322237758119021',
		      xfbml      : true,
		      version    : 'v2.7'
		    });
		  };

		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		</script>
		@include('layouts/tag-header')
		<div class="wrap_main" id="pjax-container">
			@yield('content')
		</div>
	</body>
</html>