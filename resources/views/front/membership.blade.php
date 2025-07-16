@extends('front.master-pages')

@section('content')

   <!-- Contents -->
	<div class="section section-contents section-pad">
		<div class="container">
			<div class="content row">

				<div class="row">
					<div class="quote-list col-md-8 res-m-bttm">
						<div class="quote-group">
							<h1>Membership Application Form</h1>
							<p>
                                Interested in becoming a member of NNK Staff Sacco? You're in the right place. Kindly fill out the Membership Application Form with accurate details to begin your journey with us. As a member, you’ll enjoy access to our savings and loan products, support services, and a trusted financial community. Be sure to review the requirements and submit the form through the recommended channel for processing.
                            </p>
							<form id="quote-request" class="form-quote" action="{{route('membership.post')}}" method="post">
								<div class="form-group row">
									<div class="form-field col-md-6 form-m-bttm">
										<input name="quote-request-name" type="text" placeholder="Name *" class="form-control required">
									</div>
									<div class="form-field col-md-6">
										<input name="quote-request-company" type="text" placeholder="Company" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<div class="form-field col-md-6 form-m-bttm">
										<input name="quote-request-email" type="email" placeholder="Email *" class="form-control required email">
									</div>
									<div class="form-field col-md-6">
										<input name="quote-request-phone" type="text" placeholder="Phone *" class="form-control required">
									</div>
								</div>
								<h4>Services You Interested</h4>
                                @php
                                    $services = \App\Models\Service::all();
                                    $chunks = $services->chunk(ceil($services->count() / 2));
                                @endphp
								<div class="form-group row">
                                    @foreach ($chunks as $chunk)
									<ul class="form-field clearfix">
                                        @foreach ($chunk as $service)
										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="{{ $service->title }}"> <span> {{ $service->title }}</span></li>
										@endforeach
									</ul>
                                    @endforeach
								</div>
								
								<div class="form-group row">
									<div class="form-field col-md-12">
										<textarea name="quote-request-message" placeholder="Messages *" class="txtarea form-control required"></textarea>
									</div>
								</div>
								<input type="text" class="hidden" name="form-anti-honeypot" value="">
								<div class="g-recaptcha" data-sitekey="6LdNwz0UAAAAAED8ZFtVoXnFKRniFMBh14NReqaZ"></div>
								<div class="gaps"></div>
								<button type="submit" class="btn">Submit</button>
								<div class="form-results"></div>
							</form>
						</div>
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
								<ul class="contact-list">
                                    <li><em class="fa fa-map" aria-hidden="true"></em>
                                        <span>St. George's House, Parliament road,<br 4th floor, Nairobi </span>
                                    </li>
                                    <li><em class="fa fa-phone" aria-hidden="true"></em>
                                        <span>Mobile : (+254) 0720 496 849<br>
                                        Telephone : (+254) 0721 324 019</span>
                                    </li>
                                    <li><em class="fa fa-envelope" aria-hidden="true"></em>
                                        <span>Email : <a href="#">info@nnkstaffsacco.com</a></span>
                                    </li>
                                    <li>
                                        <em class="fa fa-clock-o" aria-hidden="true"></em><span>MNon - Fri: 8AM - 6PM </span>
                                    </li>
                                    <li>
                                        <em class="fa fa-clock-o" aria-hidden="true"></em><span>Sat - Sun: 8AM - 1PM </span>
                                    </li>
                                </ul>
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
						<h3>Looking an Adequate Solution for your Company?</h3>
						<p>Contact us today for free conslutaion or more information.</p>
						<a class="btn btn-outline" href="get-a-quote.html">Get In Touch</a>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- End Section -->


@endsection