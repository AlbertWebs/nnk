<!-- Navbar -->
		<div class="navbar navbar-primary">
			<div class="container">
				<!-- Logo -->
				<a class="navbar-brand" href="{{url('/')}}">
					<img class="logo logo-dark logo-correction" alt="" src="{{url('/')}}/uploads/NNK-Logo-200x131.png" srcset="{{url('/')}}/uploads/NNK-Logo-200x131.png 2x">
					<img class="logo logo-light logo-correction" alt="" src="{{url('/')}}/uploads/NNK-Logo-200x131.png" srcset="{{url('/')}}/uploads/NNK-Logo-200x131.png 2x">
				</a>
				<!-- #end Logo -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainnav" aria-expanded="false">
						<span class="sr-only">Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Q-Button for Mobile -->
					<div class="quote-btn"><a class="btn" href="get-a-quote.html">Enquire Today</a></div>
				</div>
				<!-- MainNav -->
				<nav class="navbar-collapse collapse" id="mainnav">
					<ul class="nav navbar-nav">
						
						<li><a href="{{url('/')}}">Home</a></li>
						<li><a href="{{url('/')}}/about-us">About Us</a></li>
                        <li><a href="{{url('/')}}/about-us#the-team">The Team</a></li>
						<li class="dropdown">
							<a href="#">What We Do</a>
							<ul class="dropdown-menu">
								@php
									$services = \App\Models\Service::all();
								@endphp

								@foreach($services as $service)
									<li>
										<a href="{{ url('/services/' . $service->slung) }}">
											{{ $service->title }}
										</a>
									</li>
								@endforeach
							</ul>
						</li>
                        <li class="dropdown">
							<a href="#">Resources</a>
							<ul class="dropdown-menu">
								<li><a href="solution-single.html">Download Forms</a></li>
                                <li><a href="solution-single-alter.html">Membership</a></li>
							</ul>
						</li>
						<li><a href="{{url('contact-us')}}">Contact Us</a></li>
						
						<li class="quote-btn"><a class="btn" href="{{url('/')}}/join-us">Join Us</a></li>
					</ul>
				</nav>        
				<!-- #end MainNav -->
			</div>
		</div>
		<!-- #end Navbar -->