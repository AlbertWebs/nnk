@extends('front.master-pages')

@section('content')

   <!-- Contents -->
	<div class="section section-contents section-pad">
		<div class="container">
			<div class="content row">

				<div class="row">
					<div class="col-md-8">
						<h3>Terms and Conditions</h3>
						<p>
							By accessing and using the NNK Staff Sacco website and its services, you agree to abide by the following terms and conditions. These terms govern your use of the site and participation in any services offered through it.
						</p>

						<h3>1. Membership Eligibility</h3>
						<p>
							Membership is open to individuals who meet the qualifications set forth in the Sacco constitution. All applications are subject to approval by the Sacco’s management committee.
						</p>

						<h3>2. Use of Information</h3>
						<p>
							Information provided on this site is intended for general use and does not constitute financial advice. Members are responsible for verifying the accuracy of any personal or financial information they submit.
						</p>

						<h3>3. Data Privacy</h3>
						<p>
							We respect your privacy and are committed to protecting your personal data. Any information submitted through this site is stored securely and used solely for official Sacco purposes in accordance with our Privacy Policy.
						</p>

						<h3>4. Downloads and Forms</h3>
						<p>
							All downloadable content, including forms and regulations, is provided for your convenience. By downloading and submitting these documents, you confirm that the information provided is accurate and truthful.
						</p>

						<h3>5. Loan and Membership Applications</h3>
						<p>
							Submission of application forms does not guarantee approval. Each application will be reviewed based on the Sacco’s eligibility criteria, credit policies, and member status.
						</p>

						<h3>6. Amendments</h3>
						<p>
							NNK Staff Sacco reserves the right to amend these terms at any time. Users will be notified of changes via the website or official communication channels.
						</p>

						<h3>7. Contact</h3>
						<p>
							For any questions regarding these terms, please contact the Sacco office through the channels listed on our contact page.
						</p>

						
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