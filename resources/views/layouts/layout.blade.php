<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="HandheldFriendly" content="True">

	<link rel="stylesheet" href="weixin/css/materialize.css">
	<link rel="stylesheet" href="weixin/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="weixin/css/normalize.css">
	<link rel="stylesheet" href="weixin/css/owl.carousel.css">
	<link rel="stylesheet" href="weixin/css/owl.theme.css">
	<link rel="stylesheet" href="weixin/css/owl.transitions.css">
	<link rel="stylesheet" href="weixin/css/fakeLoader.css">
	<link rel="stylesheet" href="weixin/css/animate.css">
	<link rel="stylesheet" href="weixin/css/style.css">
	
	<link rel="shortcut icon" href="weixin/img/favicon.png">

</head>
<body>
	<div class="navbar-top">
			<div class="site-brand">
					<a href="index.html"><h1>Mstore</h1></a>
			</div>
			<div class="side-nav-panel-right">
					<a href="#" data-activates="slide-out-right" class="side-nav-left"><i class="fa fa-user"></i></a>
			</div>
	</div>
	<div class="side-nav-panel-right">
		<ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
			<li class="profil">
				<img src="{{session('headimgurl')??''}}" alt="">
				<h2>{{session('nickname')??''}}</h2>
			</li>
			<li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>
			<li><a href="about-us.html"><i class="fa fa-user"></i>About Us</a></li>
			<li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
			<li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
			<li><a href="register.html"><i class="fa fa-user-plus"></i>Register</a></li>
		</ul>
	</div>
	<div class="navbar-bottom">
		<div class="row">
			<div class="col s2">
				<a href="index.html"><i class="fa fa-home"></i></a>
			</div>
			<div class="col s2">
				<a href="wishlist.html"><i class="fa fa-heart"></i></a>
			</div>
			<div class="col s4">
				<div class="bar-center">
					<a href="#animatedModal" id="cart-menu"><i class="fa fa-shopping-basket"></i></a>
					<span>2</span>
				</div>
			</div>
			<div class="col s2">
				<a href="contact.html"><i class="fa fa-envelope-o"></i></a>
			</div>
			<div class="col s2">
				<a href="#animatedModal2" id="nav-menu"><i class="fa fa-bars"></i></a>
			</div>
		</div>
	</div>
	<!-- end navbar bottom -->

	<!-- menu -->
	<div class="menus" id="animatedModal2">
		<div class="close-animatedModal2 close-icon">
			<i class="fa fa-close"></i>
		</div>
		<div class="modal-content">
			<div class="container">
				<div class="row">
					<div class="col s4">
						<a href="index.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-home"></i>
								</div>
								Home
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="product-list.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-bars"></i>
								</div>
								Product List
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="{{url('goodslist')}}" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-eye"></i>
								</div>
								Single Shop
							</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col s4">
						<a href="wishlist.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-heart"></i>
								</div>
								Wishlist
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="cart.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-shopping-cart"></i>
								</div>
								Cart
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="checkout.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-credit-card"></i>
								</div>
								Checkout
							</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col s4">
						<a href="blog.html" class="button-link">	
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-bold"></i>
								</div>
								Blog
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="blog-single.html" class="button-link">	
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-file-text-o"></i>
								</div>
								Blog Single
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="error404.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-hourglass-half"></i>
								</div>
								404
							</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col s4">
						<a href="testimonial.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-support"></i>
								</div>
								Testimonial
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="about-us.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-user"></i>
								</div>
								About Us
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="contact.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-envelope-o"></i>
								</div>
								Contact
							</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col s4">
						<a href="setting.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-cog"></i>
								</div>
								Settings
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="login.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-sign-in"></i>
								</div>
								Login
							</div>
						</a>
					</div>
					<div class="col s4">
						<a href="register.html" class="button-link">
							<div class="menu-link">
								<div class="icon">
									<i class="fa fa-user-plus"></i>
								</div>
								Register
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
    </div>
    	<!-- cart menu -->
	{{-- <div class="menus" id="animatedModal"> --}}
        @yield('content')
	{{-- </div> --}}
	<div class="footer">
			<div class="container">
				<div class="about-us-foot">
					<h6>黄晓博</h6>
					<p>问世间什么最美丽，爱情绝对是个奇迹</p>
				</div>
				{{-- <div class="social-media">
					<a href=""><i class="fa fa-facebook"></i></a>
					<a href=""><i class="fa fa-twitter"></i></a>
					<a href=""><i class="fa fa-google"></i></a>
					<a href=""><i class="fa fa-linkedin"></i></a>
					<a href=""><i class="fa fa-instagram"></i></a>
				</div> --}}
				<div class="copyright">
					<span>QQ:7370515678</span>
				</div>
			</div>
		</div>
    <script src="weixin/js/jquery.min.js"></script>
	<script src="weixin/js/materialize.min.js"></script>
	<script src="weixin/js/owl.carousel.min.js"></script>
	<script src="weixin/js/fakeLoader.min.js"></script>
	<script src="weixin/js/animatedModal.min.js"></script>
	<script src="weixin/js/main.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
	<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
	<script>
		wx.config({
			debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
			appId: "{{$wx_config ?? ''['appId']}}", // 必填，公众号的唯一标识
			timestamp: "{{$wx_config ?? ''['timestamp']}}", // 必填，生成签名的时间戳
			nonceStr: "{{$wx_config ?? ''['nonceStr']}}", // 必填，生成签名的随机串
			signature: "{{$wx_config ?? ''['signature']}}",// 必填，签名
			jsApiList: ['updateAppMessageShareData','chooseImage','updateTimelineShareData'] // 必填，需要使用的JS接口列表
		});
		wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
			//发送给朋友
			wx.updateAppMessageShareData({
				title: '分享测试', // 分享标题
				desc: '测试', // 分享描述
				link: 'http://www.bianaoao.top', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
				imgUrl: 'http://www.bianaoao.top/wx_media/imgs/201912170048359453.jpeg', // 分享图标
				success: function () {
					// 设置成功
					alert('设置成功');
				}
			})
			//分享到盆友圈
			wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
				wx.updateTimelineShareData({
					title: '分享测试', // 分享标题
					link: 'http://www.bianaoao.top', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					imgUrl: 'http://www.bianaoao.top/wx_media/imgs/201912170048359453.jpeg', // 分享图标
					success: function () {
						alert("分享成功");
					}
				})
			});
		});
	</script>
</body>
</html>