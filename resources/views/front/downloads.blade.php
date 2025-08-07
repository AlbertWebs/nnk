@extends('front.master-pages')

@section('content')

   <!-- Contents -->
	<div class="section section-contents section-pad">
		<div class="container">
			<div class="content row">

				<div class="row">
					<div class="col-md-8">
						<h1>Resources &amp; Downloads</h1>
						<p>
                            Welcome to the NNK Staff Sacco Downloads section. Here, members and prospective applicants can access essential resources including membership application forms, loan application forms, the Sacco's rules and regulations, and our official constitution. <br><br>
                            These documents are provided to ensure transparency, guide engagement, and support a smooth onboarding and service process. Kindly download the relevant files and follow the instructions provided within each document.
                        </p>
						
						<hr>
						<h3>Downloads</h3>
						<p id="join">

                            Please ensure all forms are filled out accurately (where applicable) and submitted through the appropriate channels for timely processing. We encourage you to read the documents carefully before proceeding.

                        </p>
						<p><a download href="{{url('/')}}/uploads/documents/NNK-MEMBERSHIP-APPLICATI-ON-FORM.pdf"><em class="fa fa-file-pdf-o"></em> Membership Application Form</a></p>
						<p><a download href="{{url('/')}}/uploads/documents/NNK-LOAN-APPLICATIONS-AND-LOAN-AGREEMENT-FORM.pdf"><em class="fa fa-file-pdf-o"></em> Loan Application Form</a></p>
						{{-- <p><a download href="{{url('/')}}/uploads/documents/NNK-SACCO-WELFARE-SCHEME-POLICY.pdf"><em class="fa fa-file-pdf-o"></em> Nnk Sacco Welfare Scheme Policy</a></p> --}}
						
						<hr>
						<h3>Useful links</h3>
						<p>

                          This section provides quick access to important external and internal resources relevant to NNK Staff Sacco members. Whether you're looking to access partner institutions, regulatory bodies, online services, or support portals, our curated list of useful links is here to help you stay informed and connected.

                        </p>
						<ul>
							<li>Members Portal: <a href="#">portal.nnkstaffsacco.com</a></li>
							<li>Mail Login: <a href="#">www.nnkstaffsacco.com/webmail</a></li>
							<li>Contact Us: <a href="#"> www.nnkstaffsacco.com/contact-us</a></li>
						</ul>
						<h5>Looking for something?</h5>
						<p>Contact us at <a href="+254 720 496 849"> 0720 496 849</a> or get in touch with us online.</p>
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