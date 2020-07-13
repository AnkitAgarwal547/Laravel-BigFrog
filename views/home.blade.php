@extends('layouts.app')

@section('content')
	@php $img_path = image_path(); @endphp
	<div class="wrapper">
		<div class="featured_blogs owl-carousel">
			{{--	Featured Post Slider   --}}
			@foreach($featured_posts as $f_posts)
				<div class="f_blog">
					<div class="f_blog_media">
						<a href="{{ url('/blog/'.$f_posts->slug) }}"><div style="background-image:url({{ URL::asset($f_posts->featured_image) }});"></div></a>
					</div>
					<div class="f_blog_content">
						<h3 class="f_blog_title"><a href="{{ url('/blog/'.$f_posts->slug) }}">{{ $f_posts->title }}</a></h3>
						<p class="f_blog_summary">{{ words($f_posts->description, 30, '...') }}</p>
					</div>
				</div>
			@endforeach
			{{--	Featured Post Slider Ends  --}}
		</div>

		<section class="couponHomeContent">
			<div class="container">
				<div class="row">
					<div class="col-md-4 mb-4 fadeInLeft wow">
						<div class="couponGuide">
							<h3>Featured Stores</h3>
							<div class="row m-0">
								@foreach($featured as $key=>$f_store)
									<div class="col-md-6 mb-4">
										<div class="similarBrand hvr-float" >
											<a href="{{ url('/store/').'/'.$f_store->slug }}">
												<img src="{{ URL::asset($f_store->image) }}">
												<h5>{{ $f_store->name }}</h5>
											</a>
											<div class="featuredStoreRating">
												@if(count($f_store->storeReview) > 0)
													@php $sum = 0; @endphp
													@foreach ($f_store->storeReview as $key=>$review)
														@php $sum = $sum + $review['stars'] @endphp
													@endforeach
													@php
														$total = $sum/($key+1);
													@endphp
												@else
													@php $total = '0.0'; @endphp
												@endif
												<h6>
													@php echo round($total).'.0'; @endphp
												</h6>
												@if(round($total) > 0)
													@for($i=1; $i<= 5; $i++)
														<i class="@if(round($total) >= $i) fa fa-star @else fa fa-star-o @endif"></i>
													@endfor
												@else
													@for($i=1; $i<= 5; $i++)
														<i class="fa fa-star-o" aria-hidden="true"></i>
													@endfor
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					<div class="col-md-8 mb-4">
						<div class="topRatedCoupon">
							<h4>Top Rated Coupons</h4>
							<div class="ratedCouponList">
								@if(count($top_rated_coupon) > 0)
									@foreach ($top_rated_coupon as $key=>$coupon)
										@if($coupon->valid_till > \Carbon\Carbon::now())
											<div class="homeCouponList fadeInRight wow">
												<div class="row">
													<div class="col-md-2">
														@if($coupon->store)
															<a href="{{ url('/store').'/'.$coupon->store->slug }}">
																<img src="{{ URL::asset($coupon->store->image) }}">
															</a>
														@endif
													</div>
													<div class="col-md-7">
														<h2>{{ $coupon->name }}</h2>
														<p>{!! words($coupon->description, 4, '') !!}</p>
													</div>
													<div class="col-md-3">
														<button class="btn showCode" data-toggle="modal" data-target="#exampleModal{{$key}}" onclick="openStore(event, '{{ $coupon->link_to_go }}', '')"> Show Code </button>
													</div>
												</div>
											</div>
											<!-- Modal -->
											<div class="modal couponPop" id="exampleModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel"></h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
															</button>
														</div>
														<div class="modal-body">

															<div class="couponPopUpContent">
																@if($coupon->store)
																	<h3>{{ $coupon->store->name }}</h3>
																@endif
																<h5>{{ $coupon->name }}</h5>
																<div class="couponCopy">
																	<h6 class="copytext" id="{{$coupon->id}}">{{ $coupon->coupon_code }}</h6>
																	<input type="hidden" name="" value="{{ $coupon->link_to_go }}">
																	<button class="btn copyBtn"><i class="fa fa-clone" aria-hidden="true"></i> Copy</button>
																</div>
																<p>{!! $coupon->description !!}</p>
															</div>

														</div>
														<div class="modal-footer">
															<div class="subscribeContent">
																<h6 class="subscribeEmail">Subscribe to Our Email List</h6>
																<form class="form-col" id="newsletter-popup{{$key}}">
																	{{ csrf_field() }}
																	<div class="form-group">
																		<input type="email" placeholder="Enter Your Email" name="newsletter_email" class="form-control">
																		<button class="btn subscribeBtn modalPopUpForm" type="Submit">
																			<div class="page-loader" style="position: absolute;top: -45px;right: -83px;z-index: 1;display: none;">
																				<img src="{{ config('constants.img_path') }}/loading.gif">
																			</div>
																			Subscribe
																		</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- Modal Ends -->
										@endif
									@endforeach
								@else
								@endif
							</div>


							<!-- Modal -->
							<div class="modal couponPop" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
											</button>
										</div>
										<div class="modal-body">

											<div class="couponPopUpContent">
												<h3>Louis Vuitton</h3>
												<h5>10% OFF at Growers Choice Seeds</h5>
												<div class="couponCopy">
													<h6>LOUIS10</h6>
													<button class="btn copyBtn"><i class="fa fa-clone" aria-hidden="true"></i> Copy</button>
												</div>
												<p>Simply add this coupon to your cart and check out.</p>
											</div>

										</div>
										<div class="modal-footer">
											<div class="subscribeContent">
												<h6 class="subscribeEmail">Subscribe to Our Email List</h6>
												<form class="form-col" id="newsletter-popup">
													{{ csrf_field() }}
													<div class="form-group">
														<input type="email" placeholder="Enter Your Email" name="newsletter_email" class="form-control">
														<button class="btn subscribeBtn" type="Submit">
															<div class="page-loader" style="position: absolute;top: -45px;right: -83px;z-index: 1;display: none;">
																<img src="{{ config('constants.img_path') }}/loading.gif">
															</div>
															Subscribe
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 mb-4 fadeInLeft wow">
					</div>

					<div class="col-md-8 mb-4 fadeInRight wow">
						<div class="topRatedCoupon">
							@if(!empty($video_guide))
								<h4 class="applyCouponTitle">How To Apply BigFrog Coupon Code</h4>
								<div class="videoSection">
									<iframe width="100%" height="300" src="{{ $video_guide->video_link }}">
									</iframe>
								</div>
							@endif

							@php
								$articles = latestArticles();
								$count = comment_count();
							@endphp
							@if(!empty($articles))
								<div class="homeBlogSlilder">
									<div class="homeBlogTitle"><h2>Blogs</h2></div>
									<div class="blogSlider slider">
										@foreach($articles as $key=>$article)
											<div class="slide">
												<div class="hvr-wobble-horizontal">
													<div class="blogSliderImg">
														<a href="{{ url('blog').'/'.$article->slug }}"><img src="@if (file_exists(public_path($article->featured_image)) && $article->featured_image!=''){{URL::asset($article->featured_image) }} @else {{ asset('assets/uploads/no_img.gif') }} @endif" alt="bdayFlower"></a>
														</div>
													<div class="blogSliderContent">
														<a href="{{ url('blog').'/'.$article->slug }}" class="brouseBtn">{{ $article->title }}</a>
														<ul>
															<li>{{ $author_name }}</li>
															<li><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('F / j',strtotime($article->created_at)) }}</li>
															<li><i class="fa fa-comments" aria-hidden="true"></i> {{ $count[$key] }}</li>
															<li><i class="fa fa-eye" aria-hidden="true"></i> {{ $article->view_count }}</li>
														</ul>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							@endif

						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="subscribeForm fadeInLeft wow">
			<div class="subscribeContent">
				<h2>Subscribe below to receive the latest coupons and discount codes</h2>
				<form class="form-col" id="newsletter">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="email" placeholder="Enter Your Email" name="newsletter_email" class="form-control">
						<button class="btn subscribeBtn" type="Submit">
							<div class="page-loader" style="position: absolute;top: -45px;right: -83px;z-index: 1;display: none;">
								<img src="{{ config('constants.img_path') }}/loading.gif">
							</div>
							Subscribe
						</button>
					</div>
				</form>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$(".featured_blogs").owlCarousel({
				items:4,
				nav:true,
				dots:false,
				responsive : {
					// breakpoint from 0 up
					0 : {
						items:2,
					},
					// breakpoint from 768 up
					768 : {
						items:3,
					},
					// breakpoint from 992 up
					992 : {
						items:3,
					}
				}
			});
		});
		//product slider
		$(document).ready(function(){
			$('.blogSlider').slick({
				slidesToShow: 2,
				slidesToScroll: 1,
				autoplay: false,
				autoplaySpeed: 3000,
				arrows: true,
				dots: false,
				pauseOnHover: false,
				responsive: [{
					breakpoint: 992,
					settings: {
						slidesToShow: 2
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: 1
					}
				}]
			});
		});
	</script>
@stop