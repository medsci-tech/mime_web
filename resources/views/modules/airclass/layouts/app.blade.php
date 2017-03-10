<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>首页</title>
	<!-- Bootstrap -->
	<link href="{{asset('airclass/css/bootstrap.min.css')}}" rel="stylesheet">
	<!-- video5 -->
	<link rel="stylesheet" type="text/css" href="{{asset('airclass/plugin/Video5/css/video-js.min.css')}}"/>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="{{asset('airclass/css/common.css')}}" />
	@section('css')
	@show
</head>
<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="javascript:void(0);">
				<img alt="空中课堂" src="{{asset('airclass/img/logo_nav.png')}}">
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav">
				<li>
					<a href="javascript:void(0);">首页</a>
				</li>
				<li>
					<a href="javascript:void(0);">公开课</a>
				</li>
				<li>
					<a href="javascript:void(0);">答疑课</a>
				</li>
				<li>
					<a href="javascript:void(0);">私教课</a>
				</li>
				<li>
					<a href="javascript:void(0);">帮助</a>
				</li>
			</ul>
			<div class="nav navbar-nav navbar-right clearfix">
				<form class="navbar-form pull-left" role="search">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="搜索视频">
								<span class="input-group-btn">
									<button class="btn" type="button"><span class="glyphicon glyphicon-search"></span></button>
								</span>
					</div>
					<ul class="keywords clearfix">
						<li class="keyword pull-left">
							<a href="javascript:void(0);">关键词</a>
						</li>
						<li class="keyword pull-left">
							<a href="javascript:void(0);">关键词</a>
						</li>
						<li class="keyword pull-left">
							<a href="javascript:void(0);">关键词</a>
						</li>
						<li class="keyword pull-left">
							<a href="javascript:void(0);">关键词</a>
						</li>
					</ul>
				</form>
				<div class="handlers pull-right hidden">
							<span class="reminder glyphicon glyphicon-bell">
								<span class="badge">2</span>
							</span>
					<a class="username" href="javascript:void(0);">小明</a><span class="devider">|</span>
					<a class="logout" href="javascript:void(0);">退出</a>
				</div>
				<div class="handlers pull-right">
					<a class="btn_login" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">登录</a><span class="devider">|</span>
					<a class="btn_signup" href="/airClass/signup.html">注册</a>
				</div>
			</div>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>

@yield('container')

<!-- footer -->
<footer class="footer text-center">
	<p class="index_footer_logo">
		<a class="logo_ap" href="javascript:void(0);">
			<img alt="全科医学协作平台" src="{{asset('airclass/img/logo_footer_ap.png')}}">
		</a>
		<a href="javascript:void(0);">
			<img alt="迈德" src="{{asset('airclass/img/logo_footer_md.png')}}">
		</a>
	</p>
	<p class="copyright">空中课堂所有学习视频课适用于《中华人民共和国著作权法》</p>
	<p class="copyright">空中课堂所有学习视频经授课专家许可使用，Mime、Itangyi、空课APP经版权方许可使用。未经书面允许，请勿转播</p>
	<p class="copyright">除非另有声明，本平台其它视频作品采用Creative Common知识共享署名-非商业性使用-相同方式共享2.5中国大陆许可协议进行许可</p>
	<p class="copyright">Copyright &copy; Medscience-tech.All rights reserved.鄂ICP备13013615号-1</p>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('airclass/js/jquery-1.11.1.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('airclass/js/bootstrap.min.js')}}"></script>
<!-- video5 -->
<script src="{{asset('airclass/plugin/Video5/js/video.min.js')}}"></script>
@section('js')
@show
<script type="text/javascript">
	$('.lessons .nav a').mouseover(function() {
		console.log($(this));
		console.log($(this).attr('data-imgSrc'));
		console.log($(this).attr('data-intro'));
		$(this).parents('.lessons').find('.lesson_big')
				.find('img').attr('src', $(this).attr('data-imgSrc')).end()
				.find('.introduction').html($(this).attr('data-intro'));
		$(this).tab('show');
	});
</script>
</body>
</html>