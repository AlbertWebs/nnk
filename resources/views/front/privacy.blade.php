@extends('front.master-pages')

@section('content')

   <!-- Contents -->
	<div class="section section-contents section-pad">
		<div class="container">
			<div class="content row">

				<div class="row">
					<div class="col-md-8">
						
                        {{--  --}}
                        <h3>Privacy Policy</h3>
                        <p>
                            NNK Staff Sacco is committed to protecting the privacy of our members and users. This Privacy Policy outlines how we collect, use, and safeguard your personal information when you interact with our website and services.
                        </p>

                        <h3>1. Information Collection</h3>
                        <p>
                            We collect personal information that you voluntarily provide through forms on our website, including your name, contact details, company, and areas of interest. We may also collect technical data such as IP addresses and browser information for analytics purposes.
                        </p>

                        <h3>2. Use of Information</h3>
                        <p>
                            The information we collect is used to process your applications, respond to inquiries, provide services, and improve your experience on our platform. It may also be used for official Sacco communication and reporting.
                        </p>

                        <h3>3. Sharing of Information</h3>
                        <p>
                            NNK Staff Sacco does not sell, rent, or share your personal data with third parties, except as required by law or with service providers who help us operate the website under strict confidentiality agreements.
                        </p>

                        <h3>4. Data Security</h3>
                        <p>
                            We implement appropriate technical and organizational measures to protect your data from unauthorized access, alteration, disclosure, or destruction. However, no online transmission is completely secure, and we cannot guarantee absolute security.
                        </p>

                        <h3>5. Cookies</h3>
                        <p>
                            Our website may use cookies to enhance your browsing experience and gather usage statistics. You can disable cookies in your browser settings, but some features of the site may not function properly as a result.
                        </p>

                        <h3>6. Your Rights</h3>
                        <p>
                            You have the right to access, correct, or request deletion of your personal data. To exercise these rights, please contact us through the details provided on our Contact page.
                        </p>

                        <h3>7. Changes to This Policy</h3>
                        <p>
                            We may update this Privacy Policy periodically. Any changes will be posted on this page with an updated effective date. Continued use of the site implies acceptance of the revised policy.
                        </p>

                        <h3>8. Contact</h3>
                        <p>
                            If you have any questions about this Privacy Policy or how your data is handled, please contact us through our official communication channels.
                        </p>

                        {{--  --}}

						
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