<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
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
	<link rel="stylesheet" type="text/css" href="{{asset('airclass/css/signup.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/sweetalert/sweetalert.css')}}" />
	@section('css')
	@show
	@section('css_child')
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
					<a href="{{url('/')}}">首页</a>
				</li>
				<li>
					<a href="{{url('public_class')}}">公开课</a>
				</li>
				<li>
					<a href="{{url('answer_class')}}">答疑课</a>
				</li>
				<li>
					<a href="{{url('private_class')}}">私教课</a>
				</li>
				<li>
					<a href="{{url('help')}}">帮助</a>
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
					<ul class="keywords clearfix" style="display: none">
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
					<a class="logout" href="{{url('logout')}}">退出</a>
				</div>
				<div class="handlers pull-right">
					<a class="btn_login" href="{{url('login')}}" data-toggle="modal" data-target="#loginModal">登录</a><span class="devider">|</span>
					<a class="btn_signup" href="{{url('register')}}">注册</a>
				</div>
			</div>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>

@yield('container')

		<!-- Modal -->
<!-- login modal -->
<div class="login_modal modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="title text-center">账号密码登录</h3>
			<input type="text" class="form-control input_phone" placeholder="手机号">
			<input type="text" class="form-control input_pwd" placeholder="密码">
			<div class="form-group checkbox_group">
				<div class="checkbox">
					<label>
						<input type="checkbox" checked>
						<span class="checkbox_img"></span>
						记住密码
					</label>
				</div>
			</div>
			<button type="button" class="btn btn-block btn_login">登录</button>
			<p class="text-right links">
				<a class="btn_msg_login" href="javascript:void(0);">短信快捷登录</a>
				<span class="devider">|</span>
				<a class="btn_forget_pwd" href="javascript:void(0);">忘记密码？</a>
				<span class="devider">|</span>
				<a href="{{url('register')}}">注册账号</a>
			</p>
			<div class="text-right wechat_login_container">
				其他登录方式：
				<a href="javascript:void(0);" class="wechat_login pull-right"><span class="icon icon_wechat pull-left"></span>微信登录</a>
			</div>
		</div>
	</div>
</div>

<!-- msg login modal -->
<div class="login_modal msg_login_modal modal fade" id="msgLoginModal" tabindex="-1" role="dialog" aria-labelledby="msgLoginModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="title text-center">短信快捷登录</h3>
			<!--<p class="tips text-center">验证即登录，未注册将自动创建百度帐号</p>-->
			<input type="text" class="form-control input_phone" placeholder="手机号">
			<div class="input_code_container form-inline clearfix">
				<input type="text" class="input_code form-control pull-left" placeholder="密码">
				<button type="button" class="btn pull-right btnGetCode">获取验证码</button>
			</div>
			<button type="button" class="btn btn-block btn_login">登录</button>
			<div class="others clearfix">
				<div class="form-group pull-left">
					<div class="checkbox">
						<label>
							<input type="checkbox" checked>
							<span class="checkbox_img"></span>
						</label>
						<a href="#" target="_blank">同意用户协议</a>
					</div>
				</div>
				<a class="btn_username_login pull-right" href="javascript:void(0);">账号密码登录</a>
			</div>
			<div class="text-right wechat_login_container">
				其他登录方式：
				<a href="javascript:void(0);" class="wechat_login pull-right"><span class="icon icon_wechat pull-left"></span>微信登录</a>
			</div>
		</div>
	</div>
</div>

<!-- wechat login modal -->
<div class="login_modal modal fade" id="wechatLoginModal" tabindex="-1" role="dialog" aria-labelledby="msgLoginModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="title text-center">微信登录</h3>
			<p class="text-center">设计图</p>
		</div>
	</div>
</div>


<!-- forget password modal -->
<div class="login_modal msg_login_modal forget_pwd_modal modal fade" id="forgetPwdModal" tabindex="-1" role="dialog" aria-labelledby="msgLoginModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="title text-center">忘记密码</h3>
			<input type="text" class="form-control input_phone" placeholder="手机号">
			<div class="input_code_container form-inline clearfix">
				<input type="text" class="input_code form-control pull-left" placeholder="验证码">
				<button type="button" class="btn pull-right btnGetCode">获取验证码</button>
			</div>
			<input type="text" class="form-control input_pwd" placeholder="设置密码">
			<input type="text" class="form-control input_pwd2" placeholder="确认密码">
			<button type="button" class="btn btn-block btn_login">登录</button>
			<div class="text-right wechat_login_container">
				其他登录方式：
				<a href="javascript:void(0);" class="wechat_login pull-right"><span class="icon icon_wechat pull-left"></span>微信登录</a>
			</div>
		</div>
	</div>
</div>

<!-- alert modal -->
<div class="modal fade alert_modal" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			...
		</div>
	</div>
</div>

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
<script src="{{asset('airclass/js/jquery.common.js')}}"></script>
<!-- video5 -->

<script type="text/javascript">

	function showAlertModal(msg) {
		$('#alertModal').find('.modal-content').text(msg);
		$('#alertModal').modal('show');
		setTimeout(function() {
			$('#alertModal').modal('hide');
		}, 1500);
	}


	var showTips = function(dom) {
		$(dom).parents('.form-group').find('.tips').show();
		$(dom).focus();
	};

	$(function() {
		$('.lessons .nav a').mouseover(function() {
			console.log($(this));
			console.log($(this).attr('data-imgSrc'));
			console.log($(this).attr('data-intro'));
			$(this).parents('.lessons').find('.lesson_big')
					.find('img').attr('src', $(this).attr('data-imgSrc')).end()
					.find('.introduction').html($(this).attr('data-intro'));
			$(this).tab('show');
		});
		$('.login_modal .wechat_login').click(function() {
			$('.login_modal').modal('hide');
			$('#wechatLoginModal').modal('show');
		});
		$('.login_modal .btn_forget_pwd').click(function() {
			$('.login_modal').modal('hide');
			$('#forgetPwdModal').modal('show');
		});
		$('.login_modal .btn_msg_login').click(function() {
			$('.login_modal').modal('hide');
			$('#msgLoginModal').modal('show');
		});
		$('.login_modal .btn_username_login').click(function() {
			$('.login_modal').modal('hide');
			$('#loginModal').modal('show');
		});
//				$('#btnSignup').click(function() {
//					$('#successModal').modal('show');
//				});
		$('.btn_index').click(function() {
			window.location.href = '{{url('user')}}';
		});

		// 账号密码登录modal
		$('#loginModal .btn_login').click(function() {
			if (!checkPhone($('#loginModal .input_phone').val())) {
				showAlertModal('手机号格式不正确');
				return;
			}
			if ($('#loginModal .input_pwd').val() == '') {
//						alert('请输入密码');
				showAlertModal('请输入密码');
				return;
			}
			// ajax请求
		});

		// 短信快捷登录modal
		// 获取密码
		$('#msgLoginModal .btnGetCode').click(function() {
			if (checkPhone($('#msgLoginModal .input_phone').val())) {
				// ajax获取验证码
			} else {
				showAlertModal('手机号格式不正确');
			}
		});
		//登录
		$('#msgLoginModal .btn_login').click(function() {
			if (!checkPhone($('#msgLoginModal .input_phone').val())) {
				showAlertModal('手机号格式不正确');
				return;
			}
			if ($('#msgLoginModal .input_code').val() == '') {
//						alert('请输入密码');
				showAlertModal('请输入验证码');
				return;
			}
			// ajax请求
		});

		// 忘记密码modal
		// 获取验证码
		$('#forgetPwdModal .btnGetCode').click(function() {
			if (checkPhone($('#forgetPwdModal .input_phone').val())) {
				// ajax获取验证码
			} else {
				showAlertModal('手机号格式不正确');
			}
		});
		//登录
		$('#forgetPwdModal .btn_login').click(function() {
			if (!checkPhone($('#forgetPwdModal .input_phone').val())) {
				showAlertModal('手机号格式不正确');
				return;
			}
			if ($('#forgetPwdModal .input_code').val() == '') {
//						alert('请输入验证码');
				showAlertModal('请输入验证码');
				return;
			}
			if ($('#forgetPwdModal .input_pwd').val() == '') {
//						alert('请输入密码');
				showAlertModal('请输入密码');
				return;
			}
			if ($('#forgetPwdModal .input_pwd2').val() == '' || $('#forgetPwdModal .input_pwd').val() == '') {
//						alert('请确认两次输入密码一致');
				showAlertModal('请确认两次输入密码一致');
				return;
			}
			// ajax请求
		});

	})
</script>
@section('js')
@show
@section('js_child')
@show
</body>
</html>