
@extends('front.master-home')
	
@section('content')
	<!--Content  -->
	<div class="section section-contents section-pad-lg" id="about">
		<div class="container">
			<div class="content row">
				
				<div class="row">
					<div class="col-sm-6 pad-r vertical-center wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="0.3s">
						<h1 class="heading-section heading-lead color-dark strong">
							 <span class="strong theme-blue">Established on</span> <span class="color-secondary strong">April 21, 1987,</span> with a <span class="theme-green strong">commitment</span> to <span class="theme-red strong">empowering lives</span> through <span class="strong">trust, community, and growth</span>.
						</h1>
					</div>


					<div class="col-sm-6 wow fadeInRight" data-wow-duration="1.2s" data-wow-delay="0.5s">
						<p class="lead about-hero">
							NNK Staff Sacco Limited is a Sacco duly registered under The Ministry of Trade, Industrialization and Enterprise Development. The same was registered on 21″ April 1987 and started operations with about 20 members then localized to the law firm of Ndungu Njoroge & Kwach Advocates. Today the Sacco boasts a membership of 75 members with employees of NNK Advocates and TripleOKLaw Advocates as the main members. Nevertheless, we have accommodated membership from other institutions. The Sacco is run in accordance with its by-laws and the larger Sacco legislative regime. The Sacco is a member of KUSCCO, the umbrella Sacco body.
						</p>
						<p class="about-hero">
						   <a href="{{url('/')}}/about-us" class=" btn btn-alt btn-outline wow fadeInUp" data-wow-duration="2.2s" data-wow-delay="0.5s">Who We Are</a>	
						</p>
					</div>
				</div>

			</div>			
		</div>
	</div>
	<!-- End conetnt -->
	
	<!--Content  -->
	<div class="section section-contents section-pad-lg no-pb-sm light">
		<div class="container">
			<div class="content row">
				
				<div class="wide-sm center wow fadeInUp" data-wow-duration="1.2s" data-wow-delay="0.5s">
					<h2 class="heading-section heading-modern">What We Do</h2>
					<p>
					    NNK Staff Sacco Limited supports its members through accessible savings and credit services. Founded in 1987, we serve professionals from NNK Advocates, TripleOKLaw, and other institutions, all guided by strong values and cooperative principles.	
					</p>
				</div>
				
				<!-- Feature Row  -->
				<div class="feature-row feature-service-row row feature-modern center">

					<?php 
					   $ServicesList = DB::table('services')->get();
					   $Count = 1;	
					?>
					@foreach ($ServicesList as $item)
					<div class="col-sm-4 odd @if($Count == 1) first @else odd @endif wow fadeInUp" data-wow-duration="1.{{$item->id}}s" data-wow-delay="0.{{$item->id}}s" style="padding:5px">
						<!-- feature box -->
						<div class="feature boxed">
							<a href="{{ url('/services/' . $item->slung) }}"">
								<div class="fbox-photo">
									<img class="image-resizer" src="{{url('/')}}/uploads/services/{{$item->image}}" alt="">
								</div>
								<div class="fbox-over">
									<h3 class="title">{{$item->title}} {{$Count}}</h3>
									<span class="more-nolink">Discover</span>
								</div>
							</a>
						</div>
						<!-- End Feature box -->
					</div>
					<?php $Count = $Count+1; ?>
					@endforeach
					
				
				</div>
				<!-- Feture Row  #end -->

			</div>			
		</div>
		<div class="section-bg imagebg has-parallax">
			<img src="{{asset('theme/image/plx-content-fs.jpg')}}" alt="">
			<div class="olayer-75"></div>
		</div>
	</div>
	<!-- End conetnt -->

		<!-- Content -->
	<div class="section section-about section-pad-lg">
		<div class="container">
			<div class="content row center">
				
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h1 class="heading wow fadeInUp" data-wow-duration="1.2s" data-wow-delay="0.5s">Our objective is to provide timely and quality financial and allied services to our members as per their need. </h1>
						<p class="lead wow fadeInUp" data-wow-duration="1.2s" data-wow-delay="0.5s">
						     	{{--  --}}
                                At NNK Staff Sacco Limited, our objective is to provide timely and quality financial and allied services tailored to the unique needs of our members.
								We understand that each member’s goals are different, and that’s why we focus on delivering personalized support, efficient service delivery, and sustainable solutions that help our members achieve financial stability and long-term growth.
								{{--  --}}
						</p>	
						<a href="{{url('/')}}" class="btn btn-alt btn-outline wow fadeInUp" data-wow-duration="2.2s" data-wow-delay="0.5s">Membership</a>			
					</div>
				</div>
				
			</div>	
		</div>
	</div>
	<!-- End Content -->

	

	
	<!-- Call Action -->
	<div class="call-action has-bg" style="background-image: url('{{asset('/uploads/services/What-is-Labour-Welfare-Fund-and-How-It-Benefits.webp')}}');">
		<div class="cta-block">
			<div class="container">
				<div class="content row wow fadeInUp" data-wow-duration="1.2s" data-wow-delay="0.5s">

					<div class="cta-sameline">
						<h2 class="wow fadeInUp" data-wow-duration="1.2s" data-wow-delay="0.5s">DEPENDABLE SUPPORT YOU CAN COUNT ON</h2>
						<p class="lead">We’re committed to delivering trusted, timely service—tailored to your needs, every step of the way.</p>
						<a class="btn" href="{{url('/')}}/contact-us">Contact Us</a>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- End Section -->
	

@endsection