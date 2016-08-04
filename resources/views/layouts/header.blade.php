<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>C.GALLERY @yield('title')</title>
	<link rel="shortcut icon" href="{{ url('images/logof.png') }}">
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
	<script src="{{ url('js/pjax.js') }}"></script>
	<script src="{{ url('js/nprogress.js') }}"></script>
	<script src="{{ url('js/common.js') }}"></script>
	<script type="text/javascript" src="{{ url('/editor/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
	<script type="text/javascript" src="{{ url('/js/uploadPreview.js') }}"></script>
	<link rel='stylesheet' href="{{url('css/nprogress.css') }}"/>
	<link rel="stylesheet" href="{{ url('css/reset.css') }}">
	<link rel="stylesheet" href="{{ url('css/common.css') }}">
</head>
<body>
	@include('layouts.tag-header')