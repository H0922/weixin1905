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
	<!-- end cart menu -->
	
	<!-- shop single -->
	<div class="pages section">
		<div class="container">
			<div class="shop-single">
				<img src="{{url('storage/'.$link->goods_img)}}" alt="">
				<h5>{{$link->goods_name}}</h5>
				<div class="price">￥{{$link->goods_price}} <span>￥{{$link->goods_price+6235}} </span></div>
				{{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam eaque in non delectus, error iste veniam commodi mollitia, officia possimus, repellendus maiores doloribus provident. Itaque, ab perferendis nemo tempore! Accusamus</p> --}}
				{!! $link->goods_desc !!}
				<button type="button" class="btn button-default">加入购物车</button>
			</div>
			<div class="review">
					<h5>1 reviews</h5>
					<div class="review-details">
						<div class="row">
							<div class="col s3">
								<img src="weixin/img/user-comment.jpg" alt="" class="responsive-img">
							</div>
							<div class="col s9">
								<div class="review-title">
									<span><strong>John Doe</strong> | Juni 5, 2016 at 9:24 am | <a href="">Reply</a></span>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis accusantium corrupti asperiores et praesentium dolore.</p>
							</div>
						</div>
					</div>
				</div>	
				<div class="review-form">
					<div class="review-head">
						<h5>Post Review in Below</h5>
						<p>Lorem ipsum dolor sit amet consectetur*</p>
					</div>
					<div class="row">
						<form class="col s12 form-details">
							<div class="input-field">
								<input type="text" required class="validate" placeholder="NAME">
							</div>
							<div class="input-field">
								<input type="email" class="validate" placeholder="EMAIL" required>
							</div>
							<div class="input-field">
								<input type="text" class="validate" placeholder="SUBJECT" required>
							</div>
							<div class="input-field">
								<textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR REVIEW"></textarea>
							</div>
							<div class="form-button">
								<div class="btn button-default">POST REVIEW</div>
							</div>
						</form>
					</div>
				</div>
		</div>
	</div>
	<div id="fakeLoader"></div>	
@endsection