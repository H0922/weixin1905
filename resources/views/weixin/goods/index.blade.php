@extends('layouts.layout')
@section('title','20170111')
@section('content')
	<div class="menus" id="animatedModal">
		<div class="close-animatedModal close-icon">
			<i class="fa fa-close"></i>
		</div>
		<div class="modal-content">
			<div class="cart-menu">
				<div class="container">
					<div class="content">
						<div class="cart-1">
							<div class="row">
								<div class="col s5">
									<img src="weixin/img/cart-menu1.png" alt="">
								</div>
								<div class="col s7">
									<h5><a href="">Fashion Men's</a></h5>
								</div>
							</div>
							<div class="row quantity">
								<div class="col s5">
									<h5>Quantity</h5>
								</div>
								<div class="col s7">
									<input value="1" type="text">
								</div>
							</div>
							<div class="row">
								<div class="col s5">
									<h5>Price</h5>
								</div>
								<div class="col s7">
									<h5>$20</h5>
								</div>
							</div>
							<div class="row">
								<div class="col s5">
									<h5>Action</h5>
								</div>
								<div class="col s7">
									<div class="action"><i class="fa fa-trash"></i></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="cart-2">
							<div class="row">
								<div class="col s5">
									<img src="weixin/img/cart-menu2.png" alt="">
								</div>
								<div class="col s7">
									<h5><a href="">Fashion Men's</a></h5>
								</div>
							</div>
							<div class="row quantity">
								<div class="col s5">
									<h5>Quantity</h5>
								</div>
								<div class="col s7">
									<input value="1" type="text">
								</div>
							</div>
							<div class="row">
								<div class="col s5">
									<h5>Price</h5>
								</div>
								<div class="col s7">
									<h5>$20</h5>
								</div>
							</div>
							<div class="row">
								<div class="col s5">
									<h5>Action</h5>
								</div>
								<div class="col s7">
									<div class="action"><i class="fa fa-trash"></i></div>
								</div>
							</div>
						</div>
					</div>
					<div class="total">
						<div class="row">
							<div class="col s7">
								<h5>Fashion Men's</h5>
							</div>
							<div class="col s5">
								<h5>$21.00</h5>
							</div>
						</div>
						<div class="row">
							<div class="col s7">
								<h5>Fashion Men's</h5>
							</div>
							<div class="col s5">
								<h5>$21.00</h5>
							</div>
						</div>
						<div class="row">
							<div class="col s7">
								<h6>Total</h6>
							</div>
							<div class="col s5">
								<h6>$41.00</h6>
							</div>
						</div>
					</div>
					<button class="btn button-default">Process to Checkout</button>
				</div>
			</div>
		</div>
		</div>

	<div class="slider">
		
		<ul class="slides">
			<li>
				<img src="weixin/img/slide1.jpg" alt="">
				<div class="caption slider-content  center-align">
					<h2>WELCOME TO MSTORE</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
			<li>
				<img src="weixin/img/slide2.jpg" alt="">
				<div class="caption slider-content center-align">
					<h2>JACKETS BUSINESS</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
			<li>
				<img src="weixin/img/slide3.jpg" alt="">
				<div class="caption slider-content center-align">
					<h2>FASHION SHOP</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
		</ul>

	</div>
	<!-- end slider -->

	<!-- features -->
	<div class="features section">
		<div class="container">
			<div class="row">
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-car"></i>
						</div>
						<h6>Free Shipping</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-dollar"></i>
						</div>
						<h6>Money Back</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
			</div>
			<div class="row margin-bottom-0">
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						<h6>Secure Payment</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-support"></i>
						</div>
						<h6>24/7 Support</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end features -->

	<!-- quote -->
	<div class="section quote">
		<div class="container">
			<h4>FASHION UP TO 50% OFF</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
		</div>
	</div>
	<!-- end quote -->

	<!-- product -->
	<div class="section product">
		<div class="container">
			<div class="section-head">
				<h4>NEW PRODUCT</h4>
				<div class="divider-top"></div>
				<div class="divider-bottom"></div>
			</div>
			
			<div class="row">
					@foreach ($data as $k=>$v)
					<div class="col s6">
						<div class="content">
							<a href="{{url('goodslist/'.$v->goods_id)}}"><img src="{{url('storage/'.$v->goods_img)}}"></a>
							<h6><a href="">{{$v->goods_name}}</a></h6>
							<div class="price">
								￥{{$v->goods_price}} <span>￥{{$v->goods_price+6235}}</span>
							</div>
							<button class="btn button-default">加入购物车</button>
						</div>
					</div>
					@endforeach
				</div>
		</div>
	</div>
	<div id="fakeLoader"></div>
@endsection
<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
{{-- <script src="weixin/js/weixin.js"></script> --}}
<script>
	wx.config({
		debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: "{{$wx_config['appId']}}", // 必填，公众号的唯一标识
		timestamp: "{{$wx_config['timestamp']}}", // 必填，生成签名的时间戳
		nonceStr: "{{$wx_config['nonceStr']}}", // 必填，生成签名的随机串
		signature: "{{$wx_config['signature']}}",// 必填，签名
		jsApiList: ['updateAppMessageShareData','chooseImage','updateTimelineShareData'] // 必填，需要使用的JS接口列表
	});
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		//发送给朋友
		wx.updateAppMessageShareData({
			title: '分享测试', // 分享标题
			desc: '测试', // 分享描述
			link: 'http://www.bianaoao.top/goodsgoods', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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
				link: 'http://www.bianaoao.top/goodsgoods', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
				imgUrl: 'http://www.bianaoao.top/wx_media/imgs/201912170048359453.jpeg', // 分享图标
				success: function () {
					alert("分享成功");
				}
			})
		});
	});
</script>