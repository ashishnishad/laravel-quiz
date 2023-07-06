<footer id="dk-footer" class="dk-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="dk-footer-box-info">
                        <a href="{{route('home')}}" class="footer-logo">
                            <img src="{{asset('storage')}}/{{ site_setting('site_logo') }}" alt="footer_logo" class="img-fluid">
                        </a>
                         <p class="footer-info-text">
                             Rinsing, cleaning and bathing has never been so
                             easy! Just slip it on, rinse, and roll!
                         </p>
                        <div class="footer-social-link">
                            <h3>Follow us</h3>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ site_setting('facebook') }}" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                   <a href="{{ site_setting('youtube') }}" target="_blank">
                                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                    </a>
                                </li>
                              
                                <li>
                                    <a href="{{ site_setting('instagram') }}" target="_blank">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Social link -->
                    </div>
                    <!-- End Footer info -->
                </div>
                <!-- End Col -->
                <div class="col-md-8 col-lg-8">
                    <div class="right__footer">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="contact-us">
                                <div class="contact-icon">
                                   <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>{{ site_setting('email') }}</h3>
                                    <p>Email ID</p>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="contact-us contact-us-last">
                                <div class="contact-icon">
                                    <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>{{ site_setting('phone') }}</h3>
                                    <p>Give us a call</p>
                                </div>
                                
                                <!-- End Contact Info -->
                            </div>
                            
                            <!-- End Contact Us -->
                        </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="contact-us contact-us-last">
                                <div class="contact-icon">
                                    <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>{{ site_setting('phone') }}</h3>
                                    <p>Give us a Text</p>
                                </div>
                                
                                <!-- End Contact Info -->
                            </div>
                            
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Contact Row -->
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget footer-left-widget">
                                <div class="section-heading">
                                    <h3>Useful Links</h3>
                                    <span class="animate-border border-black"></span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="{{route('why_rinseroo')}}">Why Rinseroo</a>
                                    </li>
                                    <li>
                                        <a href="{{route('see_in_action')}}">See In Action</a>
                                    </li>
                                    <li>
                                        <a href="{{route('our_story')}}">Our Story</a>
                                    </li>
                                    <li>
                                        <a href="{{route('faq')}}">Faq's</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="{{route('contact')}}">Contact us</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blogs') }}">Cleaning Tips</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products') }}">Product</a>
                                    </li>
                                    
                                </ul>
                            </div>
                            <!-- End Footer Widget -->
                        </div>
                        <!-- End col -->
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget">
                                <div class="section-heading">
                                    <h3>Choose Your Package</h3>
                                    <span class="animate-border border-black"></span>
                                </div>
                                <p><!-- Don’t miss to subscribe to our new feeds, kindly fill the form below. -->
                               NEW, the Rinseroo is a must-have rinsing and cleaning tool for your home. 
                                    
                                    <div class="by_now_in_footer">
                                      <a class="nav-link" href="{{route('products')}}">BUY NOW!</a>     
                                   </div>
                              
                                <!-- End form -->
                            </div>
                            <!-- End footer widget -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>        
                </div>
                <!-- End Col -->
            </div>
            <!-- End Widget Row -->
        </div>
        <!-- End Contact Container -->

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span>Copyright © {{date('Y')}} Rinseroo. All Rights Reserved.</span>
                    </div>
                    <!-- End Col -->
                    <div class="col-md-6">
                        <div class="copyright-menu">
                            <ul>
                                <li>
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('terms_of_use') }}">Terms Of Use</a>
                                </li>
                                <li>
                                    <a href="{{ route('privacy_policy') }}">Privacy Policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Copyright Container -->
        </div>
        <!-- End Copyright -->
        <!-- Back to top -->
        <!-- End Back to top -->
</footer>