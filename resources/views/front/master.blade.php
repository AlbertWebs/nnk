<!DOCTYPE html>
<html lang="zxx">

<head>
	
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	 {{-- Meta Tags --}}
     @include('front.meta')
    {{-- End Meta Tags --}}
	<link rel="icon" href="{{asset('theme/image/favicon.png')}}" type="image/png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="{{asset('theme/css/vendor.bundle.css')}}">
	<link id="style-css" rel="stylesheet" type="text/css" href="{{asset('theme/css/style62ea.css?ver=1.2')}}">
	<style type="text/css">
		/* Only Demo Purpose */
		.colorPanel {margin: 0px;padding: 5px;position: fixed;z-index: 100;min-width: 20px; border-radius: 4px 0 0 4px; background-color: #4b00a0;right:0;top: 33%;} .colorPanel ul {margin:0px;padding:0px;list-style: none;display:none;} .colorPanel ul li {display: block;margin-top: 10px;} .colorPanel ul a {display: block;width: 20px;height: 20px;border: #fff 1px solid;} .colorPanel a.cart {border-bottom: 1px solid rgba(255,255,255,.3); margin-bottom: 6px; padding-bottom: 8px;display: block;} #cpToggle{display:block;height:30px; width:20px; line-height:30px; background-size:cover;}.cp-custom{padding: 12px;}.cp-custom #cpToggle{background: none;}.cp-custom i{font-size: 15px;color:#fff;}
	</style>
	<!-- Animate.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
   
</head>
<body class="site-body style-v1">
	<!-- Header --> 
	<header class="site-header header-s1 is-sticky">
		<!-- Topbar -->
	    @include('front.topbar')
		<!-- #end Topbar -->
		<!-- Navbar -->
		@include('front.main-nav')
		<!-- #end Navbar -->
		<!-- Banner -->
		<div class="banner banner-static">
			<div class="container">
				<div class="content row">
					
					<div class="imagebg">
						<img src="{{url('/')}}/uploads/services/What-is-Labour-Welfare-Fund-and-How-It-Benefits.webp" alt="">
					</div>

				</div>
			</div>
		</div>
		<!-- End Banner -->
	</header>
	<!-- End Header -->

	<!-- Content -->
	@yield('content')
	<!-- Footer Widget-->
	@include('front.footer')
	<!-- End Footer Widget -->

	<!-- Copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="site-copy col-sm-7">
					<p>&copy; {{date('Y')}} NNK Staff Sacco Limited <span class="sep"> . </span> Licensed NI099999<span class="sep"> . </span> <a href="#">Terms and Condition</a></p>
				</div>
				<div class="site-by col-sm-5 al-right">
					<p>Powered By <a href="http://designekta.com/" target="_blank">Designekta Studios.</a></p>
				</div>
 				
			</div>
		</div>
	</div>
	<!-- End Copyright -->

	<!-- JavaScript Bundle -->
	<script src="{{asset('theme/js/jquery.bundle.js')}}"></script>

	<!-- End script -->
    	<!-- Theme Script init() -->
	<script src="{{asset('theme/js/script.js')}}"></script>
	<!-- End script -->
	

	<!-- WOW.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script>
		new WOW().init();
	</script>
</body>

</html>