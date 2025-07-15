@extends('front.master')

@section('content')

<!-- Contents -->
	<div class="section section-contents section-pad">
		<div class="container">
			<div class="content row">
			
				<div class="row">
					<div class="col-md-8">
					
						{{-- <h1>{{$service->title}}</h1> --}}
						<p class="lead"><strong>{{$service->meta}}</strong></p>
						<p >
                            {!! $service->description !!}
                        </p>
					
						
						
						
						<p class="lead">If you have any questions regarding our services, please <strong>contact us</strong> or call at <strong>+254 720 496 849</strong>.</p>
						
					</div>
					<!-- Sidebar -->
					<div class="col-md-4">
						<div class="sidebar-right">

							<div class="wgs-box wgs-menus">
								<div class="wgs-content">
									<ul class="list list-grouped">
										<li class="list-heading">
											<span>Our Solutions To Our Members</span>
											<ul>
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
									</ul>									
								</div>
							</div>

							<div class="wgs-box wgs-quoteform">
								<h3 class="wgs-heading">Quick Contact</h3>
								<div class="wgs-content">
									<p>If you have any questions or would like to book a session please contact us.</p>
									<form  id="contact-us" class="form-quote" action="https://demo.themenio.com/industrial/form/contact.php" method="post">
										<div class="form-results"></div>
										<div class="form-group">
											<div class="form-field">
												<input name="contact-name" type="text" placeholder="Name *" class="form-control required">
											</div>
										</div>
										<div class="form-group">
											<div class="form-field">
												<input name="contact-email" type="email" placeholder="Email *" class="form-control required email">
											</div>
										</div>
										<div class="form-group">
											<div class="form-field form-m-bttm">
												<input name="contact-phone" type="text" placeholder="Phone" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<div class="form-field">
												<input name="contact-service" type="text" placeholder="Interest of Service" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<div class="form-field">
												<textarea name="contact-message" placeholder="Messages *" class="txtarea form-control required"></textarea>
											</div>
										</div>
										<input type="text" class="hidden" name="form-anti-honeypot" value="">
										<button type="submit" class="btn btn-alt sb-h">Submit</button>
									</form>
								</div>
							</div>

						</div>
					</div>
					<!-- Sidebar #end -->
				</div>
				
			</div>
		</div>		
	</div>
	<!-- End Section -->

	<!-- Call Action -->
	<div class="call-action bg-primary">
		<div class="cta-block">
			<div class="container">
				<div class="content row">

					<div class="cta-sameline">
						<h3>DEPENDABLE SUPPORT YOU CAN COUNT ON</h3>
						<pclass="lead">We’re committed to delivering trusted, timely service—tailored to your needs, every step of the way.</p>
						<a class="btn btn-outline" href="{{url('/')}}/contact-us">Get In Touch</a>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- End Section -->



@endsection