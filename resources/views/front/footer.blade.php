<div class="footer-widget section-pad ">
		<div class="container">
			<div class="row">

				<div class="widget-row row">
					<div class="footer-col col-md-5 col-sm-6 col-xs-6 res-m-bttm">
						<!-- Each Widget -->
						<div class="wgs wgs-footer wgs-menu">
							<h5 class="wgs-title">Solutions</h5>
							@php
                                $services = \App\Models\Service::all();
                                $chunks = $services->chunk(ceil($services->count() / 2));
                            @endphp

                            <div class="wgs-content row">
                                @foreach ($chunks as $chunk)
                                    <div class="col-md-6 col-xs-6">
                                        <ul class="menu">
                                            @foreach ($chunk as $service)
                                                <li>
                                                    <a href="{{ url('/services/' . $service->slung) }}">
                                                        {{ $service->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
						</div>
						<!-- End Widget -->
					</div>
					<div class="footer-col col-md-3 col-sm-6 col-xs-6 res-m-bttm">
						<!-- Each Widget -->
						<div class="wgs wgs-footer wgs-menu">
							<h5 class="wgs-title">Legal Info</h5>
							<div class="wgs-content">
								<ul class="menu">
									<li><a href="index-2.html">Privacy Policy</a></li>
									<li><a href="about-us.html">Term and Conditions</a></li>
									<li><a href="news.html">Copyright Statement</a></li>
									<li><a href="resources.html">Rules and Regulations</a></li>
								</ul>
							</div>
						</div>
						<!-- End Widget -->
					</div>
					
					<div class="footer-col col-md-4 col-sm-6 align-center">
						<!-- Each Widget -->
						<div class="wgs wgs-footer">
							<h5 class="wgs-title">Contact us</h5>
							<div class="wgs-content">
								<p><strong>Industrial Company Name</strong><br>
									St. George's House, Parliament road, 4th floor,Nairobi</p>
								<p><span>Toll Free</span>: 222 9281<br>
									<span>Phone</span>: (+254) 723 014032</p>
								<ul class="social">
									<li><a href="#"><em class="fa fa-facebook" aria-hidden="true"></em></a></li>
									<li><a href="#"><em class="fa fa-twitter" aria-hidden="true"></em></a></li>
									<li><a href="#"><em class="fa fa-linkedin" aria-hidden="true"></em></a></li>
                                    <li><a href="#"><em class="fa fa-map-marker" aria-hidden="true"></em></a></li>
								</ul>
							</div>
						</div>
						<!-- End Widget -->
					</div>

				</div>

			</div>
		</div>
	</div>